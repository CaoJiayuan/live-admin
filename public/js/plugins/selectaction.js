/**
 * Created by Administrator on 2017/5/26.
 */
$(function(){
    $("#selectarea").change(function () {
        var areaid=$(this).val();
        if(areaid=="0") {
            $('#selectroom').html('')
            $('#selectroom').append('<option  value="0">--请选择房间--</option>');
            $('#selectgroup').html('');
            $('#selectgroup').append('<option  value="0">--请选择团队--</option>');
            $('#selectuser').html('');
            $('#selectuser').append('<option  value="0">--请选择业务员--</option>');
            return false;
        }
        $.ajax({
            type: "get",
            dataType: "json",
            url: "/statistics/getroomlist",
            data: {"area_id":areaid},
            success: function (data) {

                $('#selectgroup').html('');
                $('#selectgroup').append('<option  value="0">--请选择团队--</option>');
                $('#selectuser').html('');
                $('#selectuser').append('<option  value="0">--请选择业务员--</option>');

                $('#selectroom').html('');


                var shtml='<option  value="0">--请选择房间--</option>';
                for(var i=0;i<data.length;i++){
                    shtml+='<option value="'+data[i].id+'">'+data[i].title+'</option>';
                }
                $('#selectroom').append(shtml);
            }
        });
    })
    $("#selectroom").change(function () {
        var roomid=$(this).val()
        if(roomid=="0") {
            $('#selectgroup').html('');
            $('#selectgroup').append('<option  value="0">--请选择团队--</option>');
            $('#selectuser').html('');
            $('#selectuser').append('<option  value="0">--请选择业务员--</option>');
            return false;
        }
        $.ajax({
            type: "get",
            dataType: "json",
            url: "/statistics/getgrouplist",
            data: {"room_id":roomid},
            success: function (data) {
                $('#selectuser').html('');
                $('#selectuser').append('<option  value="0">--请选择业务员--</option>');

                $('#selectgroup').html('')
                var shtml='<option  value="0">--请选择团队--</option>';
                for(var i=0;i<data.length;i++){
                    shtml+='<option value="'+data[i].id+'">'+data[i].name+'</option>';
                }
                $('#selectgroup').append(shtml);
            }
        });
    })
    $("#selectgroup").change(function () {
        var groupid= $(this).val();
        $.ajax({
            type: "get",
            dataType: "json",
            url: "/statistics/getbusiness/",
            data: {"group_id":groupid},
            success: function (data) {
                $('#selectuser').html('')
                var shtml='<option  value="0">--请选择业务员--</option>';
                for(var i=0;i<data.length;i++){
                    shtml+='<option value="'+data[i].id+'">'+data[i].name+'</option>';
                }
                $('#selectuser').append(shtml);

            }
        });
    })

    var hareaid= $("#hiddenareaid").val();
    var hroomid= $("#hiddenroomid").val();
    var hgroupid= $("#hiddengroupid").val();
    var hagentid= $("#hiddenagentuserid").val();

    //需要去填充该区域下面的房间
    if(hareaid!='') {
        $.ajax({
            type: "get",
            dataType: "json",
            url: "/statistics/getroomlist",
            data: {"area_id":hareaid},
            success: function (data) {
                $('#selectroom').html('')
                var shtml='<option  value="0">--请选择房间--</option>';
                for(var i=0;i<data.length;i++){
                    if(hroomid!='' && hroomid==data[i].id) {
                        shtml += '<option selected="selected" value="' + data[i].id + '">' + data[i].title + '</option>';
                    }else {
                        shtml += '<option value="' + data[i].id + '">' + data[i].title + '</option>';
                    }
                }
                $('#selectroom').append(shtml);
            }
        });
    }//需要去填充该房间下面的团队
    if(hroomid!='') {
        $.ajax({
            type: "get",
            dataType: "json",
            url: "/statistics/getgrouplist",
            data: {"room_id":hroomid},
            success: function (data) {
                $('#selectgroup').html('')
                var shtml='<option  value="0">--请选择团队--</option>';
                for(var i=0;i<data.length;i++){
                    if(hgroupid!='' && hgroupid==data[i].id) {
                        shtml += '<option selected="selected" value="' + data[i].id + '">' + data[i].name + '</option>';
                    }else{
                        shtml += '<option  value="' + data[i].id + '">' + data[i].name + '</option>';
                    }
                }
                $('#selectgroup').append(shtml);
            }
        });
    }//需要去填充该团队下面的业务员
    if(hgroupid!='') {
        $.ajax({
            type: "get",
            dataType: "json",
            url: "/statistics/getbusiness/",
            data: {"group_id":hgroupid},
            success: function (data) {
                $('#selectuser').html('')
                var shtml='<option  value="0">--请选择业务员--</option>';
                for(var i=0;i<data.length;i++){
                    if(hagentid!='' && hagentid==data[i].id){
                        shtml += '<option selected="selected" value="' + data[i].id + '">' + data[i].name + '</option>';
                    }else {
                        shtml += '<option value="' + data[i].id + '">' + data[i].name + '</option>';
                    }

                }
                $('#selectuser').append(shtml);

            }
        });
    }
})