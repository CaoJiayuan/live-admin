<?php
/**
 * Created by Cao Jiayuan.
 * Date: 17-5-25
 * Time: 上午10:09
 */

namespace App\Repository\Admin;


use App\Entity\Group;
use App\Traits\PermissionHelper;

class GroupRepository extends AdminRepository
{
  public function getSelectableGroups($userId = null)
  {
    $room = $this->getAccessibleRoom();
    $roomId = $room ? $room->id : 0;
    $builder = Group::whereNotIn('id', $this->getUsedUserBuilderClosure($userId));
    $builder->where('room_id', $roomId)
      ->groupBy('groups.id');
    return $builder->get();
  }

  protected function getType()
  {
    return 'group';
  }
}