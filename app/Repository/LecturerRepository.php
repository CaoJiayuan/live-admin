<?php
/**
 * Created by Cao Jiayuan.
 * Date: 17-6-14
 * Time: 下午2:22
 */

namespace App\Repository;


use App\Entity\Lecturer;
use App\Traits\PermissionHelper;
use Illuminate\Database\Query\Builder;

class LecturerRepository extends Repository
{

  use PermissionHelper;

  public function lecturers()
  {
    return $this->getSearchAbleData(Lecturer::class, ['name'], function ($builder) {
      $room = $this->getAccessibleRoom();
      $roomId = $room ? $room->id : 0;
      /** @var Builder $builder */
      $builder->where('room_id', $roomId);
    });
  }

  public function write($data)
  {
    $room = $this->getAccessibleRoom();
    $roomId = $room ? $room->id : 0;
    $data['room_id'] = $roomId;
    Lecturer::updateOrCreate([
      'id' => $data['id']
    ], $data);
  }
}