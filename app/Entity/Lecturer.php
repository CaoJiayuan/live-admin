<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entity\Lecturer
 *
 * @property int $id
 * @property string $name
 * @property string $desc 讲师介绍
 * @property string $qq qq
 * @property string $mobile 手机号
 * @property string $avatar 头像
 * @property bool $gender 性别
 * @property bool $enable 是否启用
 * @property int $room_id 所属房间id
 * @property int $group_id 所属团队id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Lecturer whereAvatar($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Lecturer whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Lecturer whereDesc($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Lecturer whereEnable($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Lecturer whereGender($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Lecturer whereGroupId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Lecturer whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Lecturer whereMobile($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Lecturer whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Lecturer whereQq($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Lecturer whereRoomId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Lecturer whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Lecturer extends Model
{
  protected $fillable = [
    'name',
    'desc',
    'qq',
    'mobile',
    'avatar',
    'gender',
    'enable',
    'room_id',
    'group_id',
  ];
}
