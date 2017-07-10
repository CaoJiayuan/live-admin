@extends('layouts.table')
@section('css')

@endsection
@section('table:header')
  <div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
      <h2>积分管理</h2>
      <ol class="breadcrumb">
        <li>
          <a href="/">首页</a>
        </li>
        <li class="active"><strong>其他设置</strong></li>
      </ol>
    </div>
    <?php
    $permission = false;
    if ($room) {
      if ($room->main || $room->permission) {
        $permission = true;
      }
    }
    ?>
    @if($permission)
      <div class="col-lg-4">
        <div class="title-action">
          <button class="button btn btn-info" type="submit" form="data-form">保存</button>
        </div>
      </div>
    @endif
  </div>
@endsection
@section('table:body')
  <div class="ibox-title clearfix">
    <h3>其他设置</h3>
  </div>
  <div class="ibox-content tabs-container">
    @if($errors && $errors->first())
      <div class="alert alert-danger">
        {{ $errors->first() }}
      </div>
    @endif
    <form action="{{ url()->current() }}" method="post" id="data-form" class="form-horizontal" role="form">
      <div class="form-group">
        <label class="col-sm-2 control-label" for="area-sing_credit">签到奖励积分</label>
        <div class="col-md-5">
          <input type="number" class="form-control" id="area-sing_credit" name="sing_credit" autocomplete="off"
                 value="{{ $sing_credit }}"/>
        </div>
      </div>
      <div class="hr-line-dashed"></div>
      <div class="form-group">
        <label class="col-sm-2 control-label" for="area-sing_credit">推荐人获取积分</label>
        <div class="col-md-5">
          <input type="number" class="form-control" id="area-sing_credit" name="invite_credit" autocomplete="off"
                 value="{{ $invite_credit }}"/>
        </div>
      </div>
    </form>
  </div>
@endsection
@section('js')

  <script type="text/javascript">
    var ue = UE.getEditor('ue-container', {
      toolbars          : [
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