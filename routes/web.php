<?php
use App\Repository\StatisticsRepository;
/*
|--------------------------------------------------------------------------
Web Routes
|--------------------------------------------------------------------------
Here is where you can register web routes for your application. These
routes are loaded by the RouteServiceProvider within a group which
contains the "web" middleware group. Now create something great!
*/
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('upload', 'MetaController@upload');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('nav/toggle', 'NavController@toggle');


class foo
{
    public $name='like';
    public $age='15';
    function do_foo()
    {
        echo "Doing foo.";
    }
}



Route::get('/test', function (StatisticsRepository $repository,\Illuminate\Http\Request $request) {
/*
    $f=new foo();
    $array=[];
    $array[]=$f;
    $f1=new foo();
    $array[]=$f1;
    dd($array);
    $str='';
    foreach ($array as $item) {
        $str=$str.$item->name.'==='.$item->age;
    }
    echo $str;*/
    /*
    //$array=array('name'=>'tom','age'=>49);
    //$array=['name'=>'tom','age'=>50];
    //$array= ['name'=> ['c' => 'b'],'age'=>49];
    //echo array_get($array,'name.a','0000');
    //dd($array);
       /*
       foreach ($array as $item) {
           echo $item['name'].'===='.$item['age'];
       }*/
    /*
    $array=[];
    $array[]='1';
    $array[]='2';
    $array[]='3';
    array_push($array,5);
    array_push($array,6);
    array_push($array,7);
    dd($array);
*/
    //$array = array(0 => 100, "color" => "red",'test'=>new foo());
    //print_r(array_keys($array));
    //dd(array_values($array)[2]->name);
});

Route::group(['middleware' => 'auth'], function () {
  Route::get('/', 'HomeController@index')->name('home');
  Route::group(['prefix' => 'room'], function () {
    Route::get('areas', 'AreaController@areas')->name('room.areas');
    Route::post('areas/create', 'AreaController@postArea')->name('room.areas.create');
    Route::delete('areas/{id}', 'AreaController@deleteArea')->name('room.areas.destroy');

    Route::get('rooms', 'RoomController@rooms')->name('room.rooms');
    Route::get('rooms/{id}/setting', 'RoomController@getSettingForm')->name('room.setting');
    Route::get('rooms/{id}/permission', 'RoomController@changePermission')->name('room.permission');
    Route::post('rooms', 'RoomController@postRoom')->name('room.rooms.create');
    Route::delete('rooms/{id}', 'AreaController@deleteRoom')->name('room.rooms.destroy');

    Route::get('setting', 'RoomController@setting')->name('room.setting');
    Route::post('setting', 'RoomController@postSetting')->name('room.setting');

    Route::get('groups', 'GroupController@groups')->name('room.groups');
    Route::post('groups/create', 'GroupController@create')->name('room.groups.create');
    Route::delete('groups/{id}', 'GroupController@delete')->name('room.groups.destroy');

    Route::get('votes', 'VoteController@votes')->name('room.votes');
    Route::get('votes/{id}/status', 'VoteController@status')->name('room.votes.status');
    Route::get('votes/{id}/options', 'VoteController@options')->name('room.votes.options');
    Route::post('votes/{id}/options', 'VoteController@postOptions')->name('room.votes.options.create');
    Route::delete('votes/options/{id}', 'VoteController@deleteOption')->name('room.votes.options.destroy');
    Route::post('votes/create', 'VoteController@create')->name('room.votes.create');
    Route::delete('votes/{id}', 'VoteController@delete')->name('room.votes.destroy');

    Route::get('popups', 'RoomController@popups')->name('room.popups');
    Route::post('popups/create', 'RoomController@postPopups')->name('room.popups.create');
    Route::delete('popups/{id}', 'RoomController@deletePopup')->name('room.popups.destroy');
    Route::get('popups/{id}/status', 'RoomController@popupStatus')->name('room.popups.status');

    Route::get('notices', 'NoticeController@notices')->name('room.notices');
    Route::post('notices/create', 'NoticeController@post')->name('room.notices.create');
    Route::delete('notices/{id}', 'NoticeController@delete')->name('room.notices.destroy');
    Route::get('notices/{id}/status', 'NoticeController@status')->name('room.notices.status');


    Route::get('services', 'ServiceController@services')->name('room.services');
    Route::post('services/create', 'ServiceController@postServices')->name('room.services.create');
    Route::delete('services/{id}', 'ServiceController@deleteService')->name('room.services.destroy');

    Route::get('disclaimer', 'MetaController@disclaimer')->name('room.disclaimer');
    Route::post('disclaimer', 'MetaController@postDisclaimer')->name('room.disclaimer');
    Route::get('copyright', 'MetaController@copyright')->name('room.copyright');
    Route::post('copyright', 'MetaController@postCopyright')->name('room.copyright');
    Route::get('interactive', 'MetaController@interactive')->name('room.interactive');
    Route::post('interactive', 'MetaController@postInteractive')->name('room.interactive');
    Route::get('goldLecturer', 'MetaController@goldLecturer')->name('room.goldLecturer');
    Route::post('goldLecturer', 'MetaController@postGoldLecturer')->name('room.goldLecturer');

    Route::get('banners', 'AdController@banners')->name('room.banners');
    Route::post('banners/create', 'AdController@store')->name('room.banners.create');
    Route::get('banners/{id}/status', 'AdController@status')->name('room.banners.create');
    Route::delete('banners/{id}', 'AdController@delete')->name('room.banners.create');


    Route::get('lecturers', 'LecturerController@lecturers')->name('room.lecturers');
    Route::get('lecturers/{id}', 'LecturerController@show')->name('room.lecturers');
    Route::post('lecturers/create', 'LecturerController@create')->name('room.lecturers.create');
    Route::delete('lecturers/{id}', 'LecturerController@delete')->name('room.lecturers.destroy');

    Route::get('gifts', 'GiftController@gifts')->name('room.gifts');
    Route::post('gifts/create', 'GiftController@create')->name('room.gifts.create');
    Route::delete('gifts/{id}', 'GiftController@delete')->name('room.gifts.destroy');

    Route::get('schedules', 'ScheduleController@schedules')->name('room.schedules');
    Route::post('schedules/create', 'ScheduleController@create')->name('room.schedules.create');
    Route::delete('schedules/{id}', 'ScheduleController@delete')->name('room.schedules.destroy');

    Route::get('credits', 'CreditsController@credits')->name('room.credits');
    Route::post('credits/create', 'CreditsController@create')->name('room.credits.create');
    Route::delete('credits/{id}', 'CreditsController@delete')->name('room.credits.destroy');

    Route::get('goods', 'GoodsController@goods')->name('room.goods');
    Route::post('goods/create', 'GoodsController@create')->name('room.goods.create');
    Route::get('goods/{id}/status', 'GoodsController@status')->name('room.goods.status');
    Route::delete('goods/{id}', 'GoodsController@delete')->name('room.goods.destroy');

    Route::get('orders', 'OrderController@orders')->name('room.orders');
    Route::get('orders/{id}/status', 'OrderController@status')->name('room.orders.status');


    Route::post('{id}/co', 'RoomController@closeOrOpen')->name('room.close');
  });



  Route::group(['prefix' => 'credits'], function () {
    Route::get('online', 'CreditsController@credits')->name('credits.online');
    Route::get('others', 'CreditsController@others')->name('credits.others');
    Route::post('others', 'CreditsController@postOthers')->name('credits.others');

  });


  Route::group(['prefix' => 'users'], function () {
    Route::get('/', 'UsersController@index')->name('users.index');
    Route::get('/create', 'UsersController@create')->name('users.create');
    Route::post('/','UsersController@store')->name('users.store');
    Route::get('/{id}/edit','UsersController@edit')->name('users.edit');
    Route::get('/{ip}/banIp','UsersController@banIp')->name('users.banIp');
    Route::get('/{ip}/gag','UsersController@gag')->name('users.gag');
    Route::get('/{ip}/disable','UsersController@disable')->name('users.disable');
    Route::delete('/{id}', 'UsersController@destroy')->name('users.destroy');
    Route::get('/online','UsersController@online')->name('users.online.index');
    Route::get('/robots','RobotsController@index')->name('users.robots.index');
    Route::get('/robots/create','RobotsController@create')->name('users.robots.create');
    Route::post('/robots','RobotsController@store')->name('users.robots.store');
    Route::delete('/robots/{id}','RobotsController@destroy')->name('users.robots.destroy');
    Route::get('/robots/{id}/edit','RobotsController@edit')->name('users.robots.edit');
  });
  Route::group(['prefix' => 'admin'], function () {
    Route::get('groupsl', 'GroupController@groups')->name('admin.groupsl');

    Route::group(['namespace' => 'Admin'], function () {
      Route::get('/areas', 'AreaController@areas')->name('admin.areas');
      Route::get('/areas/create', 'AreaController@create')->name('admin.areas.create');
      Route::post('/areas/create', 'AreaController@post')->name('admin.areas.create');
      Route::get('/areas/{id}/edit', 'AreaController@edit')->name('admin.areas.edit');
      Route::post('/areas/{id}/edit', 'AreaController@postEdit')->name('admin.areas.edit');
      Route::get('/{type}/{id}/status', 'MainController@status')->name('admin.areas.status');

      Route::get('/rooms', 'RoomController@rooms')->name('admin.rooms');
      Route::get('/rooms/create', 'RoomController@create')->name('admin.rooms.create');
      Route::post('/rooms/create', 'RoomController@post')->name('admin.rooms.create');
      Route::get('/rooms/{id}/edit', 'RoomController@edit')->name('admin.rooms.edit');
      Route::post('/rooms/{id}/edit', 'RoomController@postEdit')->name('admin.rooms.edit');

      Route::get('/groups', 'GroupController@groups')->name('admin.groups');
      Route::get('/groups/create', 'GroupController@create')->name('admin.groups.create');
      Route::post('/groups/create', 'GroupController@post')->name('admin.groups.create');
      Route::get('/groups/{id}/edit', 'GroupController@edit')->name('admin.groups.edit');
      Route::post('/groups/{id}/edit', 'GroupController@postEdit')->name('admin.groups.edit');

      Route::get('/agents', 'AgentController@agents')->name('admin.agents');
      Route::get('/agents/create', 'AgentController@create')->name('admin.agents.create');
      Route::post('/agents/create', 'AgentController@post')->name('admin.agents.create');
      Route::get('/agents/{id}/edit', 'AgentController@edit')->name('admin.agents.edit');
      Route::post('/agents/{id}/edit', 'AgentController@postEdit')->name('admin.agents.edit');
    });
  });
  Route::post('/admin/password', 'HomeController@password')->name('admin.password');

  Route::group(['prefix' => 'api'], function () {
    Route::get('filter/areas', 'FilterController@areas');
    Route::get('filter/{areaId}/rooms/{main?}', 'FilterController@rooms');
    Route::get('filter/{roomId}/groups','FilterController@groups');
    Route::get('filter/{groupId}/agents','FilterController@agents');
    Route::get('filter/{agentId}/masters','FilterController@masters');
  });
  Route::group(['prefix' => 'statistics'],function(){
      Route::get('login', 'StatisticsController@login')->name('statistics.login');
      Route::get('online', 'StatisticsController@online')->name('statistics.online');
      Route::get('history', 'StatisticsController@history')->name('statistics.history');
      Route::get('area', 'StatisticsController@area')->name('statistics.area');
      Route::get('room', 'StatisticsController@room')->name('statistics.room');
      Route::get('group', 'StatisticsController@group')->name('statistics.group');
      Route::get('groupjl', 'StatisticsController@groupjl')->name('statistics.groupjl');

      Route::get('getroomlist','StatisticsController@getroom')->name('statistics.getroom');
      Route::get('getgrouplist','StatisticsController@getgroup')->name('statistics.getgroup');
      Route::get('getbusiness','StatisticsController@getbusiness')->name('statistics.getbusiness');
      Route::get('getdatechart','StatisticsController@getdatechart')->name('statistics.getdatechart');
      Route::get('gethomedata','StatisticsController@gethomedata')->name('statistics.gethomedata');
      Route::get('gethistorytimerange','StatisticsController@gethistorytimerange')->name('statistics.gethistorytimerange');

      Route::get('gethomecountdatainteval','StatisticsController@gethomecountdatainteval')->name('statistics.gethomecountdatainteval');
      /*导出今日登陆*/
      Route::get('/excellogin',function(StatisticsRepository $repository, Illuminate\Http\Request $request){
        $user= \Auth::user();
        //$result = $repository->users($user,$request);
          $result  = $repository->excellogin($user,$request);
        $array=array();
            foreach($result as $item){
                array_push($array,[
                    '序号'=>$item->id,
                    '区域'=>$item->aname,
                    '房间'=>isset($item->title)?$item->title:'房间管理员',
                    '团队'=>isset($item->gname)?$item->gname:'团队经理',
                    '业务员'=>isset($item->agentname)?$item->agentname:"暂无",
                    '登录时间'=>isset($item->last_login)?$item->last_login:'暂无',
                    'IP地址'=>isset($item->last_ip)?$item->last_ip:'暂无'
                ]);
        }
        Excel::create('今日登陆', function($excel) use($array){
              $excel->sheet('今日登陆', function($sheet) use($array) {
                  $sheet->fromArray($array);
                  $sheet->setOrientation('landscape');
              });
        })->export('xls');
      });
      /*导出日在线人数*/
      Route::get('/excelonline',function(StatisticsRepository $repository, Illuminate\Http\Request $request){
          $user= \Auth::user();
          $data =null;
          $rolename=$user->roles()->first()->name;
          if($rolename=="area_admin"){
              $masterroom= $repository->getmasterroomid($user->area_id);
              $data= $repository->getareadatetimestat($user,$request,$masterroom->id);
              $array=array();
              foreach ($data as $item) {
                  array_push($array,[
                      '日期'=>$item->date,
                      '数量'=>$item->number.'人',
                      '讲师'=>$item->lecturername
                  ]);
              }
              Excel::create('日在线人数', function($excel) use($array){
                  $excel->sheet('日在线人数', function($sheet) use($array) {
                      $sheet->fromArray($array);
                      $sheet->setOrientation('landscape');
                  });
              })->export('xls');
          }else{
              $data= $repository->getdatetimestat($user,$request);
              $array=array();
              foreach ($data as $item) {
                  array_push($array,[
                      '日期'=>$item->date,
                      '数量'=>$item->number.'人',
                  ]);
              }
              Excel::create('日在线人数', function($excel) use($array){
                  $excel->sheet('日在线人数', function($sheet) use($array) {
                      $sheet->fromArray($array);
                      $sheet->setOrientation('landscape');
                  });
              })->export('xls');
          }
      });
      /*导出历史统计数据*/
      Route::get('/excelhistory',function(StatisticsRepository $repository, Illuminate\Http\Request $request){
          $user= \Auth::user();
          $data = $repository->gethistorytimerange($user,$request);
          $array=array();
          foreach ($data as $item) {
              $timeresult='暂无';
              if(isset($item->timeresult)){
                  $start=substr($item->timeresult,8);
                  $cc= intval($start);

                  if($cc<=9) {
                      $timeresult='0'.$cc.':00-'.strval(($cc+1)).':00';
                  }else{
                      $timeresult=$cc.':00-'.strval(($cc+1)).':00';
                  }
              }
              array_push($array,[
                  '日期'=>$item->date,
                  '新用户数'=>$item->newregister.'人',
                  '总登录数'=>$item->totalloginnumber.'人',
                  '峰值时间'=>$timeresult,
                  '峰值数量'=>$item->maxnumber.'人',
                  '苹果登录数'=>$item->iosnumber.'人',
                  '安卓登录数'=>$item->androidnumber.'人',
                  '电脑登录数'=>$item->pcnumber.'人'
              ]);
          }
          Excel::create('历史统计数据', function($excel) use($array){
              $excel->sheet('历史统计数据', function($sheet) use($array) {
                  $sheet->fromArray($array);
                  $sheet->setOrientation('landscape');
              });
          })->export('xls');
      });
      /*导出区域统计*/
      Route::get('/excelarea',function(StatisticsRepository $repository, Illuminate\Http\Request $request){
          $user= \Auth::user();
          $data = $repository->excelarea($user,$request);
          $array=array();
          foreach ($data as $item) {
              array_push($array,[
                  '区域名称'=>$item->name,
                  '房间总数'=>isset($item->roomnumber)?$item->roomnumber:'0'.'个',
                  '团队总数'=>isset($item->groupnumber)?$item->groupnumber:'0'.'个',
                  '业务员数'=>isset($item->businessnumber)?$item->businessnumber:'0'.'个',
                  '用户数'=>isset($item->usernumber)?$item->usernumber:'0'.'个',
                  '当前在线用户数'=>isset($item->onlinenumber)?$item->onlinenumber.'人':'无'
              ]);
          }
          Excel::create('区域统计数据', function($excel) use($array){
              $excel->sheet('区域统计数据', function($sheet) use($array) {
                  $sheet->fromArray($array);
                  $sheet->setOrientation('landscape');
              });
          })->export('xls');
      });
      /*导出区域下面的房间统计*/
      Route::get('/excelrooms',function(StatisticsRepository $repository, Illuminate\Http\Request $request){
          $user= \Auth::user();
          $data = $repository->excelrooms($user,$request);
          $array=array();
          foreach ($data as $item) {
              array_push($array,[
                  '房间名称'=>$item->title,
                  '团队总数'=>isset($item->groupnumber)?$item->groupnumber:'0'.'个',
                  '业务员数'=>isset($item->businessnumber)?$item->businessnumber:'0'.'个',
                  '用户数'=>isset($item->usernumber)?$item->usernumber:'0'.'个',
                  '当前在线'=>isset($item->onlinenumber)?$item->onlinenumber.'人':'0'.'人'
              ]);
          }
          Excel::create('房间统计数据', function($excel) use($array){
              $excel->sheet('房间统计数据', function($sheet) use($array) {
                  $sheet->fromArray($array);
                  $sheet->setOrientation('landscape');
              });
          })->export('xls');
      });
      //房间获取下面所有的团队
      Route::get('/excegroup',function(StatisticsRepository $repository, Illuminate\Http\Request $request){
          $user= \Auth::user();
          $data = $repository->excelgroup($user,$request);
          $array=array();
          foreach ($data as $item) {
              array_push($array,[
                  '区域名称'=>$item->name,
                  '业务员'=>isset($item->businessnumber)?$item->businessnumber:'0'.'个',
                  '用户数'=>isset($item->usernumber)?$item->usernumber:'0'.'个',
              ]);
          }
          Excel::create('房间统计数据', function($excel) use($array){
              $excel->sheet('房间统计数据', function($sheet) use($array) {
                  $sheet->fromArray($array);
                  $sheet->setOrientation('landscape');
              });
          })->export('xls');
      });
      //团队经理获取业务员
      Route::get('/excegroupjl',function(StatisticsRepository $repository, Illuminate\Http\Request $request){
          $user= \Auth::user();
          $data = $repository->excelgroupjs($user,$request);
          $array=array();
          foreach ($data as $item) {
              array_push($array,[
                  '业务员'=>$item->username,
                  '用户数'=>isset($item->usernumber)?$item->usernumber:'0'.'个'
              ]);
          }
          Excel::create('房间统计数据', function($excel) use($array){
              $excel->sheet('房间统计数据', function($sheet) use($array) {
                  $sheet->fromArray($array);
                  $sheet->setOrientation('landscape');
              });
          })->export('xls');
      });
  });
});

