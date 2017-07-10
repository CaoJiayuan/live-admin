<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
  /*
  |--------------------------------------------------------------------------
  | Login Controller
  |--------------------------------------------------------------------------
  |
  | This controller handles authenticating users for the application and
  | redirecting them to your home screen. The controller uses a trait
  | to conveniently provide its functionality to your applications.
  |
  */

  use AuthenticatesUsers;

  /**
   * Where to redirect users after login.
   *
   * @var string
   */
  protected $redirectTo = '/';

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('guest')->except('logout');
  }

  public function username()
  {
    return 'username';
  }

  /**
   * @param Request $request
   * @param User $user
   * @return \Illuminate\Http\RedirectResponse|mixed
   */
  protected function authenticated(Request $request, $user)
  {
    if (!\DB::table('role_user')->where('user_id', $user->id)->exists()) {
      $errors = [$this->username() => trans('auth.failed')];
      $this->guard()->logout();
      $request->session()->regenerate();
      return redirect()->back()->withErrors($errors);
    }

   return  redirect()->intended($this->redirectPath());
  }
}
