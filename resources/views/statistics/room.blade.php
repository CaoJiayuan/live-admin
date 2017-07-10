@extends('layouts.table')
@section('table:header')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-8">
            <h2>数据统计</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="/">首页</a>
                </li>
                <li class="active"><strong>房间统计</strong></li>
            </ol>
        </div>
    </div>
@endsection
@section('table:body')
    <div class="ibox-title clearfix">
        <div class="col-md-12">
            <div class="row form-horizontal">
                <div class="col-md-12">
                    @include('components.roomstat',$condition)
                </div>
            </div>
        </div>
    </div>
    <div class="ibox-content">
        <table class="table table-bordered dataTable">
            <thead>
            <tr>
                <td>房间名称</td>
                <td>团队总数</td>
                <td>业务员数</td>
                <td>用户数</td>
                <td>房间在线用户数</td>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $item)
                <tr>
                    <td>{{$item->title}}</td>
                    <td>{{isset($item->groupnumber)?$item->groupnumber:'0'}}个</td>
                    <td>{{isset($item->businessnumber)?$item->businessnumber:'0'}}个</td>
                    <td>{{isset($item->usernumber)?$item->usernumber:"0"}}个</td>
                    <td>{{isset($item->onlinenumber)?$item->onlinenumber:"0"}}个</td>
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

    <div class="modal fade" id="data-save" tabindex="-1" role="dialog" aria-labelledby="data-title">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header ibox-title">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="data-title"></h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" data-action="/room/areas/create" id="data-form">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" id="area-id" value="0">
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="area-name">名称</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="area-name" name="name" autocomplete="off" value=""/>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" id="data-save-btn">保存</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        $(function () {
            $(".pagination").append("<li class='disabled' style='cursor:default'> <a class='disabled' style='cursor:default' href='javascript:void(0)'>总条数:{{$data->total()}}</a> </li>")

            $("#btnexport").click(function(){
                location.href='/statistics/excelrooms/?roomid='+$("#hiddenroomid").val();
                return false;
            })

            if($("#hiddenroomid").val()!=''){
                $("#selectroom").val($("#hiddenroomid").val())
            }
        })
    </script>
@endsection