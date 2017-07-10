@extends('layouts.table')

@section('table:header')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-8">
            <h2>用户管理</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="/">首页</a>
                </li>
                <li class="active"><strong>机器人列表</strong></li>
            </ol>
        </div>
    </div>
@endsection
@section('table:body')
    <div class="ibox-title clearfix">
        <div class="col-md-12">
            <div class="row form-horizontal">
                <div class="col-md-6">
                    @include('components.search')
                </div>
                @ican('users.robots.add')
                <span class="input-group-btn">
           <a type="button" class="btn btn-info add-btn" data-toggle="modal" data-target="#add-robots" id="addRobots"><i class="fa fa-plus"></i>&nbsp; 添加机器人</a>
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
                <td>名称</td>
                <td>所属业务员</td>
                <td>等级</td>
                <td>上线规则</td>
                @ican('users.robots.edit')
                <td>操作</td>
                @endican
            </tr>
            </thead>
            <tbody>
            @foreach($data as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->aname }}</td>
                    <td>
                        @foreach(config('level') as $k=>$v)
                            @if($item->level == $k )
                                {{ $v }}
                            @endif
                        @endforeach
                    </td>
                    <td>主人上线就上线</td>
                    @ican('users.robots.edit')
                    <td>
                        <button class="btn btn-xs btn-info data-edit" data-toggle="modal" data-target="#add-robots" id="addRobots" data-id="{{ $item->id }}">修改</button>
                        <button class="btn btn-xs btn-danger delete" data-url="/users/robots/{{ $item->id }}">删除</button>
                    </td>
                    @endican
                </tr>
            @endforeach
            </tbody>
        </table>
        @include('robots.create-dialog')
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
        $(function(){
            $(".pagination").append("<li class='disabled' style='cursor:default'> <a class='disabled' style='cursor:default' href='javascript:void(0)'>总条数:{{$data->total()}}</a> </li>")
        })
      function getAgents(agentId=null) {
        var groupId = $('input[name=group_id]').val();
        $.get('/api/filter/'+groupId+'/agents',function(data){
          var html = '';
          $(data).each(function(index,element){
            html += '<option value='+element.id+'>'+element.name+'</option>';
          });
          $('select[name=agent_id]').html(html);
          $('#selectAgent').removeAttr('hidden');
        });
      }
      function showModal(agentId=null) {
        $.get('/users/robots/create', function (data) {
          $('input[name=area_id]').attr('value',data.user.area_id);
          $('input[name=room_id]').attr('value',data.user.room_id);
          $('input[name=group_id]').attr('value',data.user.group_id);
          switch (data.role) {
            case 'group_admin':
              getAgents(agentId );
              break;
            case 'agent_admin':
              $('select[name=agent_id]').html('<option value='+data.user.id+'></option>');
              break;
            default:
              break;
          }
        });
      }
      $(function () {
        $('#addRobots').click(function () {
          showModal();
        });
        $('#data-save-btn').click(function () {
          postForm('#data-form', function () {
            location.reload();
          });
        });
        $('.data-edit').click(function () {
          var id = $(this).data('id');
          $.get('/users/robots/' + id + '/edit', function (data) {
            showModal(data.agent_id);
            $('input[name=id]').attr('value',data.id);
            $('input[name=name]').attr('value',data.name);
            $('select[name=level]').val(data.level);
          });
        });
      });
    </script>
@endsection