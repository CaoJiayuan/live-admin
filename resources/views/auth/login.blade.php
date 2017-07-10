<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>登陆</title>
  <link href="/css/app.css" rel="stylesheet">
  <link href="/css/animate.min.css" rel="stylesheet">
  <link href="/css/inspinia.css" rel="stylesheet">
  <link href="/css/iCheck.css" rel="stylesheet">
  <script>
    window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
  </script>
</head>
<body class="gray-bg">
<div class="middle-box text-center loginscreen" style="margin-top: 40px;">
  <div>
    <div>
      <h1 class="logo-name"></h1>
    </div>

    <h3>直播系统后台管理</h3>
    <form class="m-t" role="form" method="POST" action="{{ route('login') }}">
      {{ csrf_field() }}
      @if ($errors)
        <div class="form-group has-error">
           <span class="help-block">
            <strong>{{ $errors->first() }}</strong>
          </span>
        </div>
      @endif
      <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
        <input type="text" name="username" value="{{ old('username') }}" class="form-control" placeholder="用户名" autofocus>
      </div>
      <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
        <input type="password" name="password" class="form-control" placeholder="密码">
      </div>

      <div class="form-group">
        <label class="i-checks pull-left">
          <input type="checkbox" id="remember"
                 name="remember" {{ old('remember') ? 'checked' : '' }}> 记住我
        </label>
      </div>
      <button type="submit" class="btn btn-primary block full-width m-b">Login</button>
    </form>
    <p class="m-t">
      <small>Live app &copy; 2017</small>
    </p>
  </div>
</div>
<script src="{{ asset('js/live.js') }}"></script>
<script src="/js/plugins/icheck.min.js"></script>
<script>
 $('#remember').iCheck()
</script>
</body>
</html>
