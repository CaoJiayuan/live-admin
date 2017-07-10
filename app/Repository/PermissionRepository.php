<?php
/**
 * Created by Cao Jiayuan.
 * Date: 17-3-1
 * Time: 下午2:20
 */

namespace App\Repository;
use App\Entity\Permission;
use App\Entity\Role;
use App\User;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\JoinClause;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class PermissionRepository extends Repository
{
  public function tree()
  {
    return Permission::tree();
  }

  public function getRoles($api = false)
  {

    if ($api) {
      return Role::get()->toArray();
    }
    return $this->getSearchAbleData(Role::class, [
      'name', 'display_name', 'description'
    ], function ($builder) {
      $pre = \DB::getTablePrefix();
      $su = config('entrust.super_admin.name');
      /** @var Builder $builder */
      $builder->leftJoin('permission_role', 'role_id', '=', 'roles.id');
      $builder->leftJoin('permissions', function (JoinClause $clause) {
        $clause->on('permission_id', '=', 'permissions.id');
        $clause->on('permissions.type', '=', \DB::raw(0));
      });
      $builder->groupBy('roles.id');
      $builder->select([
        'roles.*',
        \DB::raw("CASE WHEN {$pre}roles.name = '{$su}' THEN '所有权限' ELSE GROUP_CONCAT({$pre}permissions.display_name separator ' ') END AS permissions"),
        \DB::raw("CASE WHEN {$pre}roles.name IN ('$su') THEN false ELSE true END AS edit_able"),
        \DB::raw("CASE WHEN {$pre}roles.name IN ('$su') THEN false ELSE true END AS delete_able"),
      ]);
    });
  }

  public function createOrUpdateRole($data)
  {
    return \DB::transaction(function () use ($data) {
      if ($id = array_get($data, 'id')) {
        $su = config('entrust.super_admin.name');
        if (Role::whereId($id)->whereIn('name', [$su])->exists()) {
          throw new HttpException(403, '该角色不能编辑');
        }
        if (Role::whereName(array_get($data, 'name'))->where('id','!=', $id)->exists()) {
          throw new UnprocessableEntityHttpException('角色名已存在!');
        }
        /** @var Role $role */
        $role = Role::find($id);
        $role->update(array_only($data, [
          'name', 'display_name'
        ]));
      } else {
        if (Role::whereName(array_get($data, 'name'))->exists()) {
          throw new UnprocessableEntityHttpException('角色名已存在!');
        }
        $role = Role::create($data);
      }

      $this->attachPermissions($role, array_get($data, 'permissions', []));
      return $role;
    });
  }

  /**
   * @param Role $role
   * @param $permissions
   */
  public function attachPermissions($role, $permissions)
  {
    $ps = [];

    $this->findPermissions($permissions, $ps);
    $role->resetPermissions($ps);
  }

  public function findPermissions($permissions, &$result = [])
  {
    foreach ($permissions as $permission) {
      if (array_get($permission, 'granted')) {
        $result[] = array_only($permission, ['id', 'name', 'display_name']);
      }
      $this->findPermissions(array_get($permission, 'node', []), $result);
    }
  }

  public function deleteRole($id)
  {
    $su = config('entrust.super_admin.name');

    if (Role::whereId($id)->whereIn('name', [
      $su
    ])->exists()
    ) {
      throw new HttpException(403, '该角色不能删除');
    }
    return \DB::transaction(function () use ($id) {
      Role::del($id);
    });
  }

  public function role($id)
  {
    $su = config('entrust.super_admin.name');

    $pre = \DB::getTablePrefix();
    $builder = Role::select([
      'roles.*',
      \DB::raw("CASE WHEN {$pre}roles.name IN ('$su') THEN false ELSE true END AS change_name"),
    ]);
    $role = $builder->find($id)->toArray();
    Permission::$roles = [$role];
    $tree = Permission::tree();
    $role['permissions'] = $tree;
    return $role;
  }

  public function admins()
  {
    return $this->getSearchAbleData(User::class, ['name', 'email', 'id', 'mobile'], function ($builder) {
      $userId = \Auth::id();
      /** @var Builder $builder */
      $builder->leftJoin('role_admin', 'role_admin.admin_id', '=', 'admins.id');
      $builder->leftJoin('roles', 'role_admin.role_id', '=', 'roles.id');
      $builder->orWhere('roles.name', null);
      $builder->groupBy('admins.id');
      $pre = \DB::getTablePrefix();
      $builder->select([
        'admins.*',
        \DB::raw("GROUP_CONCAT({$pre}roles.display_name separator ' ') AS roles"),
        \DB::raw("CASE WHEN {$pre}admins.id = $userId THEN false ELSE TRUE END AS deletable"),
      ]);
    });
  }

  public function roles()
  {
    return Role::get()->toArray();
  }

  public function createOrUpdateAdmin($data)
  {
    return \DB::transaction(function () use ($data) {
      $attributes = array_only($data, [
        'name', 'email', 'mobile'
      ]);
      if ($id = array_get($data, 'id')) {
        $admin = User::find($id);
        if ($pass = array_get($data, 'password')) {
          $attributes['password'] = bcrypt($pass);
        }
        $admin->update($attributes);
      } else {
        if (User::where('mobile', array_get($data, 'mobile'))->exists()) {
          throw new UnprocessableEntityHttpException('手机号已被注册');
        }
        $pass = 123456;
        $attributes['password'] = bcrypt($pass);
        $this->emailPassword(array_get($data, 'email'), $pass);
        /** @var User $admin */
        $admin = User::create($attributes);
      }
      if (isset($data['roles'])) {
        $admin->resetRoles(array_get($data, 'roles'));
      }
      return $admin;
    });
  }

  public function emailPassword($email, $password)
  {
//    \Log::debug("Send email[$email] >>>>>>>>>>> password :[$password]<<<<<<<<<<<<<<<<<");
  }

  public function admin($id)
  {
    $user = User::with('roles')->find($id);
    if (!$user) {
      throw new NotFoundHttpException('用户不存在');
    }
    return $user->toArray();
  }

  public function deleteAdmin($id)
  {
    \DB::transaction(function () use ($id) {
      /** @var User $user */
      $user = User::find($id);
      if (!$user) {
        throw new NotFoundHttpException('用户不存在');
      }
      $user->clearRoles()->delete();
    });
  }

  public function navigation()
  {
    $user = \Auth::user();
    Permission::$roles = $user->roles->toArray();

    return Permission::tree();
  }

  public function permissions()
  {
    $user = \Auth::user();
    $roles = $user->roles;
    $ids = [];
    foreach ($roles as $role) {
      $ids[] = $role->id;
    }
    $prefix = \DB::getTablePrefix();
    $i = implode(',', $ids) ?: "''";
    $builder = Permission::leftJoin('permission_role', function (JoinClause $clause) use ($ids) {
      $clause->on('permission_role.permission_id', '=', 'permissions.id');
      $clause->whereIn('permission_role.role_id', $ids);
    });
    $select = \DB::raw("CASE WHEN {$prefix}permission_role.role_id IS NOT NULL THEN true ELSE false END AS granted");
    $su = config('entrust.super_admin.name');
    foreach ($roles as $role) {
      if (array_get($role, 'name') == $su) {
        $select = \DB::raw("true AS granted");
        break;
      }
    }

    return $builder->select([
      'permissions.*',
      $select
    ])->get()->toArray();
  }
}