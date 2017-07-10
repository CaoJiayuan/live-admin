@extends('layouts.table')

@section('table:header')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-8">
            <h2>用户管理</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="/">首页</a>
                </li>
                <li class="active"><strong>在线用户列表</strong></li>
            </ol>
        </div>
    </div>
@endsection
@section('table:body')
    <div class="ibox-title clearfix">
        <div class="col-md-12">
            <div class="row form-horizontal">
                        @include('components.usersonline')
            </div>
        </div>
    </div>
    <div class="ibox-content">
        <table class="table table-bordered dataTable">
            <thead>
            <tr>
                <td class="sorting" data-column="id">编号</td>
                <td>角色</td>
                <td>名称</td>
                <td>昵称</td>
                <td>手机号</td>
                <td>所在区域</td>
                <td>所在房间</td>
                <td>所在团队</td>
                <td>所属业务员</td>
                <td>ip</td>
                <td class="sorting" data-column="last_login">登录时间</td>
                <td>登录设备</td>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>
                        @if($role = $item->role->first())
                            {{ $role->display_name }}
                        @else
                            普通用户
                        @endif
                    </td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->nickname }}</td>
                    <td>{{ $item->mobile }}</td>
                    <td>{{ $item->aname }}</td>
                    <td>{{ $item->title }}</td>
                    <td>{{ $item->gname }}</td>
                    <td>{{ $item->agname }}</td>
                    <td>{{ $item->last_ip }}</td>
                    <td>{{ $item->last_login  }}</td>
                    <td>
                        @if($item->ua=="PC" || $item->ua=="pc")
                          电脑登录
                        @else
                          {{$item->ua}}登录
                        @endif
                    </td>
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
    <script>
      $(function () {
          $(".pagination").append("<li class='disabled' style='cursor:default'> <a class='disabled' style='cursor:default' href='javascript:void(0)'>总条数:{{$data->total()}}</a> </li>")

          $('select[name=area]').change(function () {
          if ($(this).val() == '') {
            $('select[name=room]').html('<option value="">--请选择房间--</option>');
            $('select[name=group]').html('<option value="">--请选择团队--</option>');
            $('select[name=agent]').html('<option value="">--请选择业务员--</option>');
          } else {
            $.get('/api/filter/' + $(this).val() + '/rooms/0', function (data) {
              var html = '<option value="">--请选择房间--</option>';
              $(data).each(function (index, element) {
                html += '<option value="' + element.id + '">' + element.title + '</option>';
              });
              $('select[name=room]').html(html);
            });
          }
        });
        $('select[name=room]').change(function () {
          if ($(this).val() == '') {
            $('select[name=group]').html('<option value="">--请选择团队--</option>');
            $('select[name=agent]').html('<option value="">--请选择业务员--</option>');
          } else {
            $.get('/api/filter/' + $(this).val() + '/groups', function (data) {
              var html = '<option value="">--请选择团队--</option>';
              $(data).each(function (index, element) {
                html += '<option value="' + element.id + '">' + element.name + '</option>';
              });
              $('select[name=group]').html(html);
            });
          }
        });
        $('select[name=group]').change(function () {
          if ($(this).val() == '') {
            $('select[name=agent]').html('<option value="">--请选择业务员--</option>');
          } else {
            $.get('/api/filter/' + $(this).val() + '/agents', function (data) {
              var html = '<option value="">--请选择业务员--</option>';
              $(data).each(function (index, element) {
                html += '<option value="' + element.id + '">' + element.name + '</option>';
              });
              $('select[name=agent]').html(html);
            });
          }
        });
      });
    </script>
@endsection

