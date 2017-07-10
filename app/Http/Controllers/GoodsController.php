<?php
/**
 * Created by Cao Jiayuan.
 * Date: 17-6-28
 * Time: 上午9:34
 */

namespace App\Http\Controllers;


use App\Entity\Good;
use App\Repository\GoodsRepository;

class GoodsController extends Controller
{

  public function goods(GoodsRepository $repository)
  {
    $data = $repository->goods();

    return view('room.goods.index', [
      'data' => $data,
    ]);
  }

  public function delete($id)
  {
    Good::destroy($id);
  }

  public function create(GoodsRepository $repository)
  {
    $data = $this->getValidatedData([
      'title'   => 'required',
      'credits' => 'required',
      'img'     => 'required',
      'id',
    ], [], ['title' => '标题', 'img' => '图片', 'credits' => '积分']);
    $repository->write($data);
    \Session::flash('message', '保存成功');
    return $this->respondSuccess();
  }

  public function status($id)
  {
    Good::where('id', $id)->update([
      'status' => \DB::raw('!status')
    ]);

    return redirect()->back();
  }
}