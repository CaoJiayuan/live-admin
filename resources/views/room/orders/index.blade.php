@extends('layouts.table')

@section('table:header')
  <div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
      <h2>兑换管理</h2>
      <ol class="breadcrumb">
        <li>
          <a href="/">首页</a>
        </li>
        <li class="active"><strong>兑换列表</strong></li>
      </ol>
    </div>
  </div>
@endsection
@section('table:body')
  <div class="ibox-title clearfix">
    <div class="col-md-12">
      <div class="row form-horizontal">
        <div class="col-md-6">
          @include('components.search')
        </div>
      </div>
    </div>
  </div>
  <div class="ibox-content">
    <table class="table table-bordered dataTable">
      <thead>
      <tr>
        <td class="sorting" data-column="id">序号</td>
        <td>商品</td>
        <td>用户昵称</td>
        <td>用户号码</td>
        <td class="sorting" data-column="credits">消耗积分</td>
        <td class="sorting" data-column="created_at">创建时间</td>
        <td class="sorting" data-column="status">状态</td>
        <td>操作</td>
      </tr>
      </thead>
      <tbody>
      @foreach($data as $item)
        <tr>
          <td>{{ $item->id }}</td>
          <td>{{ $item->good_name }}</td>
          <td>{{ $item->nickname }}</td>
          <td>{{ $item->mobile }}</td>
          <td>{{ $item->credits }}</td>
          <td>{{ $item->created_at }}</td>
          <td>{{ $item->status ? '已兑换' : '未兑换' }}</td>
          <td>
            @if(!$item->status)
              <a href="/room/orders/{{ $item->id }}/status" class="btn btn-xs btn-info">确认兑换</a>
            @endif
          </td>
        </tr>
      @endforeach
      </tbody>
    </table>
    @if($data->total()>=1 && $data->total()<=10)
      <ul class="pagination">
        <li class="disabled"><span>«</span></li>

        <li class="active"><span>1</span></li>

        <li class="disabled"><span>»</span></li>

      </ul>
    @endif
    {{ $data->links() }}
  </div>

@endsection

@section('js')
  <script>
    $(function () {
      $(".pagination").append("<li class='disabled' style='cursor:default'> <a class='disabled' style='cursor:default' href='javascript:void(0)'>总条数:{{$data->total()}}</a> </li>")

    })
  </script>
@endsection