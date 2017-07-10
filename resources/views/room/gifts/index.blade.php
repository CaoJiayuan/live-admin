@extends('layouts.table')

@section('table:header')
  <div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
      <h2>房间管理</h2>
      <ol class="breadcrumb">
        <li>
          <a href="/">首页</a>
        </li>
        <li class="active"><strong>礼物列表</strong></li>
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
                  class="fa fa-plus"></i>&nbsp; 添加礼物</a>
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
        <td class="sorting" data-column="gift_category_id">类型</td>
        <td class="sorting" data-column="credits">消耗积分</td>
        <td>图片</td>
        <td>操作</td>
      </tr>
      </thead>
      <tbody>
      @foreach($data as $item)
        <tr>
          <td>{{ $item->id }}</td>
          <td>{{ $item->name }}</td>
          <td>{{ $item->cate_name }}</td>
          <td>{{ $item->credits }}</td>
          <td><img src="{{ $item->img }}" class="img-responsive center-block" alt="" width="100"></td>
          <td>
            <button class="btn btn-xs btn-info data-edit" data-id="{{ $item->id }}" data-img="{{ $item->img }}"
                    data-credits="{{ $item->credits }}" data-name="{{ $item->name }}" data-cate="{{ $item->gift_category_id }}"
                    data-toggle="modal" data-target="#data-save">修改
            </button>
            <button class="btn btn-xs btn-danger delete" data-url="/room/gifts/{{ $item->id }}">删除</button>
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
          <form class="form-horizontal" data-action="/room/gifts/create" id="data-form">
            {{ csrf_field() }}
            <input type="hidden" name="id" id="area-id" value="0">
            <div class="form-group">
              <label class="col-sm-2 control-label" for="area-name">名称</label>
              <div class="col-md-8">
                <input type="text" class="form-control" id="area-name" name="name" autocomplete="off" value=""/>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="area-gift_category_id">类型</label>
              <div class="col-md-8">
                <select class="form-control" name="gift_category_id" id="area-gift_category_id">
                  @foreach($cates as $k => $cate)
                    <option value="{{ $cate['id'] }}">{{ $cate['name'] }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="area-img">图片</label>
              <div class="col-md-8 text-center">
                <img src="" alt="" class="img-responsive center-block" id="img-pre">
                <input type="file" style="display: none" id="img-up" accept="image/jpg,image/jpeg,image/png,image/gif">
                <label for="img-up" class="btn btn-default" style="margin-top: 5px">上传</label>
                <input type="hidden" class="form-control" id="area-img" name="img" autocomplete="off" value=""/>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="area-credits">消耗积分</label>
              <div class="col-md-8">
                <input type="number" class="form-control" id="area-credits" name="credits" autocomplete="off" value=""/>
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
    });
    $('#data-save-btn').click(function () {
      postForm('#data-form', function () {
        location.reload()
      })
    });
    $('.data-edit').click(function () {
      var self = $(this);
      var id   = self.data('id'),
          name = self.data('name'),
          img = self.data('img'),
          credits = self.data('credits'),
          cate = self.data('cate');
      $('#area-id').attr('value', id);
      $('#area-name').attr('value', name);
      $('#area-img').attr('value', img);
      $('#area-credits').attr('value', credits);
      $('#area-gift_category_id').val(cate);
      $('#img-pre').attr('src', img);
    });
    $('#img-up').change(function () {
      upload('#img-up', '/upload',' file', function (data) {
        $('#img-pre').attr('src', data.url);
        $('#area-img').val(data.url)
      })
    })
  </script>
@endsection