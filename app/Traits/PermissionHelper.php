<?php
/**
 * Created by Cao Jiayuan.
 * Date: 17-5-23
 * Time: 下午4:12
 */

namespace App\Traits;


use App\Entity\Area;
use App\Entity\Room;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\JoinClause;

trait PermissionHelper
{

  public function getAccessibleRoom()
  {
    $user = \Auth::user();

    if ($user->hasRole(config('roles.super_admin.name'))) {
      return Room::orderBy('id')->first();
    }
    if ($user->hasRole(config('roles.area_admin.name'))) {
      $id = $user->area_id;
      return Room::where('area_id', $id)->where('main', 1)->orderBy('id')->first();
    }

    return Room::find($user->room_id);
  }

  public function getAccessibleArea()
  {
    $user = \Auth::user();

    if ($user->hasRole(config('roles.super_admin.name'))) {
      return Area::orderBy('id')->first();
    }
    if ($user->hasRole(config('roles.area_admin.name'))) {
      $id = $user->area_id;
      return Area::where('id', $id)->first();
    }
    return null;
  }

  /**
   * @param Builder $builder
   * @param $type
   * @return Builder
   */
  public function withRole($builder, $type)
  {
    $builder->rightJoin('role_user', 'user_id', '=', 'users.id');
    $builder->rightJoin('roles', function (JoinClause $clause) use ($type) {
      $role = config("roles.{$type}_admin.name");
      $clause->on('roles.id', '=', 'role_user.role_id');
      $clause->on('roles.name', '=', \DB::raw("'$role'"));
    });

    return $builder;
  }
}