<?php
/**
 * Created by Cao Jiayuan.
 * Date: 17-5-15
 * Time: 下午2:55
 */

namespace App\Repository;


use App\Entity\Scoop;

class InfoRepository extends Repository
{

  public function scoops()
  {
    return $this->getSearchAbleData(Scoop::class, [
      'title',
      'from',
      'summary',
      'thumbnail',
    ]);
  }

  public function saveScoop($data)
  {
    Scoop::updateOrCreate([
      'id' => $data['id']
    ], array_except($data, 'id'));
  }
}