<?php
/**
 * Created by Cao Jiayuan.
 * Date: 17-5-5
 * Time: 下午5:21
 */

namespace App\Util;


use App\Repository\PermissionRepository;
use App\User;

class Permission
{
  protected static $permissions = [];

  public static function getPermissions()
  {
    if (!static::$permissions) {
      static::$permissions = (new PermissionRepository())->permissions();
    }
    return static::$permissions;
  }

  public static function can($permission)
  {
    $p = self::find($permission);

    return array_get($p, 'granted', false);
  }

  public static function find($permission)
  {
    $per = self::getPermissions();
    foreach ($per as $item) {
      if (array_get($item, 'name') == $permission) {
        return $item;
      }
    }

    return null;
  }

  public static function any($permissions)
  {
    $permissions = is_array($permissions) ? $permissions : (array)func_get_args();

    foreach ((array)$permissions as $permission) {
      if ($granted = static::can($permission)) {
        return true;
      }
    }

    return false;
  }

  public static function getFilter()
  {
    /** @var User $user */
    $user = \Auth::user();

    if ($user->hasRole(config('roles.super_admin.name'))) {
      return self::getFilterHtml('area') . self::getFilterHtml('room');
    }
    if ($user->hasRole(config('roles.area_admin.name'))) {
      return self::getFilterHtml('room') . '<input type="hidden" id="area-filter" value="' . $user->area_id . '"/>';
    }

    return '<input type="hidden" id="room-filter" value="' . $user->room_id . '"/>';
  }


  protected static function getFilterHtml($type)
  {
    $html = <<<HTML
<div class="col-md-4">
<select name="{$type}" id="{$type}-filter">
</select>
</div>
HTML;
    return $html;
  }
}