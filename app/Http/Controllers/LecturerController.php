<?php
/**
 * Created by Cao Jiayuan.
 * Date: 17-6-14
 * Time: 下午2:16
 */

namespace App\Http\Controllers;


use App\Entity\Lecturer;
use App\Repository\LecturerRepository;

class LecturerController extends Controller
{
  public function lecturers(LecturerRepository $repository)
  {
    $data = $repository->lecturers();
    return view('room.lecturers.index', [
      'data' => $data,
    ]);
  }

  public function create(LecturerRepository $repository)
  {
    $data = $this->getValidatedData([
      'id',
      'name' => 'required',
      'desc'
    ]);
    $repository->write($data);

    $this->respondSuccess();
  }

  public function show($id)
  {
    return Lecturer::where('id', $id)->first();
  }

  public function delete($id)
  {
    Lecturer::destroy($id);
  }
}