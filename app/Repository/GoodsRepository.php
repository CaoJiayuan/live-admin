<?php
/**
 * Created by Cao Jiayuan.
 * Date: 17-5-24
 * Time: 下午4:19
 */

namespace App\Repository;


use App\Entity\Good;
use App\Traits\PermissionHelper;
use Illuminate\Database\Query\Builder;

class GoodsRepository extends Repository
{

  use PermissionHelper;

  public function goods()
  {
    return $this->getSearchAbleData(Good::class, [
      'title',
    ], function ($builder) {
      $room = $this->getAccessibleRoom();
      $roomId = $room ? $room->id : 0;
      /** @var Builder $builder */
      $builder->where('room_id', $roomId);
    });
  }

  public function write($data)
  {
    $room = $this->getAccessibleRoom();
    $roomId = $room ? $room->id : 0;
    $data['room_id'] = $roomId;
    Good::updateOrCreate([
      'id' => $data['id'],
    ], array_except($data, 'id'));
  }
}