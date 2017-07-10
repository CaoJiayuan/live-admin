<?php
/**
 * Created by Cao Jiayuan.
 * Date: 17-5-23
 * Time: 上午11:29
 */

namespace App\Http\Controllers;


use App\Entity\Room;
use App\Repository\AreaRepository;

class AreaController extends Controller
{

  public function areas(AreaRepository $repository)
  {
    $data = $repository->areas();
    return view('room.area.index', [
      'data' => $data,
    ]);
  }

  public function addArea()
  {
    return view('room.area.create');
  }

  public function postArea(AreaRepository $repository)
  {
    $data = $this->getValidatedData([
      'name' => 'required',
      'id',
    ]);
    $repository->createOrUpdate($data);
    \Session::flash('message', '保存成功');
    return $this->respondSuccess();
  }

  public function deleteArea(AreaRepository $repository, $id)
  {
    $repository->delete($id);
    return $this->respondSuccess();
  }

  public function deleteRoom(AreaRepository $repository, $id)
  {
    $repository->deleteRooms($id);
    return $this->respondSuccess();
  }
}