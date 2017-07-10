<?php
use App\Entity\Area;
use App\Entity\Group;
use App\Entity\Room;
use App\Entity\UserLogs;
use App\User;
use Illuminate\Database\Seeder;

/**
 * Created by Cao Jiayuan.
 * Date: 17-5-25
 * Time: 下午5:46
 */
class TestDataSeeder extends Seeder
{
  public function run()
  {
    DB::table('areas')->truncate();
    DB::table('rooms')->truncate();
    DB::table('groups')->truncate();
    DB::table('user_logs')->truncate();
    DB::delete('delete from users where id>1');
    $area = ['北京区', '成都区'];
    $pinyin = ['beijing', 'chengdu'];
    foreach ($area as $key => $item) {
      //加载当前地区
      $a = Area::create([
        'name'   => $item,
        'enable' => '1',
      ]);
      $faker = \Faker\Factory::create('zh_CN');
      $masterrommid = 0;
      //插入房间
      for ($i = 1; $i <= 3; $i++) {
        //插入房间
        $r = null;
        if ($i == 1) {
          $r = Room::create([
            'title'   => $item . '总房间编号' . $i,
            'area_id' => $a->id,
            'enable'  => '1',
            'main'    => 1 //是主房间
          ]);
          $masterrommid = $r->id;
        } else {
          $r = Room::create([
            'title'   => $item . '子房间编号' . $i,
            'area_id' => $a->id,
            'main'    => 0,
            'main_id' => $masterrommid,
          ]);
        }
        //记载该管理员
        $mobile = $faker->unique()->phoneNumber;
        $name = $faker->name;
        if ($i != 1) {
          $roomuser = User::create([
            'name'       => $name,
            'area_id'    => ($key + 1),
            'room_id'    => $r->id,
            'last_ip'    => '192.168.' . ($key + 1) . '.' . ($i),
            'username'   => $mobile,//  $pinyin[$key].''.$r->id.'rooms'.($i).'@hon.tech',
            'mobile'     => $mobile,//  $pinyin[$key].''.$r->id.'rooms'.($i).'@hon.tech',
            'nickname'   => $name,//  $pinyin[$key].''.$r->id.'rooms'.($i).'@hon.tech',
            'password'   => bcrypt(substr($mobile, -6)),
            'last_login' => \Carbon\Carbon::now(),
          ]);
          //记载房间用户关联表
          DB::table('role_user')->insert([
            'user_id' => $roomuser->id,
            'role_id' => 3//房间管理员
          ]);
        }

        //插入团队
        for ($j = 1; $j <= 3; $j++) {
          //插入团队
          $mobile = $faker->unique()->phoneNumber;
          $g = Group::create([
            'name'    => $item . '房间编号' . $i . '团队编号' . $j,
            'room_id' => $r->id,
          ]);
          //记载该管理员
          $name1 = $faker->name;
          $groupuser = User::create([
            'name'       => $name1,
            'area_id'    => ($key + 1),
            'room_id'    => $r->id,
            'group_id'   => $g->id,
            'last_ip'    => '192.168.3.'.($j),
            'username'   => $mobile,//$pinyin[$key].''.$r->id.'rooms'.($i).'@hon.tech',
            'mobile'     => $mobile,//$pinyin[$key].''.$r->id.'rooms'.($i).'@hon.tech',
            'nickname'   => $name1,//$pinyin[$key].''.$r->id.'rooms'.($i).'@hon.tech',
            'password'   => bcrypt(substr($mobile, -6)),
            'last_login' => \Carbon\Carbon::now(),
          ]);
          //记载房间用户关联表
          DB::table('role_user')->insert([
            'user_id' => $groupuser->id,
            'role_id' => 4//团队经理
          ]);
          //插入业务员
          for ($k = 1; $k <= 3; $k++) {
            //记载该管理员
            $mobile = $faker->unique()->phoneNumber;

            $name2 = $faker->name;
            $businessuser = User::create([
              'name'       => $name2,
              'area_id'    => ($key + 1),
              'room_id'    => $r->id,
              'group_id'   => $g->id,
              'last_ip'    => '192.168.4.' . ($k),
              'username'   => $mobile,//  $pinyin[$key].''.$r->id.'rooms'.($i).'@hon.tech',
              'mobile'     => $mobile,//  $pinyin[$key].''.$r->id.'rooms'.($i).'@hon.tech',
              'nickname'   => $name2,//  $pinyin[$key].''.$r->id.'rooms'.($i).'@hon.tech',
              'password'   => bcrypt(substr($mobile, -6)),
              'last_login' => \Carbon\Carbon::now(),
            ]);
            //记载房间用户关联表
            DB::table('role_user')->insert([
              'user_id' => $businessuser->id,
              'role_id' => 5//业务员
            ]);
            //插入用户
            for ($b = 1; $b <= 100; $b++) {
              //插入当前用户
              $mobile = $faker->unique()->phoneNumber;

              $name3 = $faker->name;
              $tempuser = User::create([
                'name'       => $name3,
                'area_id'    => ($key + 1),
                'room_id'    => $r->id,
                'group_id'   => $g->id,
                'last_ip'    => '192.168.4.' . ($b),
                'agent_id'   => $businessuser->id,
                'username'   => $mobile,//  $pinyin[$key].''.$r->id.'rooms'.($i).'@hon.tech',
                'mobile'     => $mobile,//  $pinyin[$key].''.$r->id.'rooms'.($i).'@hon.tech',
                'nickname'   => $name3,//  $pinyin[$key].''.$r->id.'rooms'.($i).'@hon.tech',
                'password'   => bcrypt(substr($mobile, -6)),
                'last_login' => \Carbon\Carbon::now(),
              ]);

              $datestring=date("Y-m-d");
              $randnum=rand(0,9);
              if($randnum!=0) {
                $isadd=rand(0,1);
                if($isadd==0) {
                  $datestring = date("Y-m-d", strtotime("-" . $randnum . " day"));
                }else{
                  $datestring = date("Y-m-d", strtotime("+" . $randnum . " day"));
                }
              }
              else{
                $datestring=date("Y-m-d",strtotime($randnum." day"));
              }
              $uaarray=['android','ios','pc'];
              //用户登录日志
              UserLogs::create([
                'user_id'    => $tempuser->id,
                'type'       => '0',
                'area_id'    => ($key + 1),
                'room_id'    => $r->id,
                'group_id'   => $g->id,
                'agent_id'   => $tempuser->agent_id,
                'created_at' => $datestring.' '.rand(9, 22).':46:32',
                'ua'=>$uaarray[rand(0,2)]
              ]);
            }
          }
        }
      }
      $mobile = $faker->unique()->phoneNumber;
      //记载该地区管理员
      $name4 = $faker->name;
      $au = User::create([
        'name'       => $name4,
        'area_id'    => ($key + 1),
        'last_ip'    => '192.168.1.' . ($key + 1),
        'username'   => $mobile,//  $pinyin[$key].''.$r->id.'rooms'.($i).'@hon.tech',
        'mobile'     => $mobile,//  $pinyin[$key].''.$r->id.'rooms'.($i).'@hon.tech',
        'nickname'   => $name4,//  $pinyin[$key].''.$r->id.'rooms'.($i).'@hon.tech',
        'password'   => bcrypt(substr($mobile, -6)),
        'last_login' => \Carbon\Carbon::now(),
      ]);
      //记载区域用户关联表
      DB::table('role_user')->insert([
        'user_id' => $au->id,
        'role_id' => 2 //区域管理员
      ]);
    }
  }
}