<?php
/**
 * Created by Cao Jiayuan.
 * Date: 17-5-24
 * Time: 上午10:05
 */

namespace App\Repository;


use App\Entity\Group;
use App\Traits\PermissionHelper;
use Illuminate\Database\Query\Builder;
use App\User;

class GroupRepository extends Repository
{

  use PermissionHelper;

  public function groups()
  {
    return $this->getSearchAbleData(Group::class, [
      'name',
    ], function ($builder) {
      $room = $this->getAccessibleRoom();
      $roomId = $room ? $room->id : 0;
      /** @var Builder $builder */
      $builder->where('room_id', $roomId);
      $builder->with('admin');
    });
  }

  public function write($data)
  {
    $room = $this->getAccessibleRoom();
    $roomId = $room ? $room->id : 0;
    $data['room_id'] = $roomId;
    Group::updateOrCreate([
      'id' => $data['id'],
    ], array_except($data, 'id'));
  }
  //获取团队经理
  public function  getGroupByRid($roomid)
  {
   return User::leftJoin('role_user as ru','id','=','ru.user_id')
        ->leftJoin('roles as r','ru.role_id','=','r.id')
        ->where('users.room_id','=',$roomid)
        ->where('r.id','=','4')->select(['users.id','users.username'])->get();
    //return Group::where('room_id',$roomid);
  }

    //获取组下面的业务员
    public function getGroupbusiness($groupid)
    {
        return User::leftJoin('role_user as ru','users.id','=','ru.user_id')
            ->leftJoin('roles as r','ru.role_id','=','r.id')
            ->where('users.group_id','=',$groupid)
            ->where('r.id','=','5')->select(['users.id','users.name'])->get();
    }


  //获取组集合List,不用find方法
 public function getGroupById($gid)
 {
      return Group::where('id',$gid)->get();
 }
  public function getGroupByroomid($roomid)
  {
    return Group::where('room_id',$roomid)->get();
  }

}