@extends('layouts.table')

@section('table:header')
  <div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
      <h2>房间管理</h2>
      <ol class="breadcrumb">
        <li>
          <a href="/">首页</a>
        </li>
        <li class="active"><strong>子房间列表</strong></li>
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
            <a type="button" data-toggle="modal" data-target="#data-save" class="btn btn-info add-btn"><i
                  class="fa fa-plus"></i>添加房间</a>
        </span>
      </div>
    </div>
  </div>
  <div class="ibox-content">
    <table class="table table-bordered dataTable">
      <thead>
      <tr>
        <td class="sorting" data-column="id">序号</td>
        <td>名称</td>
        <td>分区</td>
        <td>人气</td>
        <td>人数上限</td>
        <td>管理员</td>
        <td>创建时间</td>
        <td>主房号</td>
        <td>备注</td>
        <td>操作</td>
      </tr>
      </thead>
      <tbody>
      @foreach($data as $item)
        <tr>
          <td>{{ $item->id }}</td>
          <td>{{ $item->title }}</td>
          <td>{{ $item->area->name ?: '--' }}</td>
          <td>{{ $item->people}}</td>
          <td>{{ $item->register_capacity ?: '未设置' }}</td>
          <td>{{ $item->admin ? $item->admin->name : '--' }}</td>
          <td>{{ $item->created_at }}</td>
          <td>{{ $item->main_id }}</td>
          <td>{{ $item->remark }}</td>
          <td>
            <button class="btn btn-xs btn-info data-edit" data-id="{{ $item->id }}" data-title="{{ $item->title }}" data-remark="{{ $item->remark }}"
                    data-area="{{ $item->area_id }}"
                    data-toggle="modal" data-target="#data-save">修改
            </button>
            <button class="btn btn-xs btn-info per-btn" data-url="/room/rooms/{{ $item->id }}/permission"
                    data-id="{{ $item->id }}">{{ $item->permission ? '取消' : '' }}放权
            </button>
            <button class="btn btn-xs btn-danger delete" data-url="/room/rooms/{{ $item->id }}">删除</button>
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
  <div class="modal fade" id="data-save" tabindex="-1" role="dialog" aria-labelledby="data-title">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header ibox-title">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                aria-hidden="true">&times;</span></button>
          <h4 class="modal-title text-center" id="data-title"></h4>
        </div>
        <div class="modal-body">
          <form class="form-horizontal" data-action="/room/rooms" id="data-form">
            {{ csrf_field() }}
            <input type="hidden" name="id" id="room-id" value="0">
            <div class="form-group">
              <label class="col-sm-2 control-label" for="room-name">名称</label>
              <div class="col-md-8">
                <input type="text" class="form-control" id="room-name" name="title" autocomplete="off" value=""/>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="area-filter">分区</label>
              <div class="col-md-8">
                <input type="hidden" name="area_id" value="{{ $area ? $area->id : '' }}">
                <p class="form-control-static">{{ $area ? $area->name : '' }}</p>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="area-remark">备注</label>
              <div class="col-md-8">
                <input type="text" class="form-control" name="remark" id="area-remark" autocomplete="off"  value="" >
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
  <script>
    $('#data-save-btn').click(function () {
      postForm('#data-form', function () {
        location.reload()
      })
    });
$(function(){

  $(".pagination").append("<li class='disabled' style='cursor:default'> <a class='disabled' style='cursor:default' href='javascript:void(0)'>总条数:{{$data->total()}}</a> </li>")


})
    $('.data-edit').click(function () {
      var self = $(this);
      var id   = self.data('id'),
          name = self.data('title'),
          remark = self.data('remark'),
          area = self.data('area');
      $('#room-id').attr('value', id);
      $('#room-name').attr('value', name);
      $('#area-remark').attr('value', remark);
      $('#area-filter').val(area);
    });
    $('.per-btn').click(function () {
      var url = $(this).data('url'),
          id  = $(this).data('id');
      $.get(url, function () {
        socket.emit('command:reload', {
          roomId : id
        });
        location.reload()
      })
    })
  </script>
@endsection