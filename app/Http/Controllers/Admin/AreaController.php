<?php
/**
 * Created by Cao Jiayuan.
 * Date: 17-5-24
 * Time: 下午5:08
 */

namespace App\Http\Controllers\Admin;


use App\Entity\Area;
use App\Repository\Admin\AreaRepository;
use App\User;

class AreaController extends MainController
{

  public function areas(AreaRepository $repository)
  {
    $data = $repository->getList('area');
    return view('admin.areas.index', [
      'data' => $data,
    ]);
  }

  public function create(AreaRepository $repository)
  {
    $areas = $repository->getSelectableAreas();

    return $areas;
  }

  public function post(AreaRepository $repository)
  {
    $data = $this->getValidatedUserData([
      'area_id'  => 'required',
      'name'     => 'required',
      'mobile'   => 'required|mobile|unique:users',
      'id',
      'gender',
    ]);

    $repository->write($data);

    \Session::flash('message', '保存成功');
    $this->respondSuccess();
  }

  public function edit(AreaRepository $repository, $id)
  {
    $data['areas'] = $repository->getSelectableAreas($id);
    $data['user'] = User::find($id)->toArray();
    return $data;
  }


  public function postEdit(AreaRepository $repository, $id)
  {
    $data = $this->getValidatedUserData([
      'area_id'  => 'required',
      'name'     => 'required',
      'mobile'   => 'required|mobile',
      'id',
      'gender',
    ]);
    if ($exists = $this->checkExists($id, $data)) {
      return $exists;
    }

    $repository->write($data);

    \Session::flash('message', '修改成功');
    $this->respondSuccess();
  }
}