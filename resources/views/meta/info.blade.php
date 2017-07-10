@extends('layouts.table')

@section('table:header')
  <div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
      <h2>基本信息管理</h2>
      <ol class="breadcrumb">
        <li>
          <a href="/">首页</a>
        </li>
        <li class="active"><strong>网站信息管理</strong></li>
      </ol>
    </div>
    <div class="col-lg-4">
      <div class="title-action">
        <button class="button btn btn-info" type="submit" form="info-form">保存</button>
      </div>
    </div>
  </div>
@endsection
@section('table:body')
  <div class="ibox-title clearfix">
    <h3>网站信息管理</h3>
  </div>
  <div class="ibox-content tabs-container">
    @if($errors && $errors->first())
      <div class="alert alert-danger">
        {{ $errors->first() }}
      </div>
    @endif
    <form action="{{ url()->current() }}" class="form-horizontal" method="post" id="info-form">
    {{ csrf_field() }}
      <div class="form-group">
        <label class="col-sm-2 control-label" for="info-title">网站标题</label>
        <div class="col-md-5">
          <input class="form-control" id="info-title" name="title"
                 value="{{ $title }}"/>
        </div>
      </div>
      <div class="hr-line-dashed"></div>
      <div class="form-group">
        <label class="col-sm-2 control-label" for="info-keywords">网站关键字</label>
        <div class="col-md-5">
          <input class="form-control" id="info-keywords" name="keywords"
                 value="{{ $keywords }}"/>
        </div>
      </div>
    </form>
  </div>
@endsection