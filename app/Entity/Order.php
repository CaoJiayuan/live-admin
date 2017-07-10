<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entity\Order
 *
 * @property int $id
 * @property int $user_id
 * @property int $good_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Order whereGoodId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Order whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Order whereUserId($value)
 * @mixin \Eloquent
 */
class Order extends Model
{

  protected $fillable = [
    'user_id',
    'good_id',
  ];
}
