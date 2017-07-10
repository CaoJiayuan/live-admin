<?php
/**
 * Created by Cao Jiayuan.
 * Date: 17-6-14
 * Time: 下午2:22
 */

namespace App\Repository;


use App\Entity\Gift;
use App\Traits\PermissionHelper;
use Illuminate\Database\Query\Builder;

class GiftRepository extends Repository
{

  use PermissionHelper;

  public function gifts()
  {
    return $this->getSearchAbleData(Gift::class, ['name'], function ($builder) {
      $room = $this->getAccessibleRoom();
      $roomId = $room ? $room->id : 0;
      /** @var Builder $builder */
      $builder->where('gifts.room_id', $roomId);
      $builder->leftJoin('gift_categories', 'gift_category_id', '=', 'gift_categories.id');
      $builder->select([
        'gifts.*',
        'gift_categories.name as cate_name',
      ]);
    });
  }

  public function write($data)
  {
    $room = $this->getAccessibleRoom();
    $roomId = $room ? $room->id : 0;
    $data['room_id'] = $roomId;
    Gift::updateOrCreate([
      'id' => $data['id'],
    ], array_except($data, ['id']));
  }
}