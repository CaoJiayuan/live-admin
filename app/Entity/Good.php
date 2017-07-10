<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entity\Good
 *
 * @property int $id
 * @property int $room_id 所属房间id
 * @property string $title
 * @property string $img
 * @property int $credits
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Good whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Good whereCredits($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Good whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Good whereImg($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Good whereRoomId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Good whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Good whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Good extends Model
{
  protected $fillable = [
    'room_id',
    'title',
    'img',
    'credits',
    'status',
  ];
}
