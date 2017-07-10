<?php

namespace App\Http\Controllers;

use App\Repository\UsersRepository;
use App\User;
use App\Repository\AreaRepository;
use App\Repository\RoomRepository;
use App\Repository\GroupRepository;

class UsersController extends Controller
{

  public function index(UsersRepository $repository)
  {
    $data = $repository->users();
    $conditions = self::getConditions($repository);
    return view('users.index', [
      'data' => $data,
      'condition' => $conditions
    ]);
  }

  public function create(UsersRepository $repository)
  {
    return $repository->create();
  }

  public function store(UsersRepository $repository)
  {
    $data = $this->getValidatedData([
      'name' => 'required',
      'mobile' => 'required|mobile',
      'id',
      'nickname' => 'required',
      'username' => 'required',
      'gender' => 'required|between:1,2',
      'level' => 'required|between:1,5',
      'area_id' => 'required|numeric',
      'room_id' => 'required|numeric',
      'group_id' => 'required|numeric',
      'agent_id' => 'required|numeric',
      'qq',
      'inviter'
    ]);
    $date = $repository->updateOrCreate($data);
    if($date['code']==200) {
      \Session::flash('message', '保存成功');
      $this->respondSuccess();
    }else{
      $this->respondMessage('422',$date['message']);
    }
  }

  public function edit($id)
  {
    return User::whereId($id)->with('inviter')->first()->toArray();
  }

  public function banIp(UsersRepository $repository,$id)
  {
    $repository->banIp($id);
  }

  public function disable(UsersRepository $repository,$id)
  {
    $repository->disable($id);
  }

  public function gag(UsersRepository $repository,$id)
  {
    $repository->gag($id);
  }

  public function destroy($id, UsersRepository $repository)
  {
    $repository->delete($id);
    $this->respondSuccess();
  }

  public function online(UsersRepository $repository)
  {
    $data = $repository->online();
//    dd($data);
    $condition = self::getConditions($repository);
    return view('users.online',[
      'data' => $data,
      'condition' => $condition
    ]);
  }

  private static function getConditions(UsersRepository $repository)
  {
    return $repository->getConditions();
  }
}
