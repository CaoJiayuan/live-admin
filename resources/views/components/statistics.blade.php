<?php
$arealist=$condition['arealist'];
$roomlist=$condition['roomlist'];

$grouplist=$condition['grouplist'];
$businessuser=$condition['businessuser'];
?>
<form action="{{ url()->current() }}" method="get">

    <input type="hidden"  id="hiddenareaid" value="{{Request::get('areaid')}}"/>
    <input type="hidden"  id="hiddenroomid" value="{{Request::get('roomid')}}"/>
    <input type="hidden"  id="hiddengroupid" value="{{Request::get('groupid')}}"/>
    <input type="hidden"  id="hiddenagentuserid" value="{{Request::get('agentuserid')}}"/>

    <div class="row">
        <div class="col-sm-2">
                <select  id="selectarea" name="areaid" class="form-control">
                    @if (count($arealist) == 1)
                        <option  value="{{ $arealist[0]->id }}">{{ $arealist[0]->name }}</option>
                    @else
                        <option  value="0">--请选择区域--</option>
                        @for ($i = 0; $i <count($arealist); $i++)
                            @if(Request::get('areaid')==$arealist[$i]->id)
                                <option selected="selected" value="{{ $arealist[$i]->id }}">{{ $arealist[$i]->name }}</option>
                            @else
                                <option value="{{ $arealist[$i]->id }}">{{ $arealist[$i]->name }}</option>
                            @endif
                        @endfor
                    @endif
                </select>
            </div>
        <div class="col-sm-2">
            <select id="selectroom" name="roomid" class="form-control">
                    @if(count($roomlist)==1)
                    <option  value="{{ $roomlist[0]->id }}">{{ $roomlist[0]->title }}</option>
                    @else
                        <option  value="0">--请选择房间--</option>
                        @for ($i = 0; $i <count($roomlist); $i++)
                                <option  value="{{ $roomlist[$i]->id }}">{{ $roomlist[$i]->title }}</option>

                        @endfor
                    @endif
            </select>
        </div>
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
        <div class="col-sm-2">
            <select id="selectuser" name="agentuserid" class="form-control">
                @if(count($businessuser)==1)
                    <option  value="{{ $businessuser[0]->id }}">{{ $businessuser[0]->name }}</option>
                @else
                    <option  value="0">--请选择业务员--</option>
                    @for ($i = 0; $i <count($businessuser); $i++)
                        <option value="{{ $businessuser[$i]->id }}">{{ $businessuser[$i]->name }}</option>
                    @endfor
                @endif

            </select>
        </div>
        <div class="col-sm-4">
            <button type="submit" id="btnsearch" class="btn btn-info"><i class="fa fa-search"></i>&nbsp;&nbsp;搜&nbsp;&nbsp;索</button>
            <button id="btnexport" class="btn btn-info"><i class="glyphicon glyphicon-download-alt"></i>&nbsp;&nbsp;导&nbsp;&nbsp;出</button>
        </div>
    </div>
</form>
