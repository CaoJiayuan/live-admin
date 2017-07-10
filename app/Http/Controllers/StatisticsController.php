<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\StatisticsRepository;
use App\Repository\AreaRepository;
use App\Repository\RoomRepository;
use App\Repository\GroupRepository;
use Carbon\Carbon;

class StatisticsController extends Controller
{
    public function login(AreaRepository $areares,RoomRepository $roomres,GroupRepository $groupres,StatisticsRepository $repository,Request $request)
    {
        $user= \Auth::user();
        $result=$this->getcondition($areares,$roomres,$groupres);
        $data = $repository->users($user,$request);
        return view('statistics.login', [
            'data' => $data,
            'condition'=>$result
        ]);
    }
    public function online(AreaRepository $areares,RoomRepository $roomres,GroupRepository $groupres,StatisticsRepository $repository,Request $request)
    {
        $user= \Auth::user();
        $rolename=$user->roles()->first()->name;
        return view('statistics.online', [
            'currentdate'=>date('Y-m-d', Carbon::now()->getTimestamp()),
            'rolename'=>$rolename
        ]);
    }
    public function history(AreaRepository $areares,RoomRepository $roomres,GroupRepository $groupres,StatisticsRepository $repository,Request $request)
    {
        $user= \Auth::user();
        $result=$this->getcondition($areares,$roomres,$groupres);
       // $data = $repository->gethistorytimerange($user,$request);
        //dd($data);

        $end= date('Y-m-d', Carbon::now()->getTimestamp());
        $begin= date('Y-m-d', Carbon::now()->addDay(-9)->getTimestamp());

        return view('statistics.history', [
           // 'data' => $data,
            'condition'=>$result,
            'begin'=>$begin,
            'end'=>$end
        ]);
    }
    public function area(AreaRepository $areares,RoomRepository $roomres,GroupRepository $groupres,StatisticsRepository $repository,Request $request)
    {
        $user= \Auth::user();
        $result=$this->getcondition($areares,$roomres,$groupres);
        $data = $repository->getareastat($request);
        return view('statistics.area', [
            'data' => $data,
            'condition'=>$result
        ]);
    }
    public function room(AreaRepository $areares,RoomRepository $roomres,GroupRepository $groupres,StatisticsRepository $repository,Request $request)
    {
        $user= \Auth::user();
        $result=$this->getcondition($areares,$roomres,$groupres);
        $data = $repository->getroomstat($user,$request);
        return view('statistics.room', [
            'data' => $data,
            'condition'=>$result
        ]);
    }
    public function group(AreaRepository $areares,RoomRepository $roomres,GroupRepository $groupres,StatisticsRepository $repository,Request $request)
    {
        $user= \Auth::user();
        $result=$this->getcondition($areares,$roomres,$groupres);
        $data = $repository->getgroupstat($user,$request);
        return view('statistics.group', [
            'data' => $data,
            'condition'=>$result
        ]);
    }
    public function groupjl(AreaRepository $areares,RoomRepository $roomres,GroupRepository $groupres,StatisticsRepository $repository,Request $request)
    {
        $user= \Auth::user();
        $result=$groupres->getGroupbusiness($user->group_id);//$this->getcondition($areares,$roomres,$groupres);
        $data = $repository->getgroupjlstat($user,$request);
        return view('statistics.groupjl', [
            'data' => $data,
            'condition'=>$result
        ]);
    }
    //获取条件筛选
    public function getcondition(
        AreaRepository $areares,RoomRepository $roomres,GroupRepository $groupres){
        $user= \Auth::user();
        $rolename=$user->roles()->first()->name;
        switch ($rolename)
        {
            case 'super_admin':
                //获取所有区域
                $arealist=  $areares->getAreaAll();
                return ['arealist'=>$arealist,'roomlist'=>null,'grouplist'=>null,'businessuser'=>null];
                break;
            case 'area_admin':
                //获取当前区域
                $arealist= $areares->getAreaById($user->area_id);
                //获取当前区域下面的房间
                $roomlist=$roomres->getRoomByAreaId($user->area_id);

                return ['arealist'=>$arealist,'roomlist'=>$roomlist,'grouplist'=>null,'businessuser'=>null];
                break;
            case 'room_admin':
                //获取当前区域
                $arealist= $areares->getAreaById($user->area_id);
                //获取所在房间
                $roomlist=$roomres->getRoomById($user->room_id);
                //获取团队全部名称
                //$grouplist=$groupres->getGroupByRid($user->room_id);//获取组成员
                $grouplist=$groupres->getGroupByroomid($user->room_id);
                return ['arealist'=>$arealist,'roomlist'=>$roomlist,'grouplist'=>$grouplist,'businessuser'=>null];
                break;
            case 'group_admin':
                //获取当前区域
                $arealist= $areares->getAreaById($user->area_id);
                //获取所在房间
                $roomlist=$roomres->getRoomById($user->room_id);
                //获取当前所在组
                $grouplist=$groupres->getGroupById($user->group_id);
                //获取当前组下面的所有业务员
                $businessuser=$groupres->getGroupbusiness($user->group_id);

                return ['arealist'=>$arealist,'roomlist'=>$roomlist,'grouplist'=>$grouplist,'businessuser'=>$businessuser];
                break;
            case 'agent_admin':
                //获取当前区域
                $arealist= $areares->getAreaById($user->area_id);
                //获取所在房间
                $roomlist=$roomres->getRoomById($user->room_id);
                //获取当前所在组
                $grouplist=$groupres->getGroupById($user->group_id);
                //获取当前业务员
                $businessuser=[$user];
                return ['arealist'=>$arealist,'roomlist'=>$roomlist,'grouplist'=>$grouplist,'businessuser'=>$businessuser];
                break;
            default:
                echo "perssion is not exists";
        }
    }
    //获取房间
    public function  getroom(RoomRepository $roomres,Request $request)
    {
        $rooms=$roomres->getRoomByAreaId($request->get('area_id'));
        return response()->json($rooms);
    }
    //获取所有的组
    public function getgroup(GroupRepository $groupres,Request $request)
    {
        $grouplist=$groupres->getGroupByroomid($request->get('room_id'));
        return response()->json($grouplist);
    }
    //获取用户业务员
    public function getbusiness(GroupRepository $groupres,Request $request)
    {
        $business=$groupres->getGroupbusiness($request->get('group_id'));//获取组成员
        return response()->json($business);
    }
    //获取在线图表数据信息
    public function getdatechart(StatisticsRepository $repository,Request $request){
        $user= \Auth::user();
        $rolename=$user->roles()->first()->name;
        //如果是区域管理员的话，就请求下面的方法
        if($rolename=='area_admin'){
            //获取总房间
            $masterroom= $repository->getmasterroomid($user->area_id);
            //查询当前图表所要的数据
            $data = $repository->getareadatetimestat($user,$request,$masterroom->id);
            return response()->json($data);
        }else{
            $data = $repository->getdatetimestat($user,$request);
            return response()->json($data);
        }
    }
    //获取主页数据信息
    public function gethomedata(StatisticsRepository $repository){
        $user= \Auth::user();
        $count=   $repository->gethomecountstat($user);
        //$chart=   $repository->getlasttimedatachart($user);//oldchart
        //$chart=$repository->homechartdata($user);

        $chart=$repository-> homechartnewdata($user);

        $data=['count'=>$count,'chart'=>$chart];
        return response()->json($data);
    }
    //获取历史数据信息
    public function gethistorytimerange(StatisticsRepository $repository,Request $request)
    {
        $user= \Auth::user();
       // $data = $repository->get
        $data = $repository->gethistorytimerange($user,$request);
        return response()->json($data);
    }
    //间隔时间获取数据信息
    public function  gethomecountdatainteval(StatisticsRepository $repository)
    {
        $user= \Auth::user();
        $count=   $repository->gethomecountstat($user);
        $data=['count'=>$count];
        return response()->json($data);
    }
}
