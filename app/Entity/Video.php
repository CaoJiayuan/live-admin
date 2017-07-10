<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entity\Video
 *
 * @property int $id
 * @property int $room_id 所属房间id
 * @property string $url 流url
 * @property int $type 类型
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Video whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Video whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Video whereRoomId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Video whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Video whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Video whereUrl($value)
 * @mixin \Eloquent
 * @property string $mobile_url
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Video whereMobileUrl($value)
 */
class Video extends Model
{

  protected $fillable = [
    'room_id', 'url', 'type','mobile_url'
  ];
}
