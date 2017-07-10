<?php
/**
 * Created by Cao Jiayuan.
 * Date: 17-5-25
 * Time: 上午9:17
 */

namespace App\Http\Controllers\Admin;


use App\Entity\Group;
use App\Entity\Room;
use App\Http\Controllers\Controller;
use App\Repository\Admin\AdminRepository;
use App\User;

class MainController extends Controller
{
  protected $customAttributes = [
    'name'     => '姓名',
    'username' => '帐号',
    'mobile'   => '电话',
    'password' => '密码',
    'area_id'  => '区域',
    'room_id'  => '房间',
    'group_id'  => '团队',
  ];

  public function getValidatedUserData($roles)
  {
    $data = $this->getValidatedData($roles, [], $this->customAttributes);

    return $data;
  }

  public function status($type, $id)
  {
    User::where('id', $id)->update([
      'enable' => \DB::raw('!enable'),
    ]);
    return redirect()->back();
  }

  public function checkExists($id, $data)
  {
    if (\DB::table('users')->where('id', '!=', $id)->where('mobile', $data['mobile'])->exists()) {
      return redirect()->back()->withErrors([
        'mobile' => '电话已经存在',
      ]);
    }
    return 0;
  }

  public function getFieldsByDataColumn($data, $column)
  {
    if ($column == 'room_id') {
      if ($room = Room::find(array_get($data, 'room_id'))) {
        return array_merge($data, [
          'area_id' => $room->area_id
        ]);
      }
    }
    if ($column == 'group_id') {
      if ($group = Group::find(array_get($data, 'group_id'))) {
        $roomId = 0;
        $areaId = 0;
        if ($room = $group->room) {
          $roomId = $room->id;
          $areaId = $room->area_id;
        }
        return array_merge($data, [
          'room_id' => $roomId,
          'area_id' => $areaId,
        ]);
      }
    }
    return $data;
  }
}