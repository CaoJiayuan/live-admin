<?php
/**
 * Created by Cao Jiayuan.
 * Date: 17-6-14
 * Time: 下午2:22
 */

namespace App\Repository;


use App\Entity\Timetable;
use App\Entity\TimetableShow;
use App\Traits\PermissionHelper;
use Carbon\Carbon;

class ScheduleRepository extends Repository
{

  use PermissionHelper;

  protected $week = [
    1 => 'Monday',
    2 => 'Tuesday',
    3 => 'Wednesday',
    4 => 'Thursday',
    5 => 'Friday',
    6 => 'Saturday',
    7 => 'Sunday',
  ];

  public function schedules()
  {

    $room = $this->getAccessibleRoom();
    $roomId = $room ? $room->id : 0;
    Timetable::whereRoomId($roomId)->where('time', '<', Carbon::createFromTimestamp(strtotime('Monday this week')))->update([
      'status' => 0,
    ]);
    $tables = TimetableShow::orderBy('hour')
      ->where('timetable_shows.room_id', $roomId)
      ->leftJoin('lecturers', 'lecturer_id', '=', 'lecturers.id')
      ->orderBy('day')->get([
        'timetable_shows.*',
        'lecturers.name as lecturer',
      ])->groupBy('hour');

    return $this->reformatTables($tables);
  }

  public function reformatTables($tables)
  {
    $ts = [];
    $tables->each(function ($row, $day) use (&$ts) {
      $ts[$day] = $row->groupBy('day');
    });
    $hours = range(9, 22);
    $days = range(1, 7);
    $result = [];
    foreach ($hours as $hour) {
      $row = array_get($ts, $hour, []);
      $r = [];
      foreach ($days as $day) {
        $cell = array_get($row, $day, [
          [
            'id'          => null,
            'title'       => null,
            'hour'        => $hour,
            'day'         => $day,
            'lecturer'    => null,
            'time'        => Carbon::createFromTimestamp(strtotime($this->week[$day] . ' this week'))->addHours($hour)->timestamp,
            'lecturer_id' => null,
          ],
        ]);
        $r[] = array_get($cell, 0, null);
      }
      $result[$hour] = $r;
    }

    return $result;
  }

  public function write($data)
  {
    $room = $this->getAccessibleRoom();
    $roomId = $room ? $room->id : 0;
    $data['room_id'] = $roomId;
    \DB::beginTransaction();
    TimetableShow::updateOrCreate([
      'id' => $data['id'],
    ], $data);
    Timetable::updateOrCreate(array_only($data, [
      'hour',
      'day',
      'time',
      'room_id',
    ]), $data);
    \DB::commit();
  }
}