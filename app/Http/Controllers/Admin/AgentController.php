<?php
/**
 * Created by Cao Jiayuan.
 * Date: 17-5-25
 * Time: 上午10:03
 */

namespace App\Http\Controllers\Admin;

use App\Repository\Admin\AgentRepository;
use App\Repository\Admin\GroupRepository;

use App\User;

class AgentController extends MainController
{

  public function agents(AgentRepository $repository)
  {
    $data = $repository->getList('agent');
    return view('admin.agents.index', [
      'data' => $data,
    ]);
  }

  public function create(AgentRepository $repository)
  {
    $groups = $repository->getSelectableGroups();
    return $groups;
  }


  public function post(AgentRepository $repository)
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

  public function edit(AgentRepository $repository, $id)
  {
    $data['groups'] = $repository->getSelectableGroups();
    $data['user'] = User::find($id)->toArray();
    return $data;
  }


  public function postEdit(AgentRepository $repository, $id)
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