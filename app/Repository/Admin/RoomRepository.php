<?php
/**
 * Created by Cao Jiayuan.
 * Date: 17-5-25
 * Time: 上午10:09
 */

namespace App\Repository\Admin;


use App\Entity\Room;
use App\Traits\PermissionHelper;

class RoomRepository extends AdminRepository
{
  public function getSelectableRooms($userId = null)
  {
    $area = $this->getAccessibleArea();
    $areaId = $area ? $area->id : 0;
    $builder = Room::whereNotIn('id', $this->getUsedUserBuilderClosure($userId));
    $builder->where('area_id', $areaId)
      ->where('main', '=', 0)
      ->groupBy('rooms.id');
    return $builder->get();
  }

  protected function getType()
  {
    return 'room';
  }
}