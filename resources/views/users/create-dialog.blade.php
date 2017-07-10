<div class="modal fade" id="add-user" tabindex="-1" role="dialog" aria-labelledby="data-title">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header ibox-title">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" id="data-title"></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" data-action="/users" id="data-form">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="">
                    <div id="selectArea" hidden>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><span style="color:red">*</span>选择区域</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="area_id"></select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                    </div>
                    <div id="selectRoom" hidden>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><span style="color:red">*</span>选择房间</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="room_id"></select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                    </div>
                    <div id="selectGroup" hidden>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><span style="color:red">*</span>选择团队</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="group_id"></select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                    </div>
                    <div id="selectAgent" hidden>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><span style="color:red">*</span>选择业务员</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="agent_id"></select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><span style="color:red">*</span>姓名</label>
                        <div class="col-sm-10">
                            <input type="text" name="name" placeholder="请输入姓名" class="form-control" value="">
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><span style="color:red">*</span>昵称</label>
                        <div class="col-sm-10">
                            <input type="text" name="nickname" placeholder="请输入姓名" class="form-control" value="">
                        </div>
                    </div>

                    <div class="hr-line-dashed" id="setUserName" hidden></div>
                    <div class="form-group"  id="setUserNameIn" hidden>
                        <label class="col-sm-2 control-label"><span style="color:red">*</span>用户名</label>
                        <div class="col-sm-10">
                            <input type="text" name="username" placeholder="请输入用户名" class="form-control">
                        </div>
                    </div>

                    <div class="hr-line-dashed" id="setMobile"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><span style="color:red">*</span>电话</label>
                        <div class="col-sm-10">
                            <input type="text" name="mobile" placeholder="请输入电话" class="form-control" value="">
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group"><label class="col-sm-2 control-label"><span style="color:red">*</span>性别</label>
                        <div class="col-sm-10">
                            <label> <input class="i-checks" type="radio" value="1" name="gender" checked="true"> <i></i>
                                男 </label>&nbsp;&nbsp;&nbsp;
                            <label> <input class="i-checks" type="radio" value="2" name="gender"> <i></i> 女
                            </label>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><span style="color:red">*</span>用户等级</label>
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
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">qq</label>
                        <div class="col-sm-10">
                            <input type="text" name="qq" placeholder="请输入QQ号" class="form-control" value="">
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">推荐人</label>
                        <div class="col-sm-10">
                            <input type="text" name="inviter" placeholder="请输入推荐人用户名" class="form-control" value="">
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