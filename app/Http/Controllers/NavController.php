<?php
/**
 * Created by Cao Jiayuan.
 * Date: 17-4-27
 * Time: 下午5:11
 */

namespace App\Http\Controllers;


class NavController
{
  public function toggle()
  {
    $opened = session('nav.opened', true);

    session([
      'nav.opened' => !$opened
    ]);

    return session('nav', [
      'opened' => true
    ]);
  }

}