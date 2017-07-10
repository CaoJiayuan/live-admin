<?php
/**
 * Created by Cao Jiayuan.
 * Date: 17-5-25
 * Time: 上午10:09
 */

namespace App\Repository\Admin;


use App\Entity\Group;
use App\Traits\PermissionHelper;

class AgentRepository extends AdminRepository
{
  public function getSelectableGroups()
  {
    $builder = Group::groupBy('groups.id');
    $builder->whereIn('id', $this->getGroupIdsByRole());
    return $builder->get();
  }


  protected function getType()
  {
    return 'agent';
  }
}