@extends('layouts.table')

@section('css')
  <link rel="stylesheet" href="/css/switchery.min.css">

  <style>
    #bg-list .img-responsive {
      max-height: 200px;
    }
  </style>
@endsection
@section('table:header')
  <div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
      <h2>房间管理</h2>
      <ol class="breadcrumb">
        <li>
          <a href="/">首页</a>
        </li>
        <li class="active"><strong>房间设置</strong></li>
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
          <span id="room-status">封面已{{ $room->covered ? '开启' :'关闭' }}</span>
          <button class="button btn btn-primary" id="setting-close" type="button">
            {{ $room->covered ? '关闭' :'开启' }}封面
          </button>
          <button class="button btn btn-info" id="setting-save" type="button">保存</button>
        </div>
      </div>
    @endif
  </div>
@endsection
@section('table:body')
  <div class="ibox-title clearfix">
    <div class="col-md-12">
      <div class="row form-horizontal">
        <div class="col-md-6">

        </div>
      </div>
    </div>
  </div>
  @if($errors && $errors->first())
    <div class="alert alert-danger">
      {{ $errors->first() }}
    </div>
  @endif
  <div class="ibox-content" id="room-setting">
    <ul class="nav nav-tabs" role="tablist">
      <li role="presentation" class="active"><a href="#base" aria-controls="base" role="tab" data-toggle="tab">基本设置</a>
      </li>
      <li role="presentation"><a href="#permission" aria-controls="permission" role="tab" data-toggle="tab">权限设置</a>
      </li>
      @if($room && $room->main)
        <li role="presentation"><a href="#video" aria-controls="video" role="tab" data-toggle="tab">视频设置</a>
        </li>
      @endif
      <li role="presentation"><a href="#backgrounds" aria-controls="backgrounds" role="tab" data-toggle="tab">背景设置</a>
      </li>
    </ul>
    @if($room)
      <form class="form-horizontal" id="data-form" data-action="{{ url()->current() }}">
        {{ csrf_field() }}
        <input type="hidden" name="id" value="{{ $room->id }}">
        <input type="hidden" name="main" value="{{ $room->main }}">
        <div class="tab-content">
          <div role="tabpanel" class="tab-pane active fade in" id="base">
            <div class="form-group">
              <label class="col-sm-2 control-label" for="area-name">
                名称
              </label>
              <div class="col-md-5">
                <input type="text" class="form-control" id="area-name" name="title" autocomplete="off"
                       value="{{ $room->title }}"/>
              </div>
              @if($room->main)
                <button class="btn btn-default btn-xs" disabled>总房间</button>
              @endif
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="area-web_title">网站标题</label>
              <div class="col-md-5">
                <input type="text" class="form-control" id="area-web_title" name="web_title" autocomplete="off"
                       value="{{ $room->web_title }}"/>
              </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="area-video_position">视频位置</label>
              <div class="col-md-5">
                <select name="video_position" class="form-control" id="area-video_position">
                  <option value="1" @if($room->video_position==1) selected @endif>居中</option>
                  <option value="2" @if($room->video_position==2) selected @endif>居右</option>
                </select>
              </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="area-modify_num">添加人数</label>
              <div class="col-md-5">
                <input type="number" class="form-control" id="area-modify_num" name="modify_num" autocomplete="off"
                       value="{{ $room->modify_num }}"/>
              </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="area-calendar">财经日历地址</label>
              <div class="col-md-5">
                <input type="text" class="form-control" id="area-calendar" name="calendar" autocomplete="off"
                       value="{{ $room->calendar }}"/>
              </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="data-cover">视频封面</label>
              <div class="col-md-5 text-center">
                <img src="{{ $room->cover }}" alt="" id="img-pre-cover" class="img-responsive center-block">
                <input type="file" id="file-cover" autocomplete="off" accept="image/jpg,image/jpeg,image/png,image/gif"
                       style="display: none;"/>
                <label class="btn btn-default" for="file-cover" style="margin-top: 5px">上传</label>
                <input type="hidden" name="cover" id="data-cover" value="{{ $room->cover }}" autocomplete="off"/>
              </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="data-logo">logo</label>
              <div class="col-md-5 text-center">
                <div class="row">
                  <img src="{{ $room->logo }}" alt="" id="img-pre" class="img-responsive center-block">
                  <span id="logo-warning" style="color: red;display: none;">logo尺寸不规则,可能会影响到前端显示!</span>
                </div>
                <input name="file-logo" type="file" id="file-image" autocomplete="off"
                       accept="image/jpg,image/jpeg,image/png,image/gif"
                       style="display: none;"/>

                <label class="btn btn-default" for="file-image" style="margin-top: 5px">上传</label>
                <input type="hidden" name="logo" id="data-logo" value="{{ $room->logo }}" autocomplete="off"/>
                <span>(建议上传大小:260x56)</span>
              </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="data-logo">二维码</label>
              <div class="col-md-5 text-center">
                <img src="{{ $room->qr_code }}" alt="" id="img-pre-qr" class="img-responsive center-block">
                <input type="file" id="file-qr_code" autocomplete="off"
                       accept="image/jpg,image/jpeg,image/png,image/gif" style="display: none;"/>
                <label class="btn btn-default" for="file-qr_code" style="margin-top: 5px">上传</label>
                <input type="hidden" name="qr_code" id="data-qr_code" value="{{ $room->qr_code }}" autocomplete="off"/>
              </div>
            </div>
          </div>
          <div role="tabpanel" class="tab-pane fade" id="permission">
            <div class="form-group">
              <label class="col-sm-2 control-label" for="data-enable">是否开启</label>
              <div class="col-md-5">
                <input type="checkbox" class="form-control js-switcher" id="data-enable" data-name="enable"
                       autocomplete="off" value="{{ $room->enable }}"
                       @if($room->enable) checked @endif/>
              </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="data-vote">是否显示投票栏</label>
              <div class="col-md-5">
                <input type="checkbox" class="form-control js-switcher" id="data-vote" data-name="vote"
                       autocomplete="off" value="{{ $room->vote }}"
                       @if($room->vote) checked @endif/>
              </div>
            </div>
            {{--<div class="hr-line-dashed"></div>--}}
            {{--<div class="form-group">--}}
            {{--<label class="col-sm-2 control-label" for="data-chat">是否开启聊天</label>--}}
            {{--<div class="col-md-5">--}}
            {{--<input type="checkbox" class="form-control js-switcher" id="data-chat" data-name="chat"--}}
            {{--autocomplete="off" value="{{ $room->chat }}"--}}
            {{--@if($room->chat) checked @endif/>--}}
            {{--</div>--}}
            {{--</div>--}}
            <div class="hr-line-dashed"></div>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="data-popup">是否显示弹窗</label>
              <div class="col-md-5">
                <input type="checkbox" class="form-control js-switcher" id="data-popup" data-name="popup"
                       autocomplete="off" value="{{ $room->popup }}"
                       @if($room->popup) checked @endif/>
              </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="data-interval">发言间隔(秒)</label>
              <div class="col-md-4">
                <input type="number" class="form-control" id="data-interval" name="chat_interval"
                       autocomplete="off" value="{{ $room->chat_interval }}"/>

              </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="data-max_length">消息最大长度(字)</label>
              <div class="col-md-4">
                <input type="number" class="form-control" id="data-max_length" name="max_length"
                       autocomplete="off" value="{{ $room->max_length }}"/>
              </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="filter-words">关键字过滤</label>
              <div class="col-md-4">
                <textarea class="form-control" placeholder="输入关键字, 使用空格隔开" name="words" id="filter-words" cols="30"
                          rows="10">{{ $words }}</textarea>
              </div>
            </div>
          </div>
          @if($room && $room->main)
            <div role="tabpanel" class="tab-pane fade" id="video">
              <div class="form-group">
                <label class="col-sm-2 control-label" for="area-video_YY">YY flash地址</label>
                <div class="col-md-5">
                  <input type="text" class="form-control" id="area-video_YY"
                         value="{{ get_form_param('videos.0.url', $room) }}" name="videos[0][url]" autocomplete="off"/>
                  <small>例如:http://weblbs.yystatic.com/s/用户id/用户id/yycomscene.swf</small>
                </div>
                <input id="video_type_0" type="radio" name="video[type]" value="0">
              </div>
              <div class="hr-line-dashed"></div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="area-video_huya">虎牙用户id</label>
                <div class="col-md-5">
                  <input type="text" class="form-control" id="area-video_huya" name="videos[2][url]" autocomplete="off"
                         value="{{ get_form_param( 'videos.2.url', $room) }}"/>
                </div>
              </div>
              <div class="hr-line-dashed"></div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="area-video_aoduan">奥点云拉流地址</label>
                <div class="col-md-5">
                  <input type="text" class="form-control" id="area-video_aoduan" name="videos[1][url]"
                         autocomplete="off"
                         value="{{ get_form_param('videos.1.url', $room) }}"/>
                </div>
                <input id="video_type_1" type="radio" name="video[type]" value="1">
              </div>

            </div>
          @endif
          <div role="tabpanel" class="tab-pane fade" id="backgrounds">
            <div class="form-group" id="bg-list">
              @foreach($room->backgrounds as $index => $background)
                <div class="col-md-3 text-center">
                  <img src="{{ $background->background }}" class="img-responsive center-block" alt="">
                  <button class="btn btn-danger img-delete" type="button" style="margin-top: 5px">删除</button>
                  <span style="margin-left: 10px"><input type="radio" class="bg-default"
                                                         @if($room->background == $background->background) checked
                                                         @endif name="background" id="bg-default"
                                                         value="{{ $background->background }}"/>默认</span>
                  <input type="hidden" name="backgrounds[{{ $index }}]" value="{{ $background->background }}">
                </div>
              @endforeach
              <div class="col-md-3 text-center bg-add">
                <label class="btn btn-default" for="new-img" style="margin-top: 50px">添加</label>
                <input type="file" accept="image/jpg,image/jpeg,image/png,image/gif" id="new-img"
                       style="display: none;">
              </div>
            </div>
          </div>
        </div>
      </form>
    @endif
  </div>
@endsection

@section('js')
  <script src="/js/plugins/switchery.min.js"></script>
  <script>
    $(window).ready(function () {
      var per     = {{ (int)$permission }};
      var vType   = '{{ $room ? $room->video ? $room->video->type : VIDEO_YY : VIDEO_YY }}';
      var covered = {{ $room ? (int)$room->covered : 1 }} ==
      1;
      var roomId = {{ $room->id }};
      var coBtn  = $('#setting-close');
      coBtn.click(function () {
        $.post('/room/' + roomId + '/co', function () {
          covered = !covered;
          var txt = !covered ? '开启封面' : '关闭封面';
          var st  = !covered ? '封面已关闭' : '封面已开启';
          coBtn.html(txt);
          $('#room-status').html(st);
          socket.emit('command:reload', {
            roomId: '{{ $room ? $room->id : 0 }}'
          });
        })
      });
      $('#video_type_' + vType).attr('checked', true);
      $('#file-image').change(function (e) {
        upload('#file-image', '/upload', 'file', function (data) {
          $('#img-pre').attr('src', data.url);
          $('#data-logo').val(data.url)
        });
        var f      = this.files[0];
        var reader = new FileReader();
        reader.readAsDataURL(f);
        reader.onload = function (e) {
          var img    = new Image();
          img.src    = e.target.result;
          img.onload = function () {
            console.log(img.height);
            console.log(img.width);
            if (img.height > 56 || img.width > 260) {
              $('#logo-warning').show();
            } else {
              $('#logo-warning').hide();
            }
          };
        }
      });
      $('#file-qr_code').change(function () {
        upload('#file-qr_code', '/upload', 'file', function (data) {
          $('#img-pre-qr').attr('src', data.url);
          $('#data-qr_code').val(data.url)
        })
      });
      $('#file-cover').change(function () {
        upload('#file-cover', '/upload', 'file', function (data) {
          $('#img-pre-cover').attr('src', data.url);
          $('#data-cover').val(data.url)
        })
      });
      var $new   = $('#new-img');
      var $index = {{ $room ? count($room->backgrounds) : 0 }};
      $new.change(function () {
        var checked = false;
        if ($index == 0) {
          checked = true;
        }
        upload('#new-img', '/upload', 'file', function (data) {
          var ele = '<div class="col-md-3 text-center"><img src="%s" class="img-responsive center-block" alt="">' +
              '<button class="btn btn-danger img-delete" type="button" style="margin-top: 5px">删除</button>' +
              '<span style="margin-left: 10px"><input  class="bg-default" type="radio" %s name="background" id="bg-default" value="%s"/>默认</span>' +
              '<input type="hidden" name="backgrounds[%s]" value="%s"></div>';
          ele     = sprintf(ele, data.url, checked ? 'checked' : '', data.url, $index, data.url);
          $new.parent().before(ele);
          $index++;
        })
      });

      $('#bg-list').on('click', '.img-delete', function () {
        var item    = $(this).parent();
        var checked = item.find('.bg-default').is(':checked');
        console.log(checked);

        item.remove();
        var bgList = $('#bg-list').find('.bg-default');
        if (checked) {
          bgList.first().attr('checked', true)
        }
        if (bgList.length == 0) {
          $index = 0;
        }
        appendDefault();
      });
      function appendDefault() {
        $('#bg-default-btn').remove();
        var first = $('#bg-list').children().first();
        if (!first.hasClass('bg-add')) {
//          first.append('<span id="bg-default-btn" style="margin-left: 10px" class="btn btn-default btn-xs" disabled>默认</span>');
//          first.append('<input type="radio" class="i-checks" name="background" value=""/>');
        }
      }

      var eles     = $('.js-switcher');
      var settings = {
        secondaryColor      : '#dfdfdf'
        , jackColor         : '#fff'
        , jackSecondaryColor: null
        , className         : 'switchery'
        , disabledOpacity   : 0.5
        , speed             : '0.3s'
        , size              : 'default'
      };
      eles.each(function () {
        var jq = $(this),
            id = 'check-' + jq.data('name');
//        jq.attr('disabled', per == 1);
        new Switchery(this, settings);
        jq.parent().append(sprintf('<input id="%s" type="hidden" name="%s" value="%s"/>', id, $(this).data('name'), jq.val()));
        this.onchange = function () {
          var data = $('#' + id);
          data.val(this.checked ? 1 : 0)
        }
      });

      $('#setting-save').click(function () {
        postForm('#data-form', function () {
          socket.emit('command:reload', {
            roomId: '{{ $room ? $room->id : 0 }}'
          });
          toastrNotification('success', '保存成功')
        }, function (data) {
          toastrNotification('error', data.responseJSON.message)
        });
      })
    })
  </script>
@endsection