<div class="modal fade" id="data-save" tabindex="-1" role="dialog" aria-labelledby="data-title">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header ibox-title">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" id="data-title"></h4>
            </div>
            <div class="modal-body">
                <form data-action="/admin/agents/create" class="form-horizontal" id="data-form" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="0">
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="data-name">选择团队</label>
                        <div class="col-md-5">
                            <select class="form-control" id="data-name" name="group_id" autocomplete="off">

                            </select>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="data-name">姓名</label>
                        <div class="col-md-5">
                            <input type="text" class="form-control" id="data-name" name="name" autocomplete="off"
                                   value=""/>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="data-gender">性别</label>
                        <div class="col-md-5">
                            <input type="radio" id="data-gender" name="gender" class="i-checks"  value="0"/><span>男</span>
                            <input type="radio" id="data-gender" name="gender" class="i-checks"  value="1"/><span>女</span>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="data-mobile">电话()</label>
                        <div class="col-md-5">
                            <input type="text" class="form-control" id="data-mobile" name="mobile" autocomplete="off" value=""/>
                            <small>默认密码为电话号码后六位</small>
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