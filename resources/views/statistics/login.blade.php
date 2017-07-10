@extends('layouts.table')
@section('table:header')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-8">
            <h2>数据统计</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="/">首页</a>
                </li>
                <li class="active"><strong>今日登录</strong></li>
            </ol>
        </div>
    </div>
@endsection
@section('table:body')
    <div class="ibox-title clearfix">
        <div class="col-md-12">
            <div class="row form-horizontal">
                <div class="col-md-12">
                    @include('components.statistics',$condition)
                </div>
            </div>
        </div>
    </div>
    <div class="ibox-content">
        <table class="table table-bordered dataTable">
            <thead>
            <tr>
                <td>序号</td>
                <td>区域</td>
                <td>房间</td>
                <td>团队</td>
                <td>用户名</td>
                <td>昵称</td>
                <td>所属业务员</td>
                <td>登录时间</td>
                <td>IP地址</td>
            </tr>
            </thead>
            <tbody>
               @foreach($data as $item)
                <tr>
                    <td>{{$item->id}}</td>
                    <td>{{isset($item->aname)?$item->aname:'--'}}</td>
                    <td>{{isset($item->title)?$item->title:'--'}}</td>
                    <td>{{isset($item->gname)?$item->gname:'--'}}</td>
                    <td>{{$item->username}}</td>
                    <td>{{$item->nickname}}</td>
                    {{--<td>{{isset($item->agentname)?$item->agentname:"--"}}</td>--}}
                    <td>{{ $item->agent ? $item->agent_id == $item->id ? '--' : $item->agent->nickname : '--' }}</td>
                    <td>{{isset($item->last_login)?$item->last_login:'--'}}</td>
                    <td>{{isset($item->last_ip)?$item->last_ip:'--'}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @if($data->total()>=1 && $data->total()<=10)
            <ul class="pagination">
                <li class="disabled"><span>«</span></li>

                <li class="active"><span>1</span></li>

                <li class="disabled"><span>»</span></li>

            </ul>
        @endif
        {{ $data->links()}}
    </div>
@endsection

@section('js')
    <script src="/js/plugins/selectaction.js"></script>
    <script type="text/javascript">
            $(function(){
                $(".pagination").append("<li class='disabled' style='cursor:default'> <a class='disabled' style='cursor:default' href='javascript:void(0)'>总条数:{{$data->total()}}</a> </li>");
                $("#btnexport").click(function(){
                    location.href='/statistics/excellogin?areaid='+$("#hiddenareaid").val()+'&roomid='+$("#hiddenroomid").val()+"&groupid="+$("#hiddengroupid").val()+"&agentuserid="+$("#hiddenagentuserid").val();
                    return false;
                })
            })
    </script>
@endsection