<?php
/**
 * Created by Cao Jiayuan.
 * Date: 17-6-1
 * Time: 下午4:30
 */

namespace App\Repository;


use App\Entity\Advertisement;
use App\Traits\PermissionHelper;
use Illuminate\Database\Query\Builder;

class AdRepository extends Repository
{
  use PermissionHelper;

  public function banners()
  {
    return $this->getSearchAbleData(Advertisement::class, [
      'title',
      'img',
      'url',
    ], function ($builder) {
      $room = $this->getAccessibleRoom();
      $roomId = $room ? $room->id : 0;
      /** @var Builder $builder */
      $builder->where('room_id', $roomId);
    });
  }

  public function writeBanner($data)
  {
    $room = $this->getAccessibleRoom();
    $roomId = $room ? $room->id : 0;
    $data['room_id'] = $roomId;
    Advertisement::updateOrCreate([
      'id' => $data['id'],
    ], array_except($data, 'id'));
  }
}