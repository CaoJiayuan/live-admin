<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entity\RoomBackground
 *
 * @property int $id
 * @property int $room_id 所属房间id
 * @property string $background 背景
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\RoomBackground whereBackground($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\RoomBackground whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\RoomBackground whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\RoomBackground whereRoomId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\RoomBackground whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class RoomBackground extends Model
{

  protected $fillable = ['background', 'room_id'];
}
