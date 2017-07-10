<?php
/**
 * Created by Cao Jiayuan.
 * Date: 17-5-24
 * Time: 下午4:19
 */

namespace App\Repository;


use App\Entity\Service;
use App\Traits\PermissionHelper;
use Illuminate\Database\Query\Builder;

class ServiceRepository extends Repository
{

  use PermissionHelper;

  public function services()
  {
    return $this->getSearchAbleData(Service::class, [
      'qq', 'name'
    ],  function ($builder) {
      $room = $this->getAccessibleRoom();
      $roomId = $room ? $room->id : 0;
      /** @var Builder $builder */
      $builder->where('room_id', $roomId);
    });
  }

  public function writeService($data)
  {
    $room = $this->getAccessibleRoom();
    $roomId = $room ? $room->id : 0;
    $data['room_id'] = $roomId;
    Service::updateOrCreate([
      'id' => $data['id']
    ], array_except($data, 'id'));
  }
}