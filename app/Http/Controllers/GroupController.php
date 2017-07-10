<?php
/**
 * Created by Cao Jiayuan.
 * Date: 17-5-24
 * Time: 上午10:05
 */

namespace App\Http\Controllers;


use App\Entity\Group;
use App\Repository\GroupRepository;

class GroupController extends Controller
{

  public function groups(GroupRepository $repository)
  {
    $data = $repository->groups();
    return view('room.groups.index', [
      'data' => $data,
    ]);
  }

  public function create(GroupRepository $repository)
  {
    $data = $this->getValidatedData([
      'name' => 'required',
      'id',
    ]);
    $repository->write($data);
    \Session::flash('message', '保存成功');
    return $this->respondSuccess();
  }

  public function delete($id)
  {
    Group::destroy($id);
  }
}