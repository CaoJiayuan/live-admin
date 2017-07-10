@extends('layouts.table')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/jQueryFileUpload/jquery.fileupload.css') }}">
  <link rel="stylesheet" href="{{ asset('css/jQueryFileUpload/jquery.fileupload-ui.css') }}">
  <link href="{{ asset('css/datapicker/datepicker3.css') }}" rel="stylesheet">
@endsection
@section('table:header')
  <div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
      <h2>新闻资讯管理</h2>
      <ol class="breadcrumb">
        <li>
          <a href="/">首页</a>
        </li>
        <li>
          <a href="/information/scoops">独家专栏</a>
        </li>
        <li class="active"><strong>{{ $item ? '修改' : '添加' }}独家专栏</strong></li>
      </ol>
    </div>
    <div class="col-lg-4">
      <div class="title-action">
        <button class="button btn btn-info" type="submit" form="data-form">保存</button>
      </div>
    </div>
  </div>
@endsection
@section('table:body')
  <div class="ibox-title clearfix">
    <h3>{{ $item ? '修改' : '添加' }}独家专栏</h3>
  </div>
  <div class="ibox-content">
    @if($errors && $errors->first())
      <div class="alert alert-danger">
        {{ $errors->first() }}
      </div>
    @endif
    <form action="{{ url()->current() }}" class="form-horizontal" method="post" id="data-form">
        {{ csrf_field() }}
        <div class="form-group">
          <label class="col-sm-2 control-label" for="scoop-title">标题</label>
          <div class="col-md-5">
            <input class="form-control" id="scoop-title" name="title"
                   value="{{ get_form_param('title', $item) }}"/>
          </div>
        </div>
        <div class="hr-line-dashed"></div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="info-summary">摘要</label>
          <div class="col-md-5">
            <textarea class="form-control" id="info-summary" name="summary" style="resize: vertical">{{ get_form_param('summary', $item) }}</textarea>
          </div>
        </div>
      <div class="hr-line-dashed"></div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="info-content">内容</label>
          <div class="col-md-5">
            <textarea class="form-control" id="info-content" name="summary" style="resize: vertical">{{ get_form_param('content', $item) }}</textarea>
          </div>
        </div>
    </form>
  </div>
@endsection

@section('js')

  <script type="text/javascript">
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
  </script>
@endsection