<?php
/**
 * Created by Cao Jiayuan.
 * Date: 17-5-24
 * Time: 下午5:12
 */

namespace App\Repository\Admin;

use App\Entity\Area;
use App\Entity\Role;

class AreaRepository extends AdminRepository
{
  public function getSelectableAreas($userId = null)
  {
    $builder = Area::whereNotIn('id', $this->getUsedUserBuilderClosure($userId));
    $builder->groupBy('areas.id');
    return $builder->get();
  }

  protected function getType()
  {
    return 'area';
  }
}