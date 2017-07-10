<?php
$grouplist=$condition['grouplist'];
?>
<form action="{{ url()->current() }}" method="get">
    <input type="hidden"  id="hiddengroupid" value="{{Request::get('groupid')}}"/>
    <div class="row">
        <div class="col-sm-2">
            <select id="selectgroup" name="groupid" class="form-control">
                @if(count($grouplist)==1)
                    <option  value="{{ $grouplist[0]->id }}">{{ $grouplist[0]->name }}</option>
                @else
                    <option  value="0">--请选择团队--</option>
                    @for ($i = 0; $i <count($grouplist); $i++)
                        <option value="{{ $grouplist[$i]->id }}">{{ $grouplist[$i]->name }}</option>
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
