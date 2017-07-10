<?php
use App\Entity\Permission;
use App\Entity\Role;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Created by Cao Jiayuan.
 * Date: 17-3-1
 * Time: 上午11:21
 */
class NavSeeder extends Seeder
{

  public function run()
  {
    DB::table('permissions')->truncate();
    DB::table('roles')->truncate();
    DB::table('permission_role')->truncate();
    Model::unguard();
    $permissions = config('permissions', []);
    $this->seedPermissions($permissions);
    $this->seedRoles();
    Model::reguard();
  }

  public function seedRoles()
  {
    $roles = config('roles');
    foreach ($roles as $name => $role) {
      $r = Role::create($role);
      if ($name == 'super_admin') {
        $this->seedAdmin($r);
      }
      $type = Str::camel($name);
      $this->{$type . 'Permission'}($r);
    }
  }

  /**
   * @param Role $r
   */
  public function superAdminPermission($r)
  {
    $r->attachPermissions(Permission::getByNames([
      'home',
      'room', 'room.areas',
      'users', 'users.index', 'users.online.index', // 用户管理
      'admin', 'admin.areas',
      'statistics', 'statistics.login', 'statistics.online', 'statistics.history', 'statistics.area'
    ]));
  }

  /**
   * @param Role $r
   */
  public function areaAdminPermission($r)
  {
    $r->attachPermissions(Permission::getByNames([
      'home',
      'room', 'room.rooms','room.services', 'room.setting',
//      'room.groups',
      'room.votes',
      'room.popups','room.services','room.notices','room.copyright','room.disclaimer','room.banners',
      'room.lecturers','room.schedules','room.interactive','room.goldLecturer','room.gifts', 'room.goods','room.orders',

      'credits','credits.online', 'credits.others',


      'users', 'users.index', 'users.online.index', // 用户管理
      'admin', 'admin.rooms','admin.groupsl',
      'statistics', 'statistics.login', 'statistics.online', 'statistics.history', 'statistics.room',
    ]));
  }

  /**
   * @param Role $r
   */
  public function roomAdminPermission($r)
  {
    $r->attachPermissions(Permission::getByNames([
      'home',
      'room', 'room.services', 'room.setting',
//      'room.groups',
      'room.votes','room.popups','room.services','room.notices',
      'room.copyright','room.disclaimer','room.banners','room.interactive', 'room.goods','room.orders',

      'credits', 'credits.others',

      'users', 'users.add', 'users.edit', 'users.banip', 'users.status', 'users.disable','users.index', 'users.online.index', // 用户管理
      'admin', 'admin.groups', 'admin.agents','admin.groupsl',
      'statistics', 'statistics.login', 'statistics.online', 'statistics.history',  'statistics.group',
    ]));
  }

  /**
   * @param Role $r
   */
  public function groupAdminPermission($r)
  {
    $r->attachPermissions(Permission::getByNames([
      'home',
      'users', 'users.add', 'users.edit', 'users.banip', 'users.status', 'users.disable','users.index', 'users.online.index','users.robots.index','users.robots.add','users.robots.edit','users.robots.delete', // 用户管理
      'admin', 'admin.agents',
      'statistics', 'statistics.login', 'statistics.online', 'statistics.history', 'statistics.groupjl',
    ]));
  }

  /**
   * @param Role $r
   */
  public function agentAdminPermission($r)
  {
    $r->attachPermissions(Permission::getByNames([
      'home',
      'users', 'users.add', 'users.edit', 'users.banip', 'users.status', 'users.disable','users.index', 'users.online.index','users.robots.index','users.robots.add','users.robots.edit','users.robots.delete', // 用户管理
      'statistics', 'statistics.login', 'statistics.online', 'statistics.history',
    ]));
  }

  public function seedAdmin($role)
  {
    /** @var User $admin */
    $attributes = config('entrust.super_admin');
    $attributes['password'] = bcrypt($attributes['password']);
    $admin = User::updateOrCreate([
      'username' => $attributes['username'],
    ],$attributes);

    if (!$admin->hasRole($role->name)) {
      $admin->attachRole($role);
    }
  }

  public function seedPermissions($permissions, $parentId = null)
  {
    $pId = 0;
    $parentId && $pId = $parentId;
    foreach ($permissions as $permission) {
      $attributes = array_only($permission, ['path', 'name', 'display_name', 'icon', 'description', 'type']);
      $attributes['parent_id'] = $pId;
      $p = Permission::create($attributes);
      $this->seedPermissions(array_get($permission, 'node', []), $p->id);
    }
  }
}