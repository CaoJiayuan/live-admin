<?php
/**
 * Created by Cao Jiayuan.
 * Date: 17-5-25
 * Time: 上午10:03
 */

namespace App\Http\Controllers\Admin;

use App\Repository\Admin\RoomRepository;
use App\User;

class RoomController extends MainController
{

  public function rooms(RoomRepository $repository)
  {
    $data = $repository->getList('room');
    return view('admin.rooms.index', [
      'data' => $data,
    ]);
  }

  public function create(RoomRepository $repository)
  {
    $rooms = $repository->getSelectableRooms();

    return $rooms;
  }


  public function post(RoomRepository $repository)
  {
    $data = $this->getValidatedUserData([
      'room_id'  => 'required',
      'name'     => 'required',
      'mobile'   => 'required|mobile|unique:users',
      'id',
      'gender',
    ]);
    $data = $this->getFieldsByDataColumn($data, 'room_id');
    $repository->write($data);

    \Session::flash('message', '保存成功');
    $this->respondSuccess();
  }

  public function edit(RoomRepository $repository, $id)
  {
    $data['rooms'] = $repository->getSelectableRooms($id);
    $data['user'] = User::find($id)->toArray();
    return $data;
  }


  public function postEdit(RoomRepository $repository, $id)
  {
    $data = $this->getValidatedUserData([
      'room_id'  => 'required',
      'name'     => 'required',
      'mobile'   => 'required|mobile',
      'id',
      'gender',
    ]);
    if ($exists = $this->checkExists($id, $data)) {
      return $exists;
    }
    $data = $this->getFieldsByDataColumn($data, 'room_id');

    $repository->write($data);

    \Session::flash('message', '修改成功');
    $this->respondSuccess();
  }
}