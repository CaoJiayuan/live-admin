@extends('layouts.table')

@section('table:header')
  <div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
      <h2>课程表管理</h2>
      <ol class="breadcrumb">
        <li>
          <a href="/">首页</a>
        </li>
        <li class="active"><strong>课程表</strong></li>
      </ol>
    </div>
  </div>
@endsection
@section('table:body')
  <div class="ibox-content">
    <table class="table table-bordered dataTable">
      <thead>
      <tr>
        <td class="text-center">时间</td>
        <td class="text-center">周一</td>
        <td class="text-center">周二</td>
        <td class="text-center">周三</td>
        <td class="text-center">周四</td>
        <td class="text-center">周五</td>
        <td class="text-center">周六</td>
        <td class="text-center">周日</td>
      </tr>
      </thead>
      <tbody>
      @foreach($data as $hour => $row)
        <tr>
          <td class="text-center">{{ $hour }}:00 - {{ $hour + 1 }}:00</td>
          @foreach($row as $k => $value)
            <td class="text-center">{{ array_get($value, 'title') }} {{ array_get($value,'lecturer') ? '(' . array_get($value,'lecturer') .')' : ''}}
                @if(array_get($value,'id'))
                  <a data-toggle="modal" data-target="#data-save"
                     onclick="showModal({{ json_encode($value) }})">修改</a>

                @else
                  <a
                      data-toggle="modal" data-target="#data-save" onclick="showModal({{ json_encode($value) }})">
                    添加</a>
                @endif
            </td>
          @endforeach
        </tr>
      @endforeach
      </tbody>
    </table>
  </div>

  <div class="modal fade" id="data-save" tabindex="-1" role="dialog" aria-labelledby="data-title">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header ibox-title">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                aria-hidden="true">&times;</span></button>
          <h4 class="modal-title text-center" id="data-hour-title"></h4>
        </div>
        <div class="modal-body">
          <form class="form-horizontal" data-action="/room/schedules/create" id="data-form">
            {{ csrf_field() }}
            <input type="hidden" class="form-control" id="data-hour" name="hour" autocomplete="off" value=""/>
            <input type="hidden" class="form-control" id="data-time" name="time" autocomplete="off" value=""/>
            <input type="hidden" class="form-control" id="data-day" name="day" autocomplete="off" value=""/>
            <input type="hidden" name="id" id="data-id" value="0">
            <div class="form-group">
              <label class="col-sm-2 control-label" for="data-title">标题</label>
              <div class="col-md-8">
                <input type="text" id="data-title" class="form-control" name="title" autocomplete="off" value=""/>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="data-lecturer_id">讲师</label>
              <div class="col-md-8">
                <select id="data-lecturer_id" class="form-control" name="lecturer_id" autocomplete="off">
                  @foreach($lecturers as $k => $lecturer)
                    <option value="{{ $lecturer->id }}">{{ $lecturer->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-info" id="data-save-btn">保存</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')
  <script>
    $(function () {
      $('#data-save-btn').click(function () {
        postForm('#data-form', function () {
          location.reload()
        })
      });
    });

    var days = [
      '周一',
      '周二',
      '周三',
      '周四',
      '周五',
      '周六',
      '周日'
    ];

    function showModal(item) {
      $('#data-hour-title').html(days[item.day - 1] + '  ' + item.hour + ':00-' + (item.hour + 1) + ':00');
      $.each(item, function (k, v) {
        $('#data-' + k).val(v)
      })
    }
  </script>
@endsection