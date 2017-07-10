<?php
/**
 * Created by Cao Jiayuan.
 * Date: 17-7-4
 * Time: 上午11:21
 */

namespace App\Repository;


use App\Entity\Order;
use App\Traits\PermissionHelper;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;

class OrderRepository extends Repository
{

  use PermissionHelper;

  public function orders()
  {
    return $this->getSearchAbleData(Order::class, ['goods.title', 'users.nickname','users.mobile'], function ($builder) {
      $room = $this->getAccessibleRoom();
      $roomId = $room ? $room->id : 0;
      /** @var Builder $builder */
      $builder->where('orders.id','>',0)->rightJoin('goods', function (JoinClause $clause) use ($roomId) {
        $clause->on('good_id', '=', 'goods.id');
        $clause->on('goods.room_id', '=', \DB::raw("'$roomId'"));
      });
      $builder->leftJoin('users', 'user_id', '=', 'users.id');

      $builder->select([
        'orders.id',
        'goods.title as good_name',
        'goods.credits',
        'users.nickname',
        'users.mobile',
        'orders.created_at',
        'orders.status',
      ])->groupBy('orders.id');
    });
  }
}