<?php
/**
 * Created by Cao Jiayuan.
 * Date: 17-5-24
 * Time: 下午4:19
 */

namespace App\Repository;


use App\Entity\CreditRule;
use App\Entity\Service;
use App\Traits\ApiResponse;
use App\Traits\PermissionHelper;
use Illuminate\Database\Query\Builder;

class CreditsRepository extends Repository
{

  use PermissionHelper,ApiResponse;

  public function credits()
  {
    return $this->getSearchAbleData(CreditRule::class, [],  function ($builder) {
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
    if (CreditRule::where('room_id', $roomId)->where('id','!=', $data['id'])->where('minutes', $data['minutes'])->exists()) {
      $this->respondMessage(422, '已经添加过该分钟数的积分规则了');
    }
    CreditRule::updateOrCreate([
      'id' => $data['id']
    ], array_except($data, 'id'));
  }
}