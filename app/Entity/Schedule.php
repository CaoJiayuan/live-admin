<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entity\Schedule
 *
 * @property int $id
 * @property string $time 时间段
 * @property string $mon 周一
 * @property string $tue
 * @property string $wed
 * @property string $thu
 * @property string $fri
 * @property string $sat
 * @property string $sun 周日
 * @property int $room_id 所属房间id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Schedule whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Schedule whereFri($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Schedule whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Schedule whereMon($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Schedule whereRoomId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Schedule whereSat($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Schedule whereSun($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Schedule whereThu($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Schedule whereTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Schedule whereTue($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Schedule whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Schedule whereWed($value)
 * @mixin \Eloquent
 */
class Schedule extends Model
{
  protected $fillable = [
    'time',
    'mon',
    'tue',
    'wed',
    'thu',
    'fri',
    'sat',
    'sun',
    'room_id',
  ];
}
