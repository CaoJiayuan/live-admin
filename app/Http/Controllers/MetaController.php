<?php
/**
 * Created by Cao Jiayuan.
 * Date: 17-5-9
 * Time: 下午4:16
 */

namespace App\Http\Controllers;


use App\Entity\Meta;
use App\Traits\PermissionHelper;
use App\Traits\UploadHelper;

class MetaController extends Controller
{

  use UploadHelper, PermissionHelper;

  public function __construct()
  {
    parent::__construct();

  }

  public function info()
  {
    return view('meta.info', Meta::getItem(['title', 'keywords']));
  }

  public function postInfo()
  {
    $data = $this->getValidatedData([
      'title', 'keywords',
    ]);
    Meta::store($data);
    \Session::flash('message', '保存成功');
    return redirect()->back();
  }


  public function disclaimer()
  {

    $room = $this->getAccessibleRoom();
    Meta::$roomId = $room ? $room->id : 0;
    return view('room.meta.disclaimer', [
      'content' => Meta::getItem('disclaimer'),
    ]);
  }

  public function copyright()
  {

    $room = $this->getAccessibleRoom();
    Meta::$roomId = $room ? $room->id : 0;
    return view('room.meta.copyright', [
      'content' => Meta::getItem('copyright'),
    ]);
  }

  public function interactive()
  {

    $room = $this->getAccessibleRoom();
    Meta::$roomId = $room ? $room->id : 0;
    return view('room.meta.interactive', [
      'content' => Meta::getItem('interactive'),
    ]);
  }

  public function goldLecturer()
  {

    $room = $this->getAccessibleRoom();
    Meta::$roomId = $room ? $room->id : 0;
    return view('room.meta.gold', [
      'content' => Meta::getItem('gold_lecturer'),
      'name' => Meta::getItem('gold_lecturer_name'),
    ]);
  }

  public function postCopyright()
  {

    $room = $this->getAccessibleRoom();
    Meta::$roomId = $room ? $room->id : 0;
    $data = $this->getValidatedData([
      'content' => 'required',
    ]);
    Meta::put('copyright', $data['content']);
    \Session::flash('message', '保存成功');
    return redirect()->back();
  }

  public function postDisclaimer()
  {

    $room = $this->getAccessibleRoom();
    Meta::$roomId = $room ? $room->id : 0;
    $data = $this->getValidatedData([
      'content' => 'required',
    ]);
    Meta::put('disclaimer', $data['content']);
    \Session::flash('message', '保存成功');
    return redirect()->back();
  }

  public function postInteractive()
  {
    $room = $this->getAccessibleRoom();
    Meta::$roomId = $room ? $room->id : 0;
    $data = $this->getValidatedData([
      'content' => 'required',
    ]);
    Meta::put('interactive', $data['content']);
    \Session::flash('message', '保存成功');
    return redirect()->back();
  }


  public function postGoldLecturer()
  {

    $room = $this->getAccessibleRoom();
    Meta::$roomId = $room ? $room->id : 0;
    $data = $this->getValidatedData([
      'content' => 'required',
      'name'    => 'required',
    ], [], ['name' => '讲师名称', 'content' => '讲师介绍']);
    Meta::store([
      'gold_lecturer'      => $data['content'],
      'gold_lecturer_name' => $data['name'],
    ]);
    \Session::flash('message', '保存成功');
    return redirect()->back();
  }

  public function upload()
  {
    $max = 5 * 1024;
    $data = $this->getValidatedData([
      'file' => 'required|max:' . $max,
    ]);

    $path = $this->uploadAndStore($data['file']);
    return [
      'url' => '/storage/' . $path,
    ];
  }
}