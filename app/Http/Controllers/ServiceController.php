<?php
/**
 * Created by Cao Jiayuan.
 * Date: 17-5-24
 * Time: 下午4:17
 */

namespace App\Http\Controllers;


use App\Entity\Service;
use App\Repository\ServiceRepository;

class ServiceController extends Controller
{

  public function services(ServiceRepository $repository)
  {
    $data = $repository->services();

    return view('room.services.index', [
      'data' => $data,
    ]);
  }

  public function deleteService($id)
  {
    Service::destroy($id);
  }

  public function postServices(ServiceRepository $repository)
  {
    $data = $this->getValidatedData([
      'qq'   => 'required',
      'name' => 'required',
      'id'
    ], [], ['name' => '名称']);
    $repository->writeService($data);
    \Session::flash('message', '保存成功');
    return $this->respondSuccess();
  }
}