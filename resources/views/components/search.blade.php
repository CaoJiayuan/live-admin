<form action="{{ url()->current() }}" method="get">
<div class="input-group search">
    <input placeholder="输入关键字" required class="form-control" name="keyword" type="text" value="{{ Request::get('keyword') }}">
    <span class="input-group-btn">
      <button type="submit" class="btn btn-info">搜索</button>
      <button class="btn btn-default" type="reset">重置</button>
    </span>
</div>
</form>