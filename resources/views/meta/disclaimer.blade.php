@extends('layouts.table')
@section('css')

@endsection
@section('table:header')
  <div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
      <h2>基本信息管理</h2>
      <ol class="breadcrumb">
        <li>
          <a href="/">首页</a>
        </li>
        <li class="active"><strong>免责声明</strong></li>
      </ol>
    </div>
    <div class="col-lg-4">
      <div class="title-action">
        <button class="button btn btn-info" type="submit" form="about-form">保存</button>
        </div>
    </div>
  </div>
@endsection
@section('table:body')
  <div class="ibox-title clearfix">
    <h3>免责声明</h3>
  </div>
  <div class="ibox-content tabs-container">
    @if($errors && $errors->first())
      <div class="alert alert-danger">
        {{ $errors->first() }}
      </div>
    @endif
    <form action="{{ url()->current() }}" method="post" id="about-form">
      {{ csrf_field() }}
      <!-- 加载编辑器的容器 -->
      <script id="ue-container" name="content" type="text/plain">
        {!! $content !!}
      </script>
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