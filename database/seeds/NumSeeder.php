<?php

use Illuminate\Database\Seeder;

class NumSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('num')->truncate();
    $i = range(0, 9);
    $insert = [];
    foreach ($i as $item) {
      $insert[] = [
        'i' => $item
      ];
    }
    DB::table('num')->insert($insert);
  }
}
