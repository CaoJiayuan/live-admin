<?php
/**
 * Created by Cao Jiayuan.
 * Date: 17-5-24
 * Time: 下午4:46
 */

namespace App\Http\Controllers;


use App\Entity\Notice;
use App\Repository\NoticeRepository;
use App\Traits\PermissionHelper;

class NoticeController extends Controller
{
  use PermissionHelper;

  public function notices(NoticeRepository $repository)
  {
    $room = $this->getAccessibleRoom();
    $roomId = $room ? $room->id : 0;
    $data = $repository->notices($roomId);

    return view('room.notices.index', [
      'data'   => $data,
      'roomId' => $roomId,
    ]);
  }

  public function status(NoticeRepository $repository, $id)
  {
    $repository->status($id);
    return redirect()->back();
  }

  public function post(NoticeRepository $repository)
  {
    $data = $this->getValidatedData([
      'content' => 'required',
      'id',
    ], [], ['content' => '内容']);
    $repository->write($data);
    \Session::flash('message', '保存成功');
    return $this->respondSuccess();
  }


  public function delete($id)
  {
    Notice::destroy($id);
  }
}