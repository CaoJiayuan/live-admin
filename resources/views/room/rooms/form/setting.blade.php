<form class="form-horizontal" id="room-form">
  {{ csrf_field() }}
  <input type="hidden" name="id" value="{{ $id }}">
  <div class="form-group">
    <label class="col-sm-2 control-label" for="area-name">名称</label>
    <div class="col-md-5">
      <input type="text" class="form-control" id="area-name" name="name" autocomplete="off" value="{{ $title }}"/>
    </div>
  </div>
  <div class="hr-line-dashed"></div>
  <div class="form-group">
    <label class="col-sm-2 control-label" for="area-web_title">网站标题</label>
    <div class="col-md-5">
      <input type="text" class="form-control" id="area-web_title" name="web_title" autocomplete="off" value="{{ $web_title }}"/>
    </div>
  </div>
  <div class="hr-line-dashed"></div>
  <div class="form-group">
    <label class="col-sm-2 control-label" for="area-logo">logo</label>
    <div class="col-md-5">
      <input type="text" class="form-control" id="area-logo" name="logo" autocomplete="off" value="{{ $logo }}"/>
    </div>
  </div>
</form>