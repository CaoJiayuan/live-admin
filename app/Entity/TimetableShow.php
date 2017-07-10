<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entity\TimeTableShow
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
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\TimetableShow whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\TimetableShow whereDay($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\TimetableShow whereHour($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\TimetableShow whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\TimetableShow whereLecturerId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\TimetableShow whereRoomId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\TimetableShow whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\TimetableShow whereTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\TimetableShow whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\TimetableShow whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TimetableShow extends Model
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
