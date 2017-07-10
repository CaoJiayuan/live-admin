<?php namespace App\Repository;

use App\Entity\UserLogs;
use App\User;
use App\Entity\Area;
use App\Entity\Room;
use App\Entity\Group;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Qiniu\Auth;

/**
 * @author <a href="mailto:smartydroid.com@gmail.com">Smartydroid</a>
 */
class StatisticsRepository extends Repository
{
  //统计登录
  public function users($user,Request $request)
  {
    return $this->getSearchAbleData(User::class, [
    ], function ($builder)use ($user,$request) {
      /*@var Builder $builder*/
      $builder->leftJoin('role_user as ru','users.id','=','ru.user_id');
      $builder->leftJoin('areas', 'area_id', '=', 'areas.id');
      $builder->leftJoin('rooms', 'room_id', '=', 'rooms.id');
      $builder->leftJoin('groups', 'group_id', '=', 'groups.id');
      $builder->with('agent');
      //$builder->leftJoin('users as u', 'users.agent_id', '=', 'u.id');
      //$builder->where('users.id','!=','1');
      $rolename=$user->roles()->first()->name;
      switch($rolename){
        case 'super_admin':
          if(!empty($request->get('areaid'))){
            $builder->where('users.area_id','=',$request->get('areaid'));
          }
          if(!empty($request->get('roomid'))){
            $builder->where('users.room_id','=',$request->get('roomid'));
          }
          if(!empty($request->get('groupid'))){
            $builder->where('users.group_id','=',$request->get('groupid'));
          }
          if(!empty($request->get('agentuserid'))){
            $builder->where('users.agent_id','=',$request->get('agentuserid'));
          }
          break;
        case 'area_admin':
          $builder->where('users.area_id','=',$user->area_id);

          if(!empty($request->get('roomid'))){
            $builder->where('users.room_id','=',$request->get('roomid'));
          }
          if(!empty($request->get('groupid'))){
            $builder->where('users.group_id','=',$request->get('groupid'));
          }
          if(!empty($request->get('agentuserid'))){
            $builder->where('users.agent_id','=',$request->get('agentuserid'));
          }
          break;
        case 'room_admin':
          $builder->where('users.room_id','=',$user->room_id);
          if(!empty($request->get('groupid'))){
            $builder->where('users.group_id','=',$request->get('groupid'));
          }
          if(!empty($request->get('agentuserid'))){
            $builder->where('users.agent_id','=',$request->get('agentuserid'));
          }
          break;
        case 'group_admin':
          $builder->where('users.group_id','=',$user->group_id);
          if(!empty($request->get('agentuserid'))){
            $builder->where('users.agent_id','=',$request->get('agentuserid'));
          }
          break;
        case 'agent_admin':
          $builder->where('users.agent_id','=',$user->id);
          break;
      }
      $builder->whereBetween('users.last_login', [Carbon::today(), Carbon::tomorrow()]);
      $builder->orderByDesc('users.last_login');
      $builder->select(['users.*', 'areas.name as aname', 'rooms.title', 'groups.name as gname', 'users.last_login','users.last_ip']);
    });
  }
  //区域统计
  public function getareastat(Request $request){

    return $this->getSearchAbleData(Area::class, [
    ], function ($builder) use($request){
      /** @var Builder $builder */
      $builder->where('enable','1');
      if(!empty($request->get('areaid'))) {
        $builder->where('id',$request->get('areaid'));
      }
      $builder->select([
          'areas.id',
          'areas.name',
          \DB::raw('(select count(r.id) from rooms as r where r.area_id=areas.id) as roomnumber'),
          \DB::raw('(select count(g.id) From groups as g where g.room_id in(select rr.id from rooms as rr where rr.area_id=areas.id)) as groupnumber'),
          \DB::raw('(select count(u.id) from users as u left join role_user as ru on u.id=ru.user_id left join roles as r on ru.role_id=r.id
                  where  r.id=5 and u.area_id=areas.id) as businessnumber'),
          \DB::raw('(select count(u.id) from users as u  where u.area_id=areas.id and u.agent_id is not null) as usernumber'),
          \DB::raw('(select count(*) from users as u where u.area_id=areas.id and u.online=1) as onlinenumber')
      ]);
    });
  }
  //房间统计
  public function getroomstat($user,Request $request)
  {
    return $this->getSearchAbleData(Room::class, [
    ], function ($builder)use ($user,$request) {
      /** @var Builder $builder */
      $builder->where('area_id',$user->area_id);
      $builder->leftJoin('groups as g', 'g.room_id', '=', 'rooms.id');
      if(!empty($request->get('roomid'))) {
        $builder->where('rooms.id',$request->get('roomid'));
      }
      $builder->select([
          'rooms.id',
          'rooms.title',
          \DB::raw('(select count(g.id) From groups as g where g.room_id =rooms.id) as groupnumber'),
          \DB::raw( '(select count(u.id) from users as u left join role_user as ru on u.id=ru.user_id
left join roles as r on ru.role_id=r.id where  r.id=5 and u.room_id=rooms.id and u.group_id=g.id) as businessnumber'),
          \DB::raw('(select count(u.id) from users as u  where u.room_id=rooms.id and u.group_id=g.id and u.agent_id is not null) as usernumber'),
          \DB::raw('(select count(u.id) from users as u  where u.room_id=rooms.id and u.group_id=g.id and u.agent_id is not null and u.online=1) as onlinenumber'),
      ]);

    });
  }
  //获取团队统计
  public function getgroupstat($user,Request $request){

    return $this->getSearchAbleData(Group::class, [
    ], function ($builder)use ($user,$request) {
      /** @var Builder $builder */
      $builder->where('room_id',$user->room_id);
      if(!empty($request->get('groupid'))) {
        $builder->where('groups.id',$request->get('groupid'));
      }
      $builder->select([
          'groups.id',
          'groups.name',
          \DB::raw('(select count(u.id) from users as u
left join role_user as ru on u.id=ru.user_id
left join roles as r on ru.role_id=r.id
where  r.id=5 and u.room_id='.$user->room_id.' and u.group_id=groups.id) as businessnumber'),
          \DB::raw('(select count(u.id) from users as u  where u.room_id='.$user->room_id.' and u.group_id=groups.id and u.agent_id is not null) as usernumber'),
          \DB::raw('(select count(*) from users as u where u.room_id='.$user->room_id.' and u.group_id=groups.id and u.online=1) as onlinenumber')
      ]);
    });
  }
  //获取改组下面的所有业务员
  public function getgroupjlstat($user,Request $request){

    return $this->getSearchAbleData(User::class, [
    ], function ($builder)use ($user,$request) {
      /** @var Builder $builder */
      $builder->leftJoin('role_user as ru','users.id','=','ru.user_id');
      $builder->where('ru.role_id','=','5');
      $builder->where('users.area_id','=',$user->area_id);
      $builder->where('users.room_id','=',$user->room_id);
      $builder->where('users.group_id','=',$user->group_id);


      if(!empty($request->get('agentuserid'))){
        $builder->where('users.id','=',$request->get('agentuserid'));
      }

      $builder->select(['users.id','users.username',
         \DB::raw('(select count(u.id) from users as u  where u.group_id='.$user->group_id.' and u.agent_id=users.id) as usernumber'),
         \DB::raw('(select count(u.id) from users as u  where u.group_id='.$user->group_id.' and u.online=1 and u.agent_id=users.id) as onlinenumber')
      ]);

    });
  }
  //获取日在线统计
  public function getdatetimestat($user,Request $request){
            $query='';
            //如果日期不存在则是当天
            if(empty($request->get('date'))) {
              $query= date('Y-m-d', Carbon::now()->getTimestamp());
            }else{//否则就是选择的日期
              $query=str_replace('/','-',$request->get('date')) ;
            }
            $currenttime= time();
            $result='';
            $condition='';
            $rolename=$user->roles()->first()->name;
            switch($rolename){
              case config('roles.super_admin.name'):
                break;
              case config('roles.area_admin.name'):
                $condition=' u.area_id='.$user->area_id.' and';
                break;
              case config('roles.room_admin.name'):
                $condition=' u.room_id='.$user->room_id.' and';
                break;
              case config('roles.group_admin.name'):
                $condition=' u.group_id='.$user->group_id.' and';
                break;
              case config('roles.agent_admin.name'):
                $condition=' u.agent_id='.$user->id.' and';
                break;
            }
            //获取语句
            $sql='';
            for($i=9;$i<=23;$i++){
                if($i>=23) {
                  break;
                }
                else{
                  $next=$i+1;
                  //今天的日期
                  $today=strtotime(date('Y-m-d', Carbon::now()->getTimestamp())."23:59:59");
                  //选择的日期
                  $select=strtotime($query."00:00:00");
                  //选择的日期如果大于今天的日期,则默认是0
                  if($select>$today){
                    $sql=$sql."select '$i:00-$next:00' as date,0 as number";
                  }
                  else{
                  $squerystarttime=strtotime($query."$i:00:00");
                  $squeryendtime=strtotime($query."$next:00:00");

                    if(($currenttime>=$squerystarttime && $currenttime<=$squeryendtime) ||($squeryendtime<$currenttime) ) {
                      $sql = $sql."select '$i:00-$next:00' as date, count(*) as number from (
                    select  ul.user_id From user_logs as ul
                    left join users as u on ul.user_id=u.id
                    where $condition (
                    (ul.created_at>='$query $i:00:00' and  ul.created_at<='$query $next:00:00')
                    or
                    (ul.logout_at>='$query $i:00:00' and  ul.logout_at<='$query $next:00:00')
                    or
                    (ul.created_at<='$query $next:00:00' and ul.logout_at is null)
                    )
                        group by ul.user_id
                  ) as tbl";
                    }
                    else{
                      $sql=$sql."select '$i:00-$next:00' as date,0 as number";
                    }
                  }
                }
                if($i<22) {
                  $sql=$sql.' union all ';
                }
            }

          $result=\DB::connection()->select($sql);
          return $result;
  }
  //获取区域日在线统计
  public function getareadatetimestat($user,Request $request,$masterid)
  {
            $query='';
            //如果日期不存在则
            if(empty($request->get('date'))) {
              $query= date('Y-m-d', Carbon::now()->getTimestamp());
            }else{
              $query=str_replace('/','-',$request->get('date')) ;
            }
            $checkDayStr = date('Y-m-d ',time());
            $condition='';
            $rolename=$user->roles()->first()->name;

            $currenttime= time();
            switch($rolename){
              case config('roles.super_admin.name'):
                break;
              case config('roles.area_admin.name'):
                $condition=' u.area_id='.$user->area_id.' and';
                break;
              case config('roles.room_admin.name'):
                $condition=' u.room_id='.$user->room_id.' and';
                break;
              case config('roles.group_admin.name'):
                $condition=' u.group_id='.$user->group_id.' and';
                break;
              case config('roles.agent_admin.name'):
                $condition=' u.agent_id='.$user->id.' and';
                break;
            }
            //获取语句
            $sql='';
            for($i=9;$i<=23;$i++){
              if($i>=23) {
                break;
              }
              else{
                $next=$i+1;
                //今天的日期
                $today=strtotime(date('Y-m-d', Carbon::now()->getTimestamp())."23:59:59");
                //选择的日期
                $select=strtotime($query."00:00:00");
                //选择的日期如果大于今天的日期,则默认是0
                if($select>$today){
                  $sql=$sql."select '$i:00-$next:00' as date,0 as number,'暂无' as lecturername";
                }
                else{
                  $squerystarttime=strtotime($query."$i:00:00");
                  $squeryendtime=strtotime($query."$next:00:00");

                  if(($currenttime>=$squerystarttime && $currenttime<=$squeryendtime) ||($squeryendtime<$currenttime) ) {
                    $sql = $sql."select '$i:00-$next:00' as date, count(*) as number,
                                        ifnull((select name from lecturers as l where l.id=(select t.lecturer_id From timetables as t where
DATE_FORMAT(t.time, '%Y-%m-%d')='$query' and t.room_id=$masterid and
 t.hour=$i limit 1)),'暂无') as lecturername

                     from (
                    select  ul.user_id From user_logs as ul
                    left join users as u on ul.user_id=u.id
                    where $condition (
                    (ul.created_at>='$query $i:00:00' and  ul.created_at<='$query $next:00:00')
                    or
                    (ul.logout_at>='$query $i:00:00' and  ul.logout_at<='$query $next:00:00')
                    or
                    (ul.created_at<='$query $next:00:00' and ul.logout_at is null)
                    )
                        group by ul.user_id
                  ) as tbl";
                  }
                  else{
                    $sql=$sql."select '$i:00-$next:00' as date,0 as number, '暂无' as lecturername";
                  }
                }

              }
              if($i<22) {
                $sql=$sql.' union all ';
              }
            }
            $result=\DB::connection()->select($sql);
            return $result;
  }
  //获取主页的统计总计数据信息
  public function gethomecountstat($user)
  {
    $condition='';
    $online='';
    $rolename=$user->roles()->first()->name;
    switch($rolename){
      case config('roles.super_admin.name'):
        $condition="select count(*) as num From users as u
left join role_user as ur on u.id=ur.user_id
where u.id!=1
union all
select count(*) From users as u
left join role_user as ur on u.id=ur.user_id
where  u.online=1
union all
select count(*) from rooms where  main=0";

        break;
      case config('roles.area_admin.name'):
        $condition="select count(*)  as num From users as u left join role_user as ur on u.id=ur.user_id
where  u.area_id=".$user->area_id."
union all select count(*) From users as u left join role_user as ur on u.id=ur.user_id where  u.area_id=".$user->area_id." and u.online=1
union all select count(*) from rooms as r where r.area_id=".$user->area_id." and r.main=0";

        //在线
        $online=" and u.area_id=".$user->area_id;
        break;
      case config('roles.room_admin.name'):
        $condition="select count(*)  as num From users as u
left join role_user as ur on u.id=ur.user_id where  u.area_id=".$user->area_id." and u.room_id=".$user->room_id."
union all select count(*) From users as u  left join role_user as ur on u.id=ur.user_id
where  u.area_id=".$user->area_id." and u.room_id=".$user->room_id." and u.online=1";

        //在线
        $online="  and u.area_id=".$user->area_id." and u.room_id=".$user->room_id;
        break;
      case config('roles.group_admin.name'):
        $condition="select count(*)  as num From users as u
left join role_user as ur on u.id=ur.user_id
where  u.area_id=".$user->area_id." and u.room_id=".$user->room_id." and u.group_id=".$user->group_id."
union all select count(*) From users as u left join role_user as ur on u.id=ur.user_id
where  u.area_id=".$user->area_id." and u.room_id=".$user->room_id." and u.group_id=".$user->group_id." and u.online=1 ";

        $online="  and u.area_id=".$user->area_id." and u.room_id=".$user->room_id." and u.group_id=".$user->group_id;
        break;
      case config('roles.agent_admin.name'):
        $condition="select count(*)  as num From users as u where u.agent_id=".$user->id." union all select count(*) From users as u
where u.agent_id=".$user->id." and u.online=1";

        $online="  and u.agent_id=".$user->id;
        break;
    }

    $now= date('Y-m-d', Carbon::now()->getTimestamp());

    $condition=$condition."
        union all
        select count(*) From users as u
        left join role_user as ur on u.id=ur.user_id
        where  u.online=1 $online
        and
        (lower(u.ua) ='pc' or u.ua is null)
        union all
        select count(*) From users as u
        left join role_user as ur on u.id=ur.user_id
        where  u.online=1  $online and
        lower(u.ua)!='pc' and u.ua is not null
        union all
       select count(*) from (
       select  ul.user_id From user_logs as ul
       RIGHT join users as u on ul.user_id=u.id
       where (ul.logout_at > '$now 00:00:00' or ul.logout_at is null) $online and ul.user_id is not null
       GROUP BY user_id
       ) as tbl";


    $result=\DB::connection()->select($condition);
    return $result ;
  }
  //获取后十天数据
  public function getlasttimedatachart($user)
  {
    $pre = \DB::getTablePrefix();
    $raws = [];
    for ($i = -9; $i <= 0 ; $i++) {
      $date = Carbon::now()->addDay($i)->toDateString();
      $raws[] = <<<SQL
select '$date',count(*) as num from
(select distinct user_id from {$pre}user_logs as ul where created_at BETWEEN '$date 00:00:00' and '$date 23:59:59') as tbl
SQL;
    }
    $logs = \DB::connection()->select(implode(' union all ', $raws));
    return $logs;
    /*
    $begin='';
    $end='';
    //获取最近十天数据信息
    if (!$begin || !$end) {
      $end= date('Y-m-d', Carbon::now()->getTimestamp());
      $begin= date('Y-m-d', Carbon::now()->addDay(-9)->getTimestamp());
    }
    $rolename=$user->roles()->first()->name;
    $condition='';

    switch($rolename){

    }
    $sql="select
            tbl.date,
            (select count(*)from user_logs as ul  left join users as u on ul.user_id=u.id  where DATE_FORMAT(ul.created_at, '%Y-%m-%d')=tbl.date $condition) as num
            from (select adddate('$begin', numlist.id) as `date` from (SELECT n1.i + n10.i*10 + n100.i*100 AS id
            FROM num n1 cross join num as n10 cross join num as n100) as numlist where adddate('$begin', numlist.id) <= '$end') as tbl";

   // dd($sql);
    return $result=\DB::connection()->select($sql);
    */
  }
  //获取历史数据信息
  public function gethistorytimerange($user,Request $request)
  {
            $begin=str_replace('/','-',$request->get('begin'));
            $end=str_replace('/','-',$request->get('end'));
            if (!$begin || !$end) {
              $end= date('Y-m-d', Carbon::now()->getTimestamp());
              $begin= date('Y-m-d', Carbon::now()->addDay(-9)->getTimestamp());
            }
            $condition='';
            $rolename=$user->roles()->first()->name;
            switch($rolename){
              case 'super_admin':
                if(!empty($request->get('areaid'))){
                  $condition=' and u.area_id='.$request->get('areaid');
                }
                if(!empty($request->get('roomid'))){
                  $condition=$condition.' and u.room_id='.$request->get('roomid');
                }
                if(!empty($request->get('groupid'))){
                  $condition=$condition.' and u.group_id='.$request->get('groupid');
                }
                if(!empty($request->get('agentuserid'))){
                  $condition=$condition.' and u.agent_id='.$request->get('agentuserid');
                }
                break;
              case 'area_admin':
                $condition=' and u.area_id='.$user->area_id;
                if(!empty($request->get('roomid'))){
                  $condition=$condition.' and u.room_id='.$request->get('roomid');
                }
                if(!empty($request->get('groupid'))){
                  $condition=$condition.' and u.group_id='.$request->get('groupid');
                }
                if(!empty($request->get('agentuserid'))){
                  $condition=$condition.' and u.agent_id='.$request->get('agentuserid');
                }
                break;
              case 'room_admin':
                $condition=' and u.room_id='.$user->room_id;
                if(!empty($request->get('groupid'))){
                  $condition=$condition.' and u.group_id='.$request->get('groupid');
                }
                if(!empty($request->get('agentuserid'))){
                  $condition=$condition.' and u.agent_id='.$request->get('agentuserid');
                }
                break;
              case 'group_admin':
                $condition=' and u.group_id='.$user->group_id;
                if(!empty($request->get('agentuserid'))){
                  $condition=$condition.' and u.agent_id='.$request->get('agentuserid');
                }
                break;
              case 'agent_admin':
                $condition=' and u.agent_id='.$user->id;
                break;
            }

            $stimestamp = strtotime($begin);
            $etimestamp = strtotime($end);
            // 计算日期段内有多少天
            $days = ($etimestamp-$stimestamp)/86400+1;
            // 保存每天日期
            $date = array();
            for($i=0; $i<$days; $i++){
              $date[] = date('Y-m-d', $stimestamp+(86400*$i));
            }

            for($i=0;$i<count($date);$i++) {
              $sql = <<<SQL
                      select count(*) as num
                      from users as u left join role_user as ru on u.id=ru.user_id
                      where  date_format(u.created_at, '%Y-%m-%d')='$date[$i]' $condition
                      union all
                      select count(*) from (
                      select ul.user_id from user_logs as ul right join users as u on u.id=ul.user_id where  DATE_FORMAT(ul.created_at, '%Y-%m-%d')='$date[$i]' $condition
                      group by   ul.user_id
                      ) as tbl
                      union all
                      select count(*) from (
                          select ul.user_id from user_logs as ul left join users as u on u.id=ul.user_id where  DATE_FORMAT(ul.created_at, '%Y-%m-%d')='$date[$i]' $condition and lower(ul.ua)='pc'
                      group by   ul.user_id
                      ) as tbl
                      union all
                      select count(*) from (
                          select ul.user_id from user_logs as ul left join users as u on u.id=ul.user_id where  DATE_FORMAT(ul.created_at, '%Y-%m-%d')='$date[$i]' $condition and lower(ul.ua)='android'
                      group by   ul.user_id
                      ) as tbl
                      union all
                      select count(*) from (
                      select ul.user_id from user_logs as ul left join users as u on u.id=ul.user_id where  DATE_FORMAT(ul.created_at, '%Y-%m-%d')='$date[$i]' $condition and lower(ul.ua)='ios'
                      group by   ul.user_id
                      ) as tbl
SQL;
              $countnumber= \DB::connection()->select($sql);

              $toptimenumber=  $this-> getdatetoptimenumber($condition,$date[$i]);
              $nums = $toptimenumber;
              usort($nums, function ($a, $b){
                return $a->number < $b->number;
              });
              $chart[] = [
                  'date'=>$date[$i],
                  'newregister' => $countnumber[0]->num,
                  'totalloginnumber' => $countnumber[1]->num,
                  'pcnumber' => $countnumber[2]->num,
                  'androidnumber' => $countnumber[3]->num,
                  'iosnumber' => $countnumber[4]->num,
                  'maxnumber' => reset($nums)->number,
                  'timeresult' =>reset($nums)->date
              ];
            }
            return $chart;
  }
  //登录信息
  public function excellogin($user,Request $request){
    $rolename=$user->roles()->first()->name;
    $builder=User::leftJoin('role_user as ru','users.id','=','ru.user_id')
          ->leftJoin('areas', 'area_id', '=', 'areas.id')
          ->leftJoin('rooms', 'room_id', '=', 'rooms.id')
          ->leftJoin('groups', 'group_id', '=', 'groups.id')
          ->leftJoin('users as u', 'users.agent_id', '=', 'u.id')->where('ru.role_id','!=','1');
    switch($rolename){
      case 'super_admin':
        if(!empty($request->get('areaid'))){
          $builder->where('users.area_id','=',$request->get('areaid'));
        }
        if(!empty($request->get('roomid'))){
          $builder->where('users.room_id','=',$request->get('roomid'));
        }
        if(!empty($request->get('groupid'))){
          $builder->where('users.group_id','=',$request->get('groupid'));
        }
        if(!empty($request->get('agentuserid'))){
          $builder->where('users.agent_id','=',$request->get('agentuserid'));
        }
        break;
      case 'area_admin':
        $builder->where('users.area_id','=',$user->area_id);

        if(!empty($request->get('roomid'))){
          $builder->where('users.room_id','=',$request->get('roomid'));
        }
        if(!empty($request->get('groupid'))){
          $builder->where('users.group_id','=',$request->get('groupid'));
        }
        if(!empty($request->get('agentuserid'))){
          $builder->where('users.agent_id','=',$request->get('agentuserid'));
        }
        break;
      case 'room_admin':
        $builder->where('users.room_id','=',$user->room_id);
        if(!empty($request->get('groupid'))){
          $builder->where('users.group_id','=',$request->get('groupid'));
        }
        if(!empty($request->get('agentuserid'))){
          $builder->where('users.agent_id','=',$request->get('agentuserid'));
        }
        break;
      case 'group_admin':
        $builder->where('users.group_id','=',$user->group_id);
        if(!empty($request->get('agentuserid'))){
          $builder->where('users.agent_id','=',$request->get('agentuserid'));
        }
        break;
      case 'agent_admin':
        $builder->where('users.agent_id','=',$user->id);
        break;
    }
    $builder->whereBetween('users.last_login', [Carbon::today(), Carbon::tomorrow()]);
    $builder->orderByDesc('users.last_login');
    $builder->select(['users.id', 'areas.name as aname', 'rooms.title', 'groups.name as gname', 'users.name as agentname', 'users.last_login','users.last_ip']);
    return $builder->get();

  }
  //当前区域统计信息
  public function excelarea($user,Request $request){

        $builder=  Area::where('enable','1');
        if(!empty($request->get('areaid'))) {
          $builder->where('id',$request->get('areaid'));
        }
       $builder= $builder->select([
            'areas.id',
            'areas.name',
            \DB::raw('(select count(r.id) from rooms as r where r.area_id=areas.id) as roomnumber'),
            \DB::raw('(select count(g.id) From groups as g where g.room_id in(select rr.id from rooms as rr where rr.area_id=areas.id)) as groupnumber'),
            \DB::raw('(select count(u.id) from users as u left join role_user as ru on u.id=ru.user_id left join roles as r on ru.role_id=r.id
                      where  r.id=5 and u.area_id=areas.id) as businessnumber'),
            \DB::raw('(select count(u.id) from users as u  where u.area_id=areas.id and u.agent_id is not null) as usernumber'),
            \DB::raw('(select count(*) from users as u where u.area_id=areas.id and u.online=1) as onlinenumber')
        ]);
        return $builder->get();
  }
  //获取该区域下面的房间
  public function excelrooms($user,Request $request){
       $builder= Room::where('area_id',$user->area_id)->leftJoin('groups as g', 'g.room_id', '=', 'rooms.id');
        if(!empty($request->get('roomid'))) {
          $builder=  $builder->where('rooms.id',$request->get('roomid'));
        }

        $builder=  $builder->select([
            'rooms.id',
            'rooms.title',
            \DB::raw('(select count(g.id) From groups as g where g.room_id =rooms.id) as groupnumber'),
            \DB::raw( '(select count(u.id) from users as u left join role_user as ru on u.id=ru.user_id
    left join roles as r on ru.role_id=r.id where  r.id=5 and u.room_id=rooms.id and u.group_id=g.id) as businessnumber'),
            \DB::raw('(select count(u.id) from users as u  where u.room_id=rooms.id and u.group_id=g.id and u.agent_id is not null) as usernumber'),
            \DB::raw('(select count(u.id) from users as u  where u.room_id=rooms.id and u.group_id=g.id and u.agent_id is not null and u.online=1) as onlinenumber')
        ]);
    return $builder->get();

  }
  //房间管理员下面的团队
  public function excelgroup($user,Request $request){
      $builder=Group::where('room_id',$user->room_id);
      if(!empty($request->get('groupid'))) {
        $builder= $builder->where('groups.id',$request->get('groupid'));
      }

    $builder= $builder->select([
        'groups.id',
        'groups.name',
        \DB::raw('(select count(u.id) from users as u
left join role_user as ru on u.id=ru.user_id
left join roles as r on ru.role_id=r.id
where  r.id=5 and u.room_id='.$user->room_id.' and u.group_id=groups.id) as businessnumber'),
        \DB::raw('(select count(u.id) from users as u  where u.room_id='.$user->room_id.' and u.group_id=groups.id and u.agent_id is not null) as usernumber'),
    ]);
    return $builder->get();
  }
  //团队经理
  public function excelgroupjs($user,Request $request){


    $builder=User::leftJoin('role_user as ru','users.id','=','ru.user_id');
    $builder=$builder->where('ru.role_id','=','5');
    $builder=$builder->where('users.area_id','=',$user->area_id);
    $builder=$builder->where('users.room_id','=',$user->room_id);
    $builder=$builder->where('users.group_id','=',$user->group_id);
    if(!empty($request->get('agentuserid')) && $request->get('agentuserid')!='0'){
      $builder= $builder->where('users.id','=',$request->get('agentuserid'));
    }
    $builder= $builder->select(['users.id','users.username',
        \DB::raw('(select count(u.id) from users as u  where u.group_id='.$user->group_id.' and u.agent_id=users.id) as usernumber'),
    ]);

    return $builder->get();
  }
  //testgetcount
  public function getCounts()
  {
    $pre = \DB::getTablePrefix();

    $raws = [];
    for ($i = -7; $i <= 0 ; $i++) {
      $date = Carbon::now()->addDay($i)->toDateString();
      $raws[] = <<<SQL
select '$date',count(*) as num from 
(select distinct user_id from {$pre}user_logs as ul where created_at BETWEEN '$date 00:00:00' and '$date 23:59:59') as tbl
SQL;
    }

    $logs = \DB::connection()->select(implode(' union all ', $raws));

    return $logs;
  }
  //首页展示前10天的图表统计前十天的数据
  public function homechartdata($user){

    $begin=null;
    $end=null;
    if (!$begin || !$end) {
      $end= date('Y-m-d', Carbon::now()->getTimestamp());
      $begin= date('Y-m-d', Carbon::now()->addDay(-9)->getTimestamp());
    }
    $condition='';
    $rolename=$user->roles()->first()->name;
    switch($rolename){
      case 'super_admin':
        break;
      case 'area_admin':
        $condition=' and u.area_id='.$user->area_id;
        break;
      case 'room_admin':
        $condition=' and u.room_id='.$user->room_id;
        break;
      case 'group_admin':
        $condition=' and u.group_id='.$user->group_id;
        break;
      case 'agent_admin':
        $condition=' and u.agent_id='.$user->id;
        break;
    }
    $sql=<<<SQL
        	    select
            tbl.date,
	    (select count(*) from users as u left join role_user as ru on u.id=ru.user_id where ru.role_id!=1 $condition and date_format(u.created_at, '%Y-%m-%d')=tbl.date ) newregister,
	    (select count(*) from user_logs as ul left join users as u on u.id=ul.user_id where  DATE_FORMAT(ul.created_at, '%Y-%m-%d')=tbl.date $condition ) as totalloginnumber,
        (select count(*) from user_logs as ul left join users as u on u.id=ul.user_id where  DATE_FORMAT(ul.created_at, '%Y-%m-%d')=tbl.date and lower(ul.ua)='pc' $condition) as pcnumber,
        (select count(*) from user_logs as ul left join users as u on u.id=ul.user_id where  DATE_FORMAT(ul.created_at, '%Y-%m-%d')=tbl.date and lower(ul.ua)='android' $condition) as androidnumber,
        (select count(*) from user_logs as ul left join users as u on u.id=ul.user_id where  DATE_FORMAT(ul.created_at, '%Y-%m-%d')=tbl.date and lower(ul.ua)='ios' $condition) as iosnumber,
	    ifnull((select date_format(ul.created_at,'%Y%m%d%H')
	    from user_logs as ul
	    left join users as u on u.id=ul.user_id
            where   date_format(ul.created_at,'%Y%m%d')=date_format(tbl.date,'%Y%m%d') $condition
	    group by date_format(ul.created_at,'%Y%m%d%H')
	    order by count(*) desc
	    limit 1),'') as timeresult,

	   ifnull((select count(*)
	    from user_logs as ul
	    left join users as u on u.id=ul.user_id
            where   date_format(ul.created_at,'%Y%m%d')=date_format(tbl.date,'%Y%m%d') $condition
	    group by date_format(ul.created_at,'%Y%m%d%H')
	    order by count(*) desc
	    limit 1),0) as maxnumber

            from (select adddate('$begin', numlist.id) as `date` from (SELECT n1.i + n10.i*10 + n100.i*100 AS id
            FROM num n1 cross join num as n10 cross join num as n100) as numlist where adddate('$begin', numlist.id) <= '$end') as tbl
SQL;

    //dd($sql);

    return $result=\DB::connection()->select($sql);
  }
  //获取图表信息
  public function homechartnewdata($user)
  {
    $chart=[];
    $begin=null;
    $end=null;
    if (!$begin || !$end) {
      $end= date('Y-m-d', Carbon::now()->getTimestamp());
      $begin= date('Y-m-d', Carbon::now()->addDay(-9)->getTimestamp());
    }
    $condition='';
    $rolename=$user->roles()->first()->name;
    switch($rolename){
      case 'super_admin':
        break;
      case 'area_admin':
        $condition=' and u.area_id='.$user->area_id;
        break;
      case 'room_admin':
        $condition=' and u.room_id='.$user->room_id;
        break;
      case 'group_admin':
        $condition=' and u.group_id='.$user->group_id;
        break;
      case 'agent_admin':
        $condition=' and u.agent_id='.$user->id;
        break;
    }
    $stimestamp = strtotime($begin);
    $etimestamp = strtotime($end);
    // 计算日期段内有多少天
    $days = ($etimestamp-$stimestamp)/86400+1;
    // 保存每天日期
    $date = array();
    for($i=0; $i<$days; $i++){
      $date[] = date('Y-m-d', $stimestamp+(86400*$i));
    }
      for($i=0;$i<count($date);$i++) {
                $sql = <<<SQL
              select count(*) as num
              from users as u left join role_user as ru on u.id=ru.user_id
              where  date_format(u.created_at, '%Y-%m-%d')='$date[$i]' $condition
              union all
              select count(*) from (
              select ul.user_id from user_logs as ul right join users as u on u.id=ul.user_id where  DATE_FORMAT(ul.created_at, '%Y-%m-%d')='$date[$i]' $condition
              group by   ul.user_id
              ) as tbl
              union all
              select count(*) from (
                  select ul.user_id from user_logs as ul left join users as u on u.id=ul.user_id where  DATE_FORMAT(ul.created_at, '%Y-%m-%d')='$date[$i]' $condition and lower(ul.ua)='pc'
              group by   ul.user_id
              ) as tbl
              union all
              select count(*) from (
                  select ul.user_id from user_logs as ul left join users as u on u.id=ul.user_id where  DATE_FORMAT(ul.created_at, '%Y-%m-%d')='$date[$i]' $condition and lower(ul.ua)='android'
              group by   ul.user_id
              ) as tbl
              union all
              select count(*) from (
              select ul.user_id from user_logs as ul left join users as u on u.id=ul.user_id where  DATE_FORMAT(ul.created_at, '%Y-%m-%d')='$date[$i]' $condition and lower(ul.ua)='ios'
              group by   ul.user_id
              ) as tbl
SQL;



       $countnumber= \DB::connection()->select($sql);

       $toptimenumber=  $this-> getdatetoptimenumber($condition,$date[$i]);
       $nums = $toptimenumber;
        usort($nums, function ($a, $b){
          return $a->number < $b->number;
        });
       $chart[] = [
         'date'=>$date[$i],
         'newregister' => $countnumber[0]->num,
         'totalloginnumber' => $countnumber[1]->num,
         'pcnumber' => $countnumber[2]->num,
         'androidnumber' => $countnumber[3]->num,
         'iosnumber' => $countnumber[4]->num,
         'maxnumber' => reset($nums)->number,
         'timeresult' =>reset($nums)->date
       ];
      }
    return $chart;
  }
  //获取峰值和峰值数目
  public function getdatetoptimenumber($condition,$query){
    $currenttime= time();
    //获取语句
    $sql='';
    for($i=9;$i<=23;$i++){
      if($i>=23) {
        break;
      }
      else{
        $next=$i+1;
        //今天的日期
        $today=strtotime(date('Y-m-d', Carbon::now()->getTimestamp())."23:59:59");
        //选择的日期
        $select=strtotime($query."00:00:00");
        //选择的日期如果大于今天的日期,则默认是0
        if($select>$today){
          $sql=$sql."select '$i:00-$next:00' as date,0 as number";
        }
        else{
          $squerystarttime=strtotime($query."$i:00:00");
          $squeryendtime=strtotime($query."$next:00:00");

          if(($currenttime>=$squerystarttime && $currenttime<=$squeryendtime) ||($squeryendtime<$currenttime) ) {
            $sql = $sql . "select '$i:00-$next:00' as date, count(*) as number from (
                  select  ul.user_id From user_logs as ul
                  left join users as u on ul.user_id=u.id
                  where
                  (
                  (ul.created_at>='$query $i:00:00' and  ul.created_at<='$query $next:00:00')
                  or
                  (ul.logout_at>='$query $i:00:00' and  ul.logout_at<='$query $next:00:00')
                  or
                  (ul.created_at<='$query $next:00:00' and ul.logout_at is null)
                  )  $condition
                      group by ul.user_id
                ) as tbl";
          }
          else{
            $sql=$sql."select '$i:00-$next:00' as date,0 as number";
          }
        }
      }
      if($i<22) {
        $sql=$sql.' union all ';
      }
    }
    $result=\DB::connection()->select($sql);
    return $result;
  }
  //获取主房间编号
  public function getmasterroomid($area_id){
   return Room::where('area_id',$area_id)->where('main','1')->first();
  }
}
