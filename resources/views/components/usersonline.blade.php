<form action="{{ url()->current() }}" method="get">
    <div class="col-md-12">
        <div class="col-md-3">
        <select name="area" class="form-control">
            @if(in_array(Auth::user()->roles->first()->name,['super_admin']))
                <option value="">--请选择区域--</option>
            @endif
            @foreach($condition['areas'] as $v)
                <option value="{{ $v['id'] }}"
                        @if($v['id']==Request::get('area')) selected="selected" @endif>{{ $v['name'] }}</option>
            @endforeach
        </select>
    </div>
        <div class="col-md-3">
        <select name="room" class="form-control">
            @if(in_array(Auth::user()->roles->first()->name,['super_admin','area_admin']))
                <option value="">--请选择房间--</option>
            @endif
            @foreach($condition['rooms'] as $v)
                <option value="{{ $v['id'] }}"
                        @if($v['id']==Request::get('room')) selected="selected" @endif>{{ $v['title'] }}</option>
            @endforeach
        </select>
    </div>
        <div class="col-md-3">
        <select name="group" class="form-control">
            @if(in_array(Auth::user()->roles->first()->name,['super_admin','area_admin','room_admin']))
                <option value="">--请选择团队--</option>
            @endif
            @foreach($condition['groups'] as $v)
                <option value="{{ $v['id'] }}"
                        @if($v['id']==Request::get('group')) selected="selected" @endif>{{ $v['name'] }}</option>
            @endforeach
        </select>
    </div>
    </div>
    <div class="col-md-12" style="margin-top: 10px">
        <div class="col-md-3">
            <select name="agent" class="form-control">
                @if(in_array(Auth::user()->roles->first()->name,['super_admin','area_admin','room_admin','group_admin']))
                    <option value="">--请选择业务员--</option>
                @endif
                @foreach($condition['agents'] as $v)
                    <option value="{{ $v['id'] }}"
                            @if($v['id']==Request::get('agent')) selected="selected" @endif>{{ $v['name'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select name="ua" class="form-control">
                @if( Request::get('ua')=="" )
                    <option selected="selected" value="">--全部--</option>
                    <option value="1">--PC--</option>
                    <option value="2">--手机--</option>
                @elseif(Request::get('ua')=="1")
                    <option value="">--全部--</option>
                    <option  selected="selected" value="1">--PC--</option>
                    <option value="2">--手机--</option>
                @elseif(Request::get('ua')=="2")
                    <option value="">--全部--</option>
                    <option value="1">--PC--</option>
                    <option selected="selected" value="2">--手机--</option>
                @else
                    <option selected="selected" value="">--全部--</option>
                    <option value="1">--PC--</option>
                    <option value="2">--手机--</option>
                @endif

            </select>
        </div>
        <div class="col-md-3">
            <input placeholder="输入关键字" class="form-control" name="keyword" type="text"
                   value="{{ Request::get('keyword') }}">
        </div>
        <div class="col-md-2">
        <span class="input-group-btn">
            <button type="submit" class="btn btn-info">搜索</button>
        </span>
        </div>
    </div>

</form>
