<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'Laravel') }}</title>
  <link href="/css/font-awesome.min.css" rel="stylesheet">
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link href="/css/toastr.min.css" rel="stylesheet">
  <link href="/css/animate.min.css" rel="stylesheet">
  <link href="/css/inspinia.css" rel="stylesheet">
  <link href="/css/metisMenu.min.css" rel="stylesheet">
  <link href="/css/iCheck.css" rel="stylesheet">
  <script>
    window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
  </script>
  @include('UEditor::head')
  @yield('css')
</head>
<body class="{{ session('nav.opened', true) ? '' : 'mini-navbar' }}">
<div id="wrapper">
  @include('layouts.nav')
  <div id="page-wrapper" class="gray-bg">
    <div class="row border-bottom">
      <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
          <a class="navbar-minimalize minimalize-styl-2 btn btn-primary" href="#"><i class="fa fa-bars"></i> </a>
        </div>
        <ul class="nav navbar-top-links navbar-right">
          <li>
            <span
                class="m-r-sm text-muted welcome-message">您好 <strong>{{ Auth::user()->name }}
                ({{ Auth::user()->roles->first()->display_name }})</strong></span>
          </li>
          <li>
            <a data-target="#pass-admin" data-toggle="modal">修改密码</a>
          </li>
          @if(!Auth::user()->hasRole(config('roles.super_admin.name')))
            <li>
              <a target="_blank" href="{{ env('LIVE_ADDRESS', 'http://live.honc.tech') . '/login' }}">进入直播间</a>
            </li>
          @endif
          <li>
            <a type="button" id="logout"> <i class="fa fa-sign-out"></i>注销</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              {{ csrf_field() }}
            </form>
          </li>
        </ul>
      </nav>
    </div>
    <div id="app">
      @yield('content')
    </div>
  </div>
  <div class="modal inmodal fade" id="pass-admin" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body clearfix">
          <form id="pass-from" class="form-horizontal" role="form" data-action="/admin/password">
            {{ csrf_field() }}
            <div class="form-group">
              <div class="form-group">
                <label for="admin-oldpass" class="col-sm-2 control-label">原密码</label>
                <div class="col-sm-10">
                  <input type="password" name="old_pass" class="form-control" id="admin-oldpass" placeholder="输入原密码">
                </div>
              </div>
              <div class="form-group">
                <label for="admin-pass" class="col-sm-2 control-label">新密码</label>
                <div class="col-sm-10">
                  <input type="password" name="password" class="form-control" id="admin-pass"
                         placeholder="输入新密码">
                </div>
              </div>
              <div class="form-group">
                <label for="admin-pass-com" class="col-sm-2 control-label">确认密码</label>
                <div class="col-sm-10">
                  <input type="password" name="password_confirmation" class="form-control" id="admin-pass-com" placeholder="再次输入新密码">
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" id="pass-dismiss" class="btn btn-default" data-dismiss="modal">取消</button>
          <button type="button" class="btn btn-primary" id="pass-save">保存</button>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="/js/socket.io.js"></script>
<script src="{{ asset('js/live.js') }}"></script>
<script src="/js/jquery.slimscroll.min.js"></script>
<script src="/js/plugins/icheck.min.js"></script>
<script src="/js/plugins/metisMenu.min.js"></script>
<script src="/js/inspinia.js"></script>
<script src="/js/plugins/pace.min.js"></script>
<script src="/js/plugins/toastr.min.js"></script>
<script src="/js/plugins/sprintf.js"></script>
@if(Session::has('message'))
  <script>
    $(function () {
      toastrNotification('success', '{{Session::get('message')}}')
    })
  </script>
@endif
<script>
  $('#logout').click(function () {
    var opts = {
      title             : '确认注销？',
      type              : 'warning',
      showCancelButton  : true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText : '确认注销',
      cancelButtonText  : '不注销',
      closeOnConfirm    : false,
      closeOnCancel     : false
    };
    sweetAlert(opts, function (isConfirm) {
      if (isConfirm) {
        document.getElementById('logout-form').submit();
      } else {
        sweetAlert("取消", "取消注销!", "error");
      }
    });
  });
  var wsHost    = '{{ config('websocket.host')}}';
  var wsPort    = '{{ config('websocket.port')}}';
  var socket    = io("http://" + wsHost + ":" + wsPort + "");
  window.socket = socket;
</script>
@yield('js')
<script>
  $('.add-btn').click(function () {
    var form = $('#data-form');
    form.find('input[type=text]').attr('value', null);
    form.find('input[type=file]').attr('value', null);
    form.find('input[type=number]').attr('value', null);
    form.find('input[name=id]').val(0);
    form.find('img').attr('src', null);
    form.find('textarea').html('');
  });
  $('#pass-save').click(function () {
    postForm('#pass-from', function () {
      location.reload()
    })
  })
</script>
</body>
</html>
