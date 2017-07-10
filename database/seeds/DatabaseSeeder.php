<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $this->call(NavSeeder::class);
    $this->call(GiftSeeder::class);
    $this->call(NumSeeder::class);
    is_local() && $this->call(TestDataSeeder::class);
//    $this->call(AreaSeeder::class);
  }
}
