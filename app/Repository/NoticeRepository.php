<?php
/**
 * Created by Cao Jiayuan.
 * Date: 17-5-24
 * Time: 下午4:47
 */

namespace App\Repository;


use App\Entity\Notice;
use App\Traits\PermissionHelper;
use Illuminate\Database\Query\Builder;

class NoticeRepository extends Repository
{

  use PermissionHelper;

  public function notices($roomId)
  {
    return $this->getSearchAbleData(Notice::class, [
      'content',
    ], function ($builder) use ($roomId) {
      /** @var Builder $builder */
      $builder->where('room_id', $roomId);
    });
  }

  public function write($data)
  {
    $room = $this->getAccessibleRoom();
    $roomId = $room ? $room->id : 0;
    $data['room_id'] = $roomId;
    $data['enable'] = true;
    Notice::updateOrCreate([
      'id' => $data['id'],
    ], array_except($data, 'id'));
  }

  public function status($id)
  {
    \DB::transaction(function () use ($id) {
      if ($notice = Notice::where('id', $id)->first()) {
        $notice->update([
          'enable' => \DB::raw('!enable')
        ]);
      }
    });
  }
}