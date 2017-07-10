<?php

use App\Entity\GiftCategory;
use Illuminate\Database\Seeder;

class GiftSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('gift_categories')->truncate();
    $cates = [
      [
        'name' => '推荐'
      ],
      [
        'name' => '热门'
      ],
      [
        'name' => '豪华'
      ],
      [
        'name' => '专属'
      ],
    ];

    GiftCategory::insert($cates);
  }
}
