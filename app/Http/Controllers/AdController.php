<?php
/**
 * Created by Cao Jiayuan.
 * Date: 17-6-1
 * Time: 下午4:30
 */

namespace App\Http\Controllers;


use App\Entity\Advertisement;
use App\Repository\AdRepository;

class AdController extends Controller
{

  public function banners(AdRepository $repository)
  {
    $data = $repository->banners();
    return view('room.banners.index', [
      'data' => $data,
    ]);
  }

  public function status($id)
  {
    Advertisement::where('id', $id)->update([
      'status' => \DB::raw('!status')
    ]);

    return redirect()->back();
  }

  public function delete($id)
  {
    Advertisement::where('id', $id)->delete();
  }

  public function store(AdRepository $repository)
  {
    $data = $this->getValidatedData([
      'title' => 'required',
      'img' => 'required',
      'url' => 'required',
      'id',
    ], [], ['img' => '图片']);

    $repository->writeBanner($data);
    \Session::flash('message', '保存成功');
    return $this->respondSuccess();
  }
}