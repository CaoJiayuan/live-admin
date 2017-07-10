<?php
/**
 * Created by Cao Jiayuan.
 * Date: 17-7-4
 * Time: 上午11:21
 */

namespace App\Http\Controllers;


use App\Entity\Good;
use App\Entity\Order;
use App\Repository\OrderRepository;

class OrderController extends Controller
{

  public function orders(OrderRepository $repository)
  {
    $data = $repository->orders();

    return view('room.orders.index', [
      'data' => $data,
    ]);
  }

  public function status($id)
  {
    \DB::beginTransaction();
    $order = Order::find($id);
    if ($order) {
      $order->status = !$order->status;
      $order->save();
    }
    $g = Good::find($order->good_id);
    if ($g) {
      $g->times ++;
      $g->save();
    }
    \DB::commit();

    return redirect()->back();
  }
}