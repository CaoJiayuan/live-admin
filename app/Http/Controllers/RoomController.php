<?php
/**
 * Created by Cao Jiayuan.
 * Date: 17-5-23
 * Time: 下午4:18
 */

namespace App\Http\Controllers;


use App\Entity\Meta;
use App\Entity\Popup;
use App\Entity\Room;
use App\Repository\RoomRepository;
use App\Traits\PermissionHelper;

class RoomController extends Controller
{

  use PermissionHelper;

  public function setting(RoomRepository $repository)
  {
    $room = $this->getAccessibleRoom();
    if ($room) {
      $words = $repository->maskingWords($room);
      Meta::$roomId = $room->id;
      $room->calendar = Meta::getItem('calendar');
      $room->sing_credit = Meta::getItem('sing_credit');
      $videos = $room->videos;
      $vs = [];
      foreach ($videos as $video) {
        $vs[$video->type] = $video;
      }
      $room->videos = $vs;
    }
    return view('room.rooms.setting', [
      'room'  => $room,
      'words' => implode(' ', $words),
    ]);
  }

  public function rooms(RoomRepository $repository)
  {
    $data = $repository->rooms();

    return view('room.rooms.index', [
      'data' => $data,
      'area' => $this->getAccessibleArea(),
    ]);
  }

  public function closeOrOpen($id)
  {
    \DB::table('rooms')->where('id',$id)->update([
      'covered' => \DB::raw("!covered")
    ]);
  }

  public function postSetting(RoomRepository $repository)
  {
    $data = $this->getValidatedData([
      'title' => 'required',
      'logo',
      'web_title',
      'id',
      'icon',
      'background',
      'register_capacity',
      'online_capacity',
      'modify_num',
      'tourist',
      'enable',
      'vote',
      'chat',
      'popup',
      'chat_interval',
      'max_length',
      'calendar',
      'video_position',
      'words',
      'video',
      'videos',
      'backgrounds',
      'qr_code',
      'main',
      'cover',
    ]);
    if ($data['main']) {
      if (array_get($data, 'video.type') == 0 && (!array_get($data, 'videos.2.url') || !array_get($data, 'videos.0.url'))) {
        return  $this->respondMessage(422, '虎牙用户id或YY flash地址不能为空');
      }
      if (array_get($data, 'video.type') == 1 && !array_get($data, 'videos.1.url')) {
        return  $this->respondMessage(422, '奥点云拉流地址不能为空');
      }
    }
    $repository->setting($data);

//    \Session::flash('message', '保存成功');
    return $this->respondSuccess();
  }

  public function postRoom(RoomRepository $repository)
  {
    $data = $this->getValidatedData([
      'area_id' => 'required',
      'company_name',
      'remark',
      'title'   => 'required',
      'id',
    ]);
    $repository->createOrUpdateRoom($data);
    \Session::flash('message', '保存成功');
    return $this->respondSuccess();
  }

  public function getSettingForm(RoomRepository $repository, $id)
  {
    return view('room.rooms.form.setting', $repository->room($id));
  }

  public function changePermission($id)
  {
    Room::where('id', $id)->update([
      'permission' => \DB::raw('!permission'),
    ]);

    return redirect()->back();
  }

  public function popups(RoomRepository $repository)
  {
    $data = $repository->popups();

    return view('room.popups.index', [
      'data' => $data,
    ]);
  }

  public function postPopups(RoomRepository $repository)
  {
    $data = $this->getValidatedData([
      'img' => 'required',
      'url' => 'required',
      'id',
    ], [], ['img' => '图片']);
    $repository->writePopup($data);
    \Session::flash('message', '保存成功');
    return $this->respondSuccess();
  }

  public function deletePopup($id)
  {
    Popup::destroy($id);
  }

  public function popupStatus($id)
  {
    $popup = Popup::find($id);

    if ($popup && !$popup->enable) {
      \DB::table('popups')->update([
        'enable' => 0
      ]);
    }

    Popup::where('id', $id)->update([
      'enable' => \DB::raw('!enable'),
    ]);

    return redirect()->back();
  }
}