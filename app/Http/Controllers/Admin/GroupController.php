<?php
/**
 * Created by Cao Jiayuan.
 * Date: 17-5-25
 * Time: 上午10:03
 */

namespace App\Http\Controllers\Admin;

use App\Repository\Admin\GroupRepository;
use App\Repository\Admin\RoomRepository;
use App\User;

class GroupController extends MainController
{

  public function groups(GroupRepository $repository)
  {
    $data = $repository->getList('group');
    return view('admin.groups.index', [
      'data' => $data,
    ]);
  }

  public function create(GroupRepository $repository)
  {
    $groups = $repository->getSelectableGroups();

    return $groups;
  }


  public function post(GroupRepository $repository)
  {
    $data = $this->getValidatedUserData([
      'group_id'  => 'required',
      'name'     => 'required',
      'mobile'   => 'required|mobile|unique:users',
      'id',
      'gender',
    ]);
    $data = $this->getFieldsByDataColumn($data, 'group_id');

    $repository->write($data);

    \Session::flash('message', '保存成功');
    $this->respondSuccess();
  }

  public function edit(GroupRepository $repository, $id)
  {
    $data['groups'] = $repository->getSelectableGroups($id);
    $data['user'] = User::find($id)->toArray();
    return $data;
  }


  public function postEdit(GroupRepository $repository, $id)
  {
    $data = $this->getValidatedUserData([
      'group_id'  => 'required',
      'name'     => 'required',
      'mobile'   => 'required|mobile',
      'id',
      'gender',
    ]);
    if ($exists = $this->checkExists($id, $data)) {
      return $exists;
    }
    $data = $this->getFieldsByDataColumn($data, 'group_id');

    $repository->write($data);

    \Session::flash('message', '修改成功');
    $this->respondSuccess();
  }
}