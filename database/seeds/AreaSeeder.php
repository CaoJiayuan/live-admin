<?php
use App\Entity\Area;
use App\Entity\Room;
use Illuminate\Database\Seeder;

/**
 * Created by Cao Jiayuan.
 * Date: 17-5-25
 * Time: 下午5:46
 */
class AreaSeeder extends Seeder
{
  /**
   *
   */
  public function run()
  {
    DB::table('areas')->truncate();
    DB::table('rooms')->truncate();
    $area = ['北京区', '上海区', '广东区', '成都区'];

    foreach ($area as $item) {
      $a = Area::create([
        'name' => $item,
      ]);

      Room::create([
        'title'    => $item . '总房间',
        'area_id' => $a->id,
        'main'    => 1,
      ]);
    }
  }
}