<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entity\Notice
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string $title 标题
 * @property string $content 内容
 * @property string $published_at 发布时间
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Notice whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Notice whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Notice whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Notice wherePublishedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Notice whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Notice whereUpdatedAt($value)
 * @property int $room_id 所属房间id
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Notice whereRoomId($value)
 * @property bool $enable
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Notice whereEnable($value)
 */
class Notice extends Model
{
  protected $fillable = [
    'content',
    'published_at',
    'room_id',
    'enable'
  ];
}
