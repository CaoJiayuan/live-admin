<?php
/**
 * Created by Cao Jiayuan.
 * Date: 17-6-14
 * Time: 下午2:16
 */

namespace App\Http\Controllers;
use App\Entity\Gift;
use App\Entity\GiftCategory;
use App\Repository\GiftRepository;

class GiftController extends Controller
{
  public function gifts(GiftRepository $repository)
  {
    $data = $repository->gifts();
    $cates = GiftCategory::orderBy('id')->get();
    return view('room.gifts.index', [
      'data' => $data,
      'cates' => $cates,
    ]);
  }

  public function create(GiftRepository $repository)
  {
    $data = $this->getValidatedData([
      'id',
      'name'             => 'required',
      'img'              => 'required',
      'credits'          => 'required',
      'gift_category_id' => 'required',
    ],[], [
      'name'             => '礼物名称',
      'img'              => '礼物图片',
      'credits'          => '消耗积分',
      'gift_category_id' => '礼物类型',
    ]);
    $repository->write($data);

    $this->respondSuccess();
  }


  public function delete($id)
  {
    Gift::destroy($id);
  }
}