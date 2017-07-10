<?php
/**
 * Created by Cao Jiayuan.
 * Date: 17-5-4
 * Time: 上午10:53
 */

namespace App\Traits;


use Symfony\Component\HttpKernel\Exception\HttpException;

trait ApiResponse
{

  public function respondSuccess($msg = 'Success')
  {
    $this->respondMessage(200, $msg);
  }

  public function respondMessage($code, $msg)
  {
    throw new HttpException($code, $msg);
  }
}