<?php

use Illuminate\Database\Seeder;

class AgentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      for($i=2;$i<50;$i++)
      {
        DB::table('users')->insert([
          'id' => $i,
          'name' => 'test'.$i,
          'last_ip' => '192.168.1.'.$i,
          'username' => '91'.$i.'@hon.tech',
          'password' => bcrypt('123456'),
        ]);
      }
      for($i=2;$i<40;$i++)
      {
        DB::table('role_user')->insert([
          'user_id' => $i,
          'role_id' => rand(1,5),
        ]);
      }
    }
}
