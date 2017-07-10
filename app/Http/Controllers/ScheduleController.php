<?php
/**
 * Created by Cao Jiayuan.
 * Date: 17-6-14
 * Time: 下午2:16
 */

namespace App\Http\Controllers;

use App\Entity\Schedule;
use App\Repository\LecturerRepository;
use App\Repository\ScheduleRepository;
use Carbon\Carbon;

class ScheduleController extends Controller
{
  public function schedules(ScheduleRepository $repository, LecturerRepository $lecturerRepository)
  {
    $data = $repository->schedules();
    $lecturers = $lecturerRepository->lecturers()->getCollection();
    return view('room.schedules.index', [
      'data'      => $data,
      'lecturers' => $lecturers,
    ]);
  }

  public function create(ScheduleRepository $repository)
  {
    $data = $this->getValidatedData([
      'id',
      'time',
      'lecturer_id' => 'required',
      'day',
      'hour',
      'title' => 'required',
    ],[],[
      'title' => '标题'
    ]);

    $data['time'] = Carbon::createFromTimestamp($data['time']);
    $repository->write($data);

    return $this->respondSuccess();
  }

  public function show($id)
  {
    return Schedule::where('id', $id)->first();
  }

  public function delete($id)
  {
    Schedule::destroy($id);
  }
}