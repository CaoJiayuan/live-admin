@extends('layouts.table')

@section('table:header')
  <div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
      <h2>房间管理</h2>
      <ol class="breadcrumb">
        <li>
          <a href="/">首页</a>
        </li>
        <li class="active"><strong>公告列表</strong></li>
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
                  class="fa fa-plus"></i>&nbsp; 添加公告</a>
          </span>
      </div>
    </div>
  </div>
  <div class="ibox-content">
    <table class="table table-bordered dataTable">
      <thead>
      <tr>
        <td class="sorting" data-column="id">序号</td>
        <td>内容</td>
        <td class="sorting" data-column="created_at">创建时间</td>
        <td class="sorting" data-column="enable">状态</td>
        <td>操作</td>
      </tr>
      </thead>
      <tbody>
      @foreach($data as $item)
        <tr>
          <td>{{ $item->id }}</td>
          <td>{{ $item->content }}</td>
          <td>{{ $item->created_at }}</td>
          <td>{{ $item->enable ? '显示' : '隐藏' }}</td>
          <td>
            <button data-url="/room/notices/{{ $item->id }}/status"  class="btn btn-xs btn-info notice-status" >{{ !$item->enable ? '显示' : '隐藏' }}</button>
            <button class="btn btn-xs btn-info data-edit" data-id="{{ $item->id }}" data-name="{{ $item->content }}"
                    data-toggle="modal" data-target="#data-save">修改
            </button>
            <button class="btn btn-xs btn-danger del-notice" data-url="/room/notices/{{ $item->id }}">删除</button>
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
          <form class="form-horizontal" data-action="/room/notices/create" id="data-form">
            {{ csrf_field() }}
            <input type="hidden" name="id" id="area-id" value="0">
            <div class="form-group">
              <label class="col-sm-2 control-label" for="area-name">内容</label>
              <div class="col-md-8">
                <textarea class="form-control" id="area-name" name="content" autocomplete="off"></textarea>
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
    $(function(){
      $(".pagination").append("<li class='disabled' style='cursor:default'> <a class='disabled' style='cursor:default' href='javascript:void(0)'>总条数:{{$data->total()}}</a> </li>")

    })
    var roomId = {{$roomId}};
    $('#data-save-btn').click(function () {
      postForm('#data-form', function () {
        socket.emit('command:notice', {
          roomId : roomId
        });
        location.reload()
      })
    });
    $('.data-edit').click(function () {
      var self = $(this);
      var id   = self.data('id'),
          name = self.data('name');
      $('#area-id').attr('value', id);
      $('#area-name').html( name);
    });

    $('.notice-status').click(function () {
      var url =  $(this).data('url');
      $.get(url, function () {
        socket.emit('command:notice', {
          roomId : roomId
        });
        location.reload();
      })
    });
    $('.del-notice').click(function () {
      var url =  $(this).data('url');

      var opts = {
        title             : '确认刪除?',
        text              : '你将无法恢复所刪除数据!',
        type              : 'warning',
        showCancelButton  : true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText : '是,确定删除!',
        cancelButtonText  : '不,取消删除',
        closeOnConfirm    : false,
        closeOnCancel     : false
      };

      sweetAlert(opts,
          function (isConfirm) {
            if (isConfirm) {
              axios.delete(url).then(response => {
                sweetAlert("成功", "数据删除成功", "success");
                $(".confirm").click(function () {
                  location.reload();
                });
                socket.emit('command:notice', {
                  roomId : roomId
                });
              }).catch(error => {
                toastrNotification('error', error.response.data.message);
              });
            } else {
              sweetAlert("取消", "数据沒有刪除!", "error");
            }
          });
    })
  </script>
@endsection