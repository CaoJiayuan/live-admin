<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entity\Popup
 *
 * @property int $id
 * @property int $room_id 所属房间id
 * @property string $img
 * @property string $url
 * @property bool $enable
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Popup whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Popup whereEnable($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Popup whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Popup whereImg($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Popup whereRoomId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Popup whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Popup whereUrl($value)
 * @mixin \Eloquent
 */
class Popup extends Model
{

  protected $fillable = [
    'room_id',
    'img',
    'url',
    'enable',
  ];
}
