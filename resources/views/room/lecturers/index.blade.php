@extends('layouts.table')

@section('table:header')
  <div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
      <h2>讲师管理</h2>
      <ol class="breadcrumb">
        <li>
          <a href="/">首页</a>
        </li>
        <li class="active"><strong>讲师列表</strong></li>
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
                  class="fa fa-plus"></i>&nbsp; 添加讲师</a>
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
        <td class="sorting" data-column="credits">积分</td>
        <td>操作</td>
      </tr>
      </thead>
      <tbody>
      @foreach($data as $item)
        <tr>
          <td>{{ $item->id }}</td>
          <td>{{ $item->name }}</td>
          <td>{{ $item->credits }}</td>
          <td>
            <button class="btn btn-xs btn-info data-edit" data-id="{{ $item->id }}" data-name="{{ $item->name }}"
                    data-toggle="modal" data-target="#data-save">修改
            </button>
            <button class="btn btn-xs btn-danger delete" data-url="/room/lecturers/{{ $item->id }}">删除</button>
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
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header ibox-title">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                aria-hidden="true">&times;</span></button>
          <h4 class="modal-title text-center" id="data-title"></h4>
        </div>
        <div class="modal-body">
          <form class="form-horizontal" data-action="/room/lecturers/create" id="data-form">
            {{ csrf_field() }}
            <input type="hidden" name="id" id="area-id" value="0">
            <div class="form-group">
              <label class="col-sm-2 control-label" for="area-name">名称</label>
              <div class="col-md-8">
                <input type="text" class="form-control" id="area-name" name="name" autocomplete="off" value=""/>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="area-desc">描述</label>
              <div class="col-md-8">
                <script id="ue-container" name="desc" type="text/plain">
                </script>
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
      var ue = UE.getEditor('ue-container', {
        toolbars: [
          ['source', 'undo', 'redo'],
          ['bold', 'italic', 'underline', 'fontborder', 'strikethrough',
           'superscript', 'subscript', 'removeformat', 'formatmatch',
           'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor',
           'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc']
        ],
        initialFrameHeight: 400
      });
      $('#data-save-btn').click(function () {
        postForm('#data-form', function () {
          location.reload()
        })
      });
      $('.data-edit').click(function () {
        var self = $(this);
        var id   = self.data('id'),
            name = self.data('name');
        $('#area-id').attr('value', id);
        $('#area-name').attr('value', name);
        $.get('/room/lecturers/' + id, function (data) {
          ue.setContent(data.desc)
        })
      });
      $('.add-btn').click(function () {
        ue.setContent('')
      });
      $(".pagination").append("<li class='disabled' style='cursor:default'> <a class='disabled' style='cursor:default' href='javascript:void(0)'>总条数:{{$data->total()}}</a> </li>")
    });


  </script>
@endsection