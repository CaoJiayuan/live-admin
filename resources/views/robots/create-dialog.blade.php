<div class="modal fade" id="add-robots" tabindex="-1" role="dialog" aria-labelledby="data-title">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header ibox-title">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" id="data-title"></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" data-action="/users/robots" id="data-form">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="">
                    <input type="hidden" name="area_id" value="">
                    <input type="hidden" name="room_id" value="">
                    <input type="hidden" name="group_id" value="">
                    <div id="selectAgent" hidden>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">选择业务员</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="agent_id"></select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">名称</label>
                        <div class="col-sm-10">
                            <input type="text" name="name" placeholder="请输入名称" class="form-control" value="">
                        </div>
                        <p style="padding-left:53px">添加多个机器人请用中文"，"隔开(如：机器人1，机器人2)</p>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">选择等级</label>
                        <div class="col-sm-10">
                            <div class="col-sm-10">
                                <select class="form-control" name="level">
                                    @foreach(config('level') as $k=>$v)
                                        <option value="{{$k}}">{{$v}}</option>
                                    @endforeach
                                </select>
                            </div>
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