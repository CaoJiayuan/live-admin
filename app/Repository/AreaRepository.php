<?php
/**
 * Created by Cao Jiayuan.
 * Date: 17-5-23
 * Time: 上午11:31
 */

namespace App\Repository;


use App\Entity\Area;
use App\Entity\Room;
use App\Traits\PermissionHelper;
use App\User;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\App;

class AreaRepository extends Repository
{

  use PermissionHelper;

  public function areas()
  {
    return $this->getSearchAbleData(Area::class, [
      'name',
    ], function ($builder) {
      /** @var Builder $builder */

      $builder->with('admin');
      $builder->with('room');
      $builder->select([
        'areas.*',
      ]);
      $builder->groupBy('areas.id');
    });
  }

  public function createOrUpdate($data)
  {

    \DB::transaction(function () use ($data) {
      $area = Area::updateOrCreate([
        'id' => $data['id'],
      ], $data);
      Room::firstOrCreate([
        'area_id' => $area->id,
        'main'    => true,
      ], [
        'area_id' => $area->id,
        'main'    => true,
        'title'   => $data['name'],
      ]);
    });
  }

  public function delete($id)
  {
    \DB::transaction(function () use ($id) {
      Area::destroy($id);
      Room::where('area_id', $id)->delete();
      User::where('area_id', $id)->has('roles', '<', 1)->delete();
    });
  }

  public function deleteRooms($ids)
  {
    \DB::beginTransaction();
    Room::whereIn('id', (array)$ids)->delete();
    User::whereIn('room_id', (array)$ids)->has('roles', '<', 1)->delete();
    \DB::commit();
  }

  public function getAreaAll()
  {
     return Area::where('enable', 1)->get();
  }
  //集合,便于遍历,不使用find方法
  public function getAreaById($id)
  {
    return Area::where('id',$id)->get();
     //return Area::find($id);
  }



}