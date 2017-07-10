<?php
/**
 * Created by Cao Jiayuan.
 * Date: 17-6-28
 * Time: 上午9:34
 */

namespace App\Http\Controllers;


use App\Entity\CreditRule;
use App\Entity\Meta;
use App\Repository\CreditsRepository;
use App\Traits\PermissionHelper;
use Carbon\Carbon;

class CreditsController extends Controller
{

  use PermissionHelper;

  public function credits(CreditsRepository $repository)
  {
    $data = $repository->credits();

    return view('room.credits.index', [
      'data' => $data,
    ]);
  }

  public function delete($id)
  {
    CreditRule::destroy($id);
  }

  public function create(CreditsRepository $repository)
  {
    $data = $this->getValidatedData([
      'minutes' => 'required|min:1',
      'credits' => 'required|min:1',
      'id',
    ], [], ['minute' => '分钟', 'credits' => '积分']);
    $repository->write($data);
    \Session::flash('message', '保存成功');
    return $this->respondSuccess();
  }

  public function others()
  {
    $room = $this->getAccessibleRoom();
    Meta::$roomId = $room->id;
    $data = Meta::getItem([
      'sing_credit' => 0,
      'invite_credit' => 0,
    ]);
    $data['room'] = $room;
    return view('credits.others', $data);
  }

  public function postOthers()
  {
    $data = $this->getValidatedData([
      'sing_credit',
      'invite_credit'
    ]);
    $room = $this->getAccessibleRoom();
    Meta::$roomId = $room->id;
    Meta::store($data);
    \Session::flash('message', '保存成功');

    return redirect()->back();
  }
}