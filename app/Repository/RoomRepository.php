<?php
/**
 * Created by Cao Jiayuan.
 * Date: 17-5-23
 * Time: 下午5:37
 */

namespace App\Repository;


use App\Entity\Area;
use App\Entity\MaskingWord;
use App\Entity\Meta;
use App\Entity\Popup;
use App\Entity\Room;
use App\Entity\RoomBackground;
use App\Entity\Video;
use App\Traits\PermissionHelper;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;

class RoomRepository extends Repository
{

  use PermissionHelper;

  public function rooms()
  {
    return $this->getSearchAbleData(Room::class, [
      'title',
      'company_name',
    ], function ($builder) {
      $area = $this->getAccessibleArea();
      $areaId = $area ? $area->id : 0;
      /** @var Builder $builder */
      $builder->with('admin', 'area');
      $builder->leftJoin('user_rooms', 'user_rooms.room_id', '=', 'rooms.id');
      $builder->groupBy('rooms.id');
      $pre = \DB::getTablePrefix();
      $builder->select([
        'rooms.*',
        \DB::raw("COUNT({$pre}user_rooms.user_id) as people"),
      ]);
      $builder->where('rooms.main', false);
      $builder->where('rooms.area_id', $areaId);

    });
  }

  public function createOrUpdateRoom($data)
  {
    \DB::transaction(function () use ($data) {
      $area = Area::find($data['area_id']);
      $main = Room::whereAreaId($area->id)->where('main', 1)->first();
      $data['main_id'] = array_get($main, 'id');
      $data['company_name'] = '';
      Room::updateOrCreate([
        'id' => $data['id'],
      ], $data);
    });
  }

  public function room($id)
  {
    return Room::find($id);
  }

  public function setting($data)
  {
    \DB::transaction(function () use ($data) {
      $video = $data['video'];
      $videos = $data['videos'];
      $type = $video['type'];
      foreach ((array)$videos as $t => $v) {
        $url = $v['url'];
        if ($url) {
          $mUrl = $url;
          if ($t == 0) {
            $mUrl = array_get($videos, '2.url', $url);
          }
          if ($t == 1) {
            $mUrl = str_replace(['rtmp://', 'lssplay'], ['http://', 'hlsplay'], $url) . '.m3u8';
          }
          $vo = Video::updateOrCreate([
            'room_id' => $data['id'],
            'type'    => $t,
          ], [
            'room_id'    => $data['id'],
            'type'       => $t,
            'url'        => $url,
            'mobile_url' => $mUrl,
          ]);
          if ($type == $t) {
            $data['video_id'] = $vo->id;
          }
        }
      }
      RoomBackground::where('room_id', $data['id'])->delete();
      $backgrounds = $data['backgrounds'];
      $i = 0;
      $bs = [];
      foreach ((array)$backgrounds as $background) {
        $bs[] = [
          'room_id'    => $data['id'],
          'background' => $background,
        ];
        $i++;
      }
      $bs && RoomBackground::insert($bs);
      Room::where([
        'id' => $data['id'],
      ])->update((array_except($data, ['id', 'words', 'video', 'videos', 'backgrounds', 'main', 'calendar', 'sing_credit'])));
      Meta::$roomId = $data['id'];
      if ($data['calendar'] && !starts_with($data['calendar'], 'http')) {
        $data['calendar'] = 'http://' . $data['calendar'];
      }
      Meta::store([
        'calendar'    => $data['calendar'],
      ]);
      MaskingWord::where('room_id', $data['id'])->delete();

      $insert = [];
      $words = explode(' ', $data['words']);
      $words = (array)$words;
      $words = array_unique($words);
      foreach ($words as $item) {
        if ($item) {
          $insert[] = [
            'room_id'    => $data['id'],
            'word'       => $item,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
          ];
        }
      }
      MaskingWord::insert($insert);
    });
  }

  public function maskingWords($room)
  {
    if ($room) {
      $result = [];
      foreach ($room->maskings as $masking) {
        $result[] = $masking->word;
      }
      return $result;
    }

    return [];
  }

  public function popups()
  {
    return $this->getSearchAbleData(Popup::class, [], function ($builder) {
      $room = $this->getAccessibleRoom();
      $roomId = $room ? $room->id : 0;
      /** @var Builder $builder */
      $builder->where('room_id', $roomId);
    });
  }

  public function writePopup($data)
  {
    $room = $this->getAccessibleRoom();
    $roomId = $room ? $room->id : 0;
    $data['room_id'] = $roomId;
    Popup::updateOrCreate([
      'id' => $data['id'],
    ], array_except($data, 'id'));
  }


  public function getRoomByAreaId($areaid)
  {
    return Room::where('area_id', $areaid)->where('main', '0')->get();
  }

  //集合,便于遍历,不使用find方法
  public function getRoomById($roomid)
  {
    return Room::where('id', $roomid)->get();
    //return Room::find($roomid);
  }

}