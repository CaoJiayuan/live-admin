<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class HomeController extends Controller
{

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $user = \Auth::user();
    $first = $user->roles->first();
    if (!$first) {
      \Auth::logout();
      return redirect('/login');
    }
    $rolename = $first->name;

    return view('home', ['rolename' => $rolename]);
  }

  public function password()
  {
    $data = $this->getValidatedData([
      'old_pass'   => 'required',
      'password'   => 'required|confirmed|min:6',
    ]);
    $user = \Auth::user();
    if (!\Hash::check($data['old_pass'], $user->getAuthPassword())) {
      throw new UnprocessableEntityHttpException('原密码不正确');
    }
    $user->update([
      'password' => bcrypt($data['password'])
    ]);
    \Session::flash('message', '保存成功');
    return $this->respondSuccess();
  }
}
