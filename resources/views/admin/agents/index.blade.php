@extends('layouts.table')
@section('table:header')
  <div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
      <h2>管理员管理</h2>
      <ol class="breadcrumb">
        <li>
          <a href="/">首页</a>
        </li>
        <li class="active"><strong>业务员列表</strong></li>
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
        <span class="input-group-btn">
           <a type="button" data-toggle="modal" data-target="#data-save" class="btn btn-default add-btn"><i class="fa fa-plus"></i>&nbsp; 添加业务员</a>
          </span>
      </div>
    </div>
  </div>
  <div class="ibox-content">
    <table class="table table-bordered dataTable">
      <thead>
      <tr>
        <td class="sorting" data-column="id">编号</td>
        <td>姓名</td>
        <td>帐号</td>
        <td>电话</td>
        <td>ip</td>
        <td>状态</td>
        <td class="sorting" data-column="last_login">最后登录时间</td>
        <td class="sorting" data-column="enable">启用状态</td>
        <td>操作</td>
      </tr>
      </thead>
      <tbody>
      @foreach($data as $item)
        <tr>
          <td>{{ $item->id }}</td>
          <td>{{ $item->name }}</td>
          <td>{{ $item->username }}</td>
          <td>{{ $item->mobile }}</td>
          <td>{{ $item->last_ip ?: '--'}}</td>
          <td>{{ $item->online == 1 ? '在线' : '离线' }}</td>
          <td>{{ $item->last_login ?: '未登录' }}</td>
          <td>{{ !$item->enable ? '禁用' : '启用' }}</td>
          <td>
            <a type="button" data-id="{{ $item->id }}" data-toggle="modal" data-target="#data-save" class="btn btn-xs btn-info data-edit">修改
            </a>
            <a class="btn btn-xs btn-info" href="/admin/agents/{{ $item->id }}/status">{{ $item->enable ? '禁用' : '启用' }}</a>
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
    @include('admin.agents.data-dialog')
  </div>
@endsection

@section('js')
  <script>
    $(function(){
      $(".pagination").append("<li class='disabled' style='cursor:default'> <a class='disabled' style='cursor:default' href='javascript:void(0)'>总条数:{{$data->total()}}</a> </li>")

    })
    $('#data-save-btn').click(function () {
      postForm('#data-form', function () {
        location.reload()
      })
    });
    $('.data-edit').click(function () {
      var self = $(this);
      var id = self.data('id');
      $.get('/admin/agents/'+id+'/edit',function (data) {
        var html = '';
        console.log(data);
        $('#data-form').data('action','/admin/agents/'+data.user.id+'/edit');
        $(data.groups).each(function(index,element){
          if(element.id == data.user.area_id)
          {
            html += '<option value='+element.id+' selected>'+element.name+'</option>';
          }else{
            html += '<option value='+element.id+'>'+element.name+'</option>';
          }
        });
        $('select[name=group_id]').html(html);
        $('input[name=name]').attr('value',data.user.name);
        $('input[name=mobile]').attr('value',data.user.mobile);
        $('input[name=gender][value='+data.user.gender+']').attr('checked',true);
        $('input[name=gender][value='+data.user.gender+']').parent().addClass('checked');
        $('input[name=id]').attr('value',id);
      });
    });
    $('.add-btn').click(function(){
      $.get('/admin/agents/create',function(data){
        var html = '';
        $(data).each(function(index,element){
          html += '<option value='+element.id+'>'+element.name+'</option>';
        });
        $('select[name=group_id]').html(html);
      });
    })
  </script>
@endsection