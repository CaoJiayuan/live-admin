<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entity\Service
 *
 * @property int $id
 * @property int $room_id 所属房间id
 * @property string $qq 客服qq
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Service whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Service whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Service whereQq($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Service whereRoomId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Service whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $name 客服名称
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Service whereName($value)
 */
class Service extends Model
{
  protected $fillable = [
    'room_id', 'qq', 'name'
  ];
}
