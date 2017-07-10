<?php
$businessuser=$condition;

?>
<form action="{{ url()->current() }}" method="get">
    <input type="hidden"  id="hiddenagentuserid" value="{{Request::get('agentuserid')}}"/>
    <div class="row">
        <div class="col-sm-2">
            <select id="selectuser" name="agentuserid" class="form-control">
                @if(count($businessuser)==1)
                    <option  value="{{ $businessuser[0]->id }}">{{ $businessuser[0]->username }}</option>
                @else
                    <option  value="0">--请选择业务员--</option>
                    @for ($i = 0; $i <count($businessuser); $i++)
                        <option value="{{ $businessuser[$i]->id }}">{{ $businessuser[$i]->username }}</option>
                    @endfor
                @endif
            </select>
        </div>
        <div class="col-sm-4">
            <button type="submit" class="btn btn-info"><i class="fa fa-search"></i>&nbsp;&nbsp;搜&nbsp;&nbsp;索</button>
            <button id="btnexport" class="btn btn-info"><i class="glyphicon glyphicon-download-alt"></i>&nbsp;&nbsp;导&nbsp;&nbsp;出</button>
        </div>
    </div>
</form>
