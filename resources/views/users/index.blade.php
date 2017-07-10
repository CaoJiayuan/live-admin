@extends('layouts.table')

@section('table:header')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-8">
            <h2>用户管理</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="/">首页</a>
                </li>
                <li class="active"><strong>用户列表</strong></li>
            </ol>
        </div>
    </div>
@endsection

@section('table:body')
    <div class="ibox-title clearfix">
        <div class="col-md-12">
            <div class="row form-horizontal">
                <div class="col-md-10">
                    @include('components.users')
                </div>
                @ican('users.add')
                <span class="input-group-btn">
           <a type="button" class="btn btn-info add-btn" data-toggle="modal" data-target="#add-user" id="addUser"><i class="fa fa-plus"></i>&nbsp; 添加用户</a>
        </span>
                @endican
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
                <td>qq</td>
                <td>推荐人</td>
                <td>ip</td>
                <td>状态</td>
                <td class="sorting" data-column="last_login">最后登录时间</td>
                @ican('users.add')
                <td>操作</td>
                @endican
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
                    <td>{{ $item->qq }}</td>
                    <td>{{ $item->inviter['username'] ? $item->inviter['username'] : '--' }}</td>
                    <td>{{ $item->last_ip }}</td>
                    <td>{{ $item->online == 1 ? '在线' : '离线' }}</td>
                    <td>{{ $item->last_login ?: '未登录' }}</td>
                    @ican('users.add')
                    <td>
                        <button class="btn btn-xs btn-info data-edit" data-toggle="modal" data-target="#add-user" id="addUser" data-id="{{ $item->id }}">修改</button>
                        @if($item->last_ip)
                            <button class="btn btn-xs btn-danger not-delete"
                                    data-message="{{ !$item->ipBan ? '确认封IP？' : '确认启用IP？' }}"
                                    data-url="/users/{{ $item->id }}/banIp"
                                    data-id="{{ $item->id }}"  data-ip="{{ $item->last_ip }}">
                                {{ $item->ipBan ? '启用IP' : '封IP' }}</button>
                        @else
                            <button class="btn btn-xs btn-danger disabled">封IP</button>
                        @endif

                        <button class="btn btn-xs btn-danger not-delete"
                                data-message="{{ $item->status ? '确认禁言？' : '取消禁言？' }}"
                                data-url="/users/{{ $item->id }}/gag"
                                data-id="{{ $item->id }}">
                            {{ $item->status ? '禁言' : '取消禁言' }}</button>
                        <button class="btn btn-xs btn-danger not-delete"
                                data-message="{{ $item->enable ? '确认禁用？' : '确认启用？' }}"
                                data-url="/users/{{ $item->id }}/disable"
                                data-id="{{ $item->id }}">
                            {{ $item->enable ? '禁用' : '启用' }}</button>
                        <button class="btn btn-xs btn-danger delete" data-url="/users/{{ $item->id }}">删除</button>
                    </td>
                    @endican
                </tr>
            @endforeach
            </tbody>
        </table>
        @include('users.create-dialog')
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
      function getGroups(groupId=null, agentId=null) {
        var roomId = $('select[name=room_id]').val();
        $.get('/api/filter/' + roomId + '/groups', function (data) {
          var html = '';
          $(data).each(function (index, element) {
            if (groupId != null && groupId == element.id) {
              html += '<option value="' + element.id + '"selected="selected">' + element.name + '</option>';
            } else {
              html += '<option value=' + element.id + '>' + element.name + '</option>';
            }
          });
          $('select[name=group_id]').html(html);
          $('#selectGroup').removeAttr('hidden');
          getAgents(agentId);
        });
      }
      function getAgents(agentId=null) {
        var areaId = $('select[name=group_id]').val();
        $.get('/api/filter/' + areaId + '/agents', function (data) {
          var html = '';
          $(data).each(function (index, element) {
            if (agentId != null && agentId == element.id) {
              html += '<option value="' + element.id + '"selected="selected">' + element.name + '</option>';
            } else {
              html += '<option value=' + element.id + '>' + element.name + '</option>';
            }
          });
          $('select[name=agent_id]').html(html);
          $('#selectAgent').removeAttr('hidden');
        });
      }

      function showModal(groupId=null, agentId=null) {
        $.get('/users/create', function (data) {
          $('select[name=area_id]').html('<option value=' + data.user.area_id + '></option>');
          $('select[name=room_id]').html('<option value=' + data.user.room_id + '></option>');
          switch (data.role) {
            case 'room_admin':
              getGroups(groupId, agentId);
              break;
            case 'group_admin':
              $('select[name=group_id]').html('<option value=' + data.user.group_id + '></option>');
              getAgents(agentId);
              break;
            case 'agent_admin':
              $('select[name=group_id]').html('<option value=' + data.user.group_id + '></option>');
              $('select[name=agent_id]').html('<option value=' + data.user.id + '></option>');
              break;
            default:
              break;
          }
        });
      }
      $(function () {
          $(".pagination").append("<li class='disabled' style='cursor:default'> <a class='disabled' style='cursor:default' href='javascript:void(0)'>总条数:{{$data->total()}}</a> </li>")

          $('#addUser').click(function () {
            showModal();
            $('#setUserName,#setUserNameIn').hide();
            $('input[name=username]').attr('value', '123456');

          });
        $('select[name=group_id]').change(function () {
          getAgents();
        });
        $('#data-save-btn').click(function () {
          postForm('#data-form', function () {
            location.reload();
          });
        });
        $('.data-edit').click(function () {
          var id = $(this).data('id');
          $('#setUserName,#setUserNameIn').show();
          $.get('/users/' + id + '/edit', function (data) {
            $('input[name=id]').attr('value',data.id);
            $('input[name=name]').attr('value',data.name);
            $('input[name=nickname]').attr('value',data.nickname);
            $('input[name=username]').attr('value',data.username);
            $('input[name=mobile]').attr('value',data.mobile);
            $('input[name=gender]').parent().removeClass('checked');
            $('input[name=gender][value='+data.gender+']').attr('checked',true);
            $('input[name=gender][value='+data.gender+']').parent().addClass('checked');
            $('input[name=qq]').attr('value',data.qq);
            if(data.inviter!=null) {
                $('input[name=inviter]').attr('value', data.inviter.username);
            }
            $('select[name=level]').attr('value',data.level);
            showModal(data.group_id, data.agent_id);
          });
        });
        $('.not-delete').click(function () {
          var opts = {
            title: $(this).data('message'),
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: '确定操作',
            cancelButtonText: '取消操作',
            closeOnConfirm: false,
            closeOnCancel: false
          };
          var url = $(this).data('url'),
              userId = $(this).data('id'),
              ip = $(this).data('ip');
          sweetAlert(opts, function (isConfirm) {
            if (isConfirm) {
              $.get(url, function () {
                sweetAlert("成功", "操作成功", "success");
                $(".confirm").click(function () {
                  location.reload();
                });
                socket.emit('command:reload', {
                  ip : ip,
                  id : userId,
                });
              });
            } else {
              sweetAlert("取消", "取消操作!", "error");
            }
          });
        });

        //筛选操作
        $('select[name=area]').change(function(){
          if($(this).val()=='')
          {
            $('select[name=room]').html('<option value="">--请选择房间--</option>');
            $('select[name=group]').html('<option value="">--请选择团队--</option>');
            $('select[name=agent]').html('<option value="">--请选择业务员--</option>');
          }else{
            $.get('/api/filter/'+$(this).val()+'/rooms/0',function (data) {
              var html = '<option value="">--请选择房间--</option>';
              $(data).each(function(index,element){
                html += '<option value="'+element.id+'">'+element.title+'</option>';
              });
              $('select[name=room]').html(html);
            });
          }
        });
        $('select[name=room]').change(function(){
          if($(this).val()=='')
          {
            $('select[name=group]').html('<option value="">--请选择团队--</option>');
            $('select[name=agent]').html('<option value="">--请选择业务员--</option>');
          }else{
            $.get('/api/filter/'+$(this).val()+'/groups',function (data) {
              var html = '<option value="">--请选择团队--</option>';
              $(data).each(function(index,element){
                html += '<option value="'+element.id+'">'+element.name+'</option>';
              });
              $('select[name=group]').html(html);
            });
          }
        });
        $('select[name=group]').change(function(){
          if($(this).val()=='')
          {
            $('select[name=agent]').html('<option value="">--请选择业务员--</option>');
          }else{
            $.get('/api/filter/'+$(this).val()+'/agents',function (data) {
              var html = '<option value="">--请选择业务员--</option>';
              $(data).each(function(index,element){
                html += '<option value="'+element.id+'">'+element.name+'</option>';
              });
              $('select[name=agent]').html(html);
            });
          }
        });
      });

    </script>
@endsection
