@extends('layouts.table')
@section('table:header')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-8">
            <h2>数据统计</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="/">首页</a>
                </li>
                <li class="active"><strong>区域统计</strong></li>
            </ol>
        </div>
    </div>
@endsection
@section('table:body')
    <div class="ibox-title clearfix">
        <div class="col-md-12">
            <div class="row form-horizontal">
                <div class="col-md-12">
                    @include('components.areastat',$condition)
                </div>
            </div>
        </div>
    </div>
    <div class="ibox-content">
        <table class="table table-bordered dataTable">
            <thead>
            <tr>
                <td>区域名称</td>
                <td>房间总数</td>
                <td>团队总数</td>
                <td>业务员数</td>
                <td>用户数</td>
                <td>当前在线用户数</td>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $item)
                <tr>
                    <td>{{$item->name}}</td>
                    <td>{{isset($item->roomnumber)?$item->roomnumber:'0'}}个</td>
                    <td>{{isset($item->groupnumber)?$item->groupnumber:'0'}}个</td>
                    <td>{{isset($item->businessnumber)?$item->businessnumber:'0'}}个</td>
                    <td>{{isset($item->usernumber)?$item->usernumber:'0'}}个</td>
                    <td>{{isset($item->onlinenumber)?$item->onlinenumber:'0'}}个</td>
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
        {{ $data->links() }}
    </div>
@endsection

@section('js')
<script type="text/javascript">
  $(function(){

      $(".pagination").append("<li class='disabled' style='cursor:default'> <a class='disabled' style='cursor:default' href='javascript:void(0)'>总条数:{{$data->total()}}</a> </li>")

        $("#btnexport").click(function(){
           location.href="/statistics/excelarea?areaid="+$("#hiddenareaid").val();
            return false;
        })
  })
</script>
@endsection