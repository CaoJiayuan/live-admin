@extends('layouts.table')
@section('table:header')
  <div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
      <h2>管理员管理</h2>
      <ol class="breadcrumb">
        <li>
          <a href="/">首页</a>
        </li>
        <li>
          <a href="/admin/agents">业务员列表</a>
        </li>
        <li class="active"><strong>{{ $item ? '修改' : '添加' }}业务员</strong></li>
      </ol>
    </div>
    <div class="col-lg-4">
      <div class="title-action">
        <button class="button btn btn-info" type="submit" form="data-form">保存</button>
        <a href="/admin/agents" class="button btn btn-default">返回</a>
      </div>
    </div>
  </div>
@endsection
@section('table:body')
  <div class="ibox-title clearfix">
    <div class="col-md-12">
      <h3>{{ $item ? '修改' : '添加' }}业务员</h3>
    </div>
  </div>
  <div class="ibox-content">
    @if($errors && $errors->first())
      <div class="alert alert-danger">
        {{ $errors->first() }}
      </div>
    @endif
    <form action="{{ url()->current() }}" class="form-horizontal" id="data-form" method="post">
      {{ csrf_field() }}
      <input type="hidden" name="id" value="{{ array_get($item, 'id', 0)}}">
      <div class="form-group">
        <label class="col-sm-2 control-label" for="data-name">选择团队</label>
        <div class="col-md-5">
          <select class="form-control" id="data-name" name="group_id" autocomplete="off">
            @foreach($groups as $group)
              <option value="{{ $group->id }}"{{ get_form_param('group_id', $item) == $group->id ? 'selected' : '' }}>{{ $group->name }}</option>
            @endforeach

          </select>
        </div>
      </div>
      <div class="hr-line-dashed"></div>
      <div class="form-group">
        <label class="col-sm-2 control-label" for="data-name">姓名</label>
        <div class="col-md-5">
          <input type="text" class="form-control" id="data-name" name="name" autocomplete="off"
                 value="{{ get_form_param('name', $item) }}"/>
        </div>
      </div>
      <div class="hr-line-dashed"></div>
      <div class="form-group">
        <label class="col-sm-2 control-label" for="data-gender">性别</label>
        <div class="col-md-5">
          <input type="radio" id="data-gender" name="gender" class="i-checks" autocomplete="off" {{ get_form_param('gender', $item, 0) ? '': 'checked' }}
                 value="0"/><span>男</span>
          <input type="radio" id="data-gender" name="gender" class="i-checks" autocomplete="off" {{ get_form_param('gender', $item, 0) ? 'checked': '' }}
                 value="1"/><span>女</span>
        </div>
      </div>
      <div class="hr-line-dashed"></div>
      <div class="form-group">
        <label class="col-sm-2 control-label" for="data-mobile">电话(登陆帐号)</label>
        <div class="col-md-5">
          <input type="text" class="form-control" id="data-mobile" name="mobile" autocomplete="off"
                 value="{{ get_form_param('mobile', $item) }}"/>
          <small>默认密码为电话号码后六位</small>
        </div>
      </div>
    </form>
  </div>
@endsection

@section('js')
  <script>

  </script>
@endsection