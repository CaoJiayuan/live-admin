<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entity\Timetable
 *
 * @property int $id
 * @property int $lecturer_id
 * @property string $title
 * @property bool $hour
 * @property bool $day
 * @property string $time
 * @property bool $status
 * @property int $room_id 所属房间id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Timetable whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Timetable whereDay($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Timetable whereHour($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Timetable whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Timetable whereLecturerId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Timetable whereRoomId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Timetable whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Timetable whereTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Timetable whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Timetable whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Timetable extends Model
{
  protected $fillable = [
    'lecturer_id',
    'title',
    'hour',
    'day',
    'time',
    'status',
    'room_id',
  ];

  protected $casts = [
    'time' => 'timestamp'
  ];
}
