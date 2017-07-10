<?php
/**
 * Created by Cao Jiayuan.
 * Date: 17-5-24
 * Time: 下午5:20
 */

namespace App\Repository\Admin;


use App\Entity\Group;
use App\Entity\Role;
use App\Repository\Repository;
use App\Traits\PermissionHelper;
use App\User;
use Illuminate\Database\Query\Builder;

abstract class AdminRepository extends Repository
{
  use PermissionHelper;
  protected $types = [
    'area', 'room', 'group', 'agent',
  ];

  public function getList($type)
  {
    return $this->getSearchAbleData(User::class, [
      'username', 'last_ip', 'name', 'nickname', 'online', 'last_login', 'mobile',
    ], function ($builder) use ($type) {
      /** @var Builder $builder */
      $builder->leftJoin('role_user', 'user_id', '=', 'users.id');
      $builder->leftJoin('roles', 'role_id', '=', 'roles.id');
      $builder->where('roles.name', config("roles.{$type}_admin.name"));
      $builder->groupBy('users.id');
      $this->withFieldCondition($builder, $type);
      $builder->select(['users.*']);
    });
  }

  /**
   * @param Builder $builder
   * @param $type
   * @return mixed
   */
  public function withFieldCondition($builder, $type)
  {
    switch ($type) {
      case 'room' :
        $area = $this->getAccessibleArea();
        $id = $area ? $area->id : 0;
        $builder->where('area_id', $id);
        break;
      case 'group':
        $room = $this->getAccessibleRoom();
        $id = $room ? $room->id : 0;
        $builder->where('room_id', $id);
        break;
      case 'agent':
        $builder->whereIn('group_id', $this->getGroupIdsByRole());
        break;
    }

    return $builder;
  }

  public function getGroupIdsByRole()
  {
    /** @var User $user */
    $user = \Auth::user();
    $roles = config('roles');
    $groups = [];
    if ($user->hasRole(array_get($roles, 'room_admin.name'))) {
      $groups = Group::whereRoomId($user->room_id)->get();
    }
    if ($user->hasRole(array_get($roles, 'group_admin.name'))) {
      $groups = Group::whereId($user->group_id)->get();
    }
    $ids = [];
    foreach ($groups as $group) {
      $ids[] = $group['id'];
    }

    return $ids;
  }


  /**
   * @param $data
   * @return \Illuminate\Database\Eloquent\Model|User
   */
  public function updateOrCreate($data)
  {
    $id = array_get($data, 'id');
    $id || $data['username'] = array_get($data, 'mobile');
    $attr = array_remove_empty($data);

    if ($user = User::find($id)) {
      $user->update($attr);
    } else {
      $attr['password'] = bcrypt(substr($attr['mobile'], -6));
      $user = User::create($attr);
    }

    return $user;
  }

  public function getUsedUserBuilderClosure($userId = null)
  {
    return function ($builder) use ($userId) {
      $type = $this->getType();
      /** @var Builder $builder */
      $builder->from('users');
      $builder->leftJoin('role_user', 'user_id', '=', 'users.id');
      $builder->leftJoin('roles', 'role_id', '=', 'roles.id');
      $builder->where('roles.name', config("roles.{$type}_admin.name"));
      $userId && $builder->where('users.id', '!=', $userId);
      $builder->select(["{$type}_id"]);
    };
  }

  public function write($data)
  {
    \DB::transaction(function () use ($data) {
      $type = $this->getType();
      $user = $this->updateOrCreate($data);
      $area = config("roles.{$type}_admin.name");
      !$user->hasRole($area) && $user->attachRole(Role::where('name', $area)->first());
      if ($type == 'agent') {
        $user->update([
          'agent_id' => $user->id
        ]);
      }
    });
  }


  abstract protected function getType();
}