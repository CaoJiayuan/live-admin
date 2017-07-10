<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entity\Advertisement
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string $title 广告标题
 * @property string $img 广告图片
 * @property string $url 广告链接
 * @property bool $status 0-已删除,1-可用
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Advertisement whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Advertisement whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Advertisement whereImg($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Advertisement whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Advertisement whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Advertisement whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Advertisement whereUrl($value)
 * @property int $room_id 所属房间id
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Advertisement whereRoomId($value)
 */
class Advertisement extends Model
{
  protected $fillable = [
    'title',
    'img',
    'url',
    'status',
    'room_id'
  ];
}
