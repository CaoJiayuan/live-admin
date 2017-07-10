<?php
/**
 * Created by Cao Jiayuan.
 * Date: 17-5-23
 * Time: 下午4:24
 */

namespace App\Http\Controllers;


use App\Entity\Area;
use App\Entity\Room;
use App\Entity\Group;
use App\User;

class FilterController extends Controller
{

  public function areas()
  {
    return Area::orderBy('id')->get()->toArray();
  }

  public function rooms($areaId, $main = null)
  {
    $builder = Room::whereAreaId($areaId)->orderBy('main', 'desc');
    $builder->orderBy('id');
    if ($main === '0')
    {
      $builder->where('main','=',0);
    }
    return $builder->get()->toArray();
  }

  public function groups($roomId)
  {
    return Group::whereRoomId($roomId)->orderBy('id', 'desc')->get()->toArray();
  }

  public function agents($groupId)
  {
    $builder = User::join('role_user', 'role_user.user_id', '=', 'users.id');
    $builder = $builder->join('roles', function ($join) {
      $join->on('roles.id', '=', 'role_user.role_id')
        ->where('roles.name', '=', 'agent_admin');
    });
    $builder = $builder->select('users.*');
    return $builder->whereGroupId($groupId)->get()->toArray();
  }

  public function masters($agentId)
  {
    return User::whereAgentId($agentId)->whereNull('master_id')->get()->toArray();
  }
}