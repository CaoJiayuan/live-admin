@extends('layouts.app')
@section('content')
  @yield('table:header')
  <div class="wrapper wrapper-content">
    <div class="row">
      <div class="col-lg-12">
        <div class="ibox float-e-margins ">
          @yield('table:body')
        </div>
      </div>
    </div>
  </div>
@endsection