<?php
$arealist=$condition['arealist'];
?>
<form action="{{ url()->current() }}" method="get">
    <input type="hidden"  id="hiddenareaid" value="{{Request::get('areaid')}}"/>
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
        <div class="col-sm-4">
            <button type="submit" class="btn btn-info"><i class="fa fa-search"></i>&nbsp;&nbsp;查&nbsp;&nbsp;询</button>
            <button  id="btnexport" class="btn btn-info"><i class="glyphicon glyphicon-download-alt"></i>&nbsp;&nbsp;导&nbsp;&nbsp;出</button>
        </div>
    </div>
</form>
