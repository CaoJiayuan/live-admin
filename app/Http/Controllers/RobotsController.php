<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\RobotsRepository;

class RobotsController extends Controller
{
  public function index(RobotsRepository $repository)
  {
    $data = $repository->index();
    return view('robots.index',[
      'data' => $data
    ]);
  }

  public function create(RobotsRepository $repository)
  {
    return $repository->create();
  }

  public function store(RobotsRepository $repository)
  {
    $data = $this->getValidatedData([
      'name' => 'required',
      'id',
      'level' => 'required|between:1,5',
      'area_id' => 'required|numeric',
      'room_id' => 'required|numeric',
      'group_id' => 'required|numeric',
      'agent_id' => 'required|numeric',
    ]);
    $data['master_id'] = $data['agent_id'];
    $repository->store($data);
    \Session::flash('message', '保存成功');
    $this->respondSuccess();
  }

  public function edit(RobotsRepository $repository,$id)
  {
    return $repository->edit($id);
  }

  public function destroy(RobotsRepository $repository,$id)
  {
    $repository->destroy($id);
    $this->respondSuccess();
  }
}
