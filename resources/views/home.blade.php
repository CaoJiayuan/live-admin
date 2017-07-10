@extends('layouts.app')
@section('css')
    <style type="text/css">
        .panelccc {
            height: 150px;border-radius:10px;box-shadow: 0px 2px 1px;
        }
        .paneltitle
        {
            font-weight:500;height: 75px;text-align: center;font-size:24px;line-height: 105px;color: #ffffff;padding-right: 50px;
        }
        .paneldata
        {
            font-weight: 500;height: 75px;line-height:50px;text-align: center;font-size:24px;color: #ffffff;padding-right: 50px;
        }
        .onlinestyle{
            font-weight: 500;
            height: 50px;
            text-align: left;
            font-size:22px;
            line-height: 50px;
            color: #FFFFFF;
        }
    </style>
@endsection
@section('content')
    <input type="hidden" value="{{$rolename}}" id="hiddenrolename"/>
    <div class="container" style="margin-top: 10px">
            @if($rolename=='super_admin' || $rolename=='area_admin' )
            <div class="row">
                <div class="col-md-4">
                        <div class="panelccc" style="background-color:#EB4D3C;">
                            <div style="width: 40%;height:150px;line-height: 150px;float:left;text-align: center">
                                <img src="/css/mobile.png" style="width:70px; height: 70px;" />
                            </div>
                            <div style="width: 60%;height:150px;line-height: 150px;float:left;">
                                <div class="paneltitle">
                                   当前手机在线
                                </div>
                                <div  class="paneldata" id="mobilenumber" >
                                    0人
                                </div>
                            </div>
                        </div>
                </div>
                <div class="col-md-4">
                    <div class="panelccc" style="background-color:rgb(53, 152, 219)">
                        <div style="width: 40%;height:150px;line-height: 150px;float:left;text-align: center">
                            <img src="/css/computer.png" style="width:70px; height: 70px;" />
                        </div>
                        <div style="width: 60%;height:150px;line-height: 150px;float:left;">
                            <div class="paneltitle">
                                当前电脑在线
                            </div>
                            <div  class="paneldata" id="pcnumber">
                                0人
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="panelccc" style="background-color:rgb(26, 188, 156)">
                        <div style="width: 40%;height:150px;line-height: 150px;float:left;text-align: center">
                            <img src="/css/currentonline.png" style="width:70px; height: 70px;" />
                        </div>
                        <div style="width: 60%;height:150px;line-height: 150px;float:left;">
                            <div class="paneltitle">
                                当前全部在线
                            </div>
                            <div  class="paneldata" id="allnumber">
                                0人
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style="margin-top: 10px">
                <div class="col-md-4">
                    <div class="panelccc" style="background-color:#f8ac59">
                        <div style="width: 40%;height:150px;line-height: 150px;float:left;text-align: center">
                            <img src="/css/signleregister.png" style="width:70px; height: 70px;" />
                        </div>
                        <div style="width: 60%;height:150px;line-height: 150px;float:left;">
                            <div class="paneltitle">
                                注册用户
                            </div>
                            <div  class="paneldata" id="registernumber">
                                0人
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="panelccc" style="background-color:#9955AA">
                        <div style="width: 40%;height:150px;line-height: 150px;float:left;text-align: center">
                            <img src="/css/rooms.png" style="width:70px; height: 70px;" />
                        </div>
                        <div style="width: 60%;height:150px;line-height: 150px;float:left;">
                            <div class="paneltitle">
                                房间总数
                            </div>
                            <div  class="paneldata" id="roomnumber">
                                0人
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="panelccc" style="background-color:#23c6c8">
                        <div style="width: 40%;height:150px;line-height: 150px;float:left;text-align: center">
                            <img src="/css/register.png" style="width:70px; height: 70px;" />
                        </div>
                        <div style="width: 60%;height:150px;line-height: 150px;float:left;">
                            <div class="paneltitle">
                                当日总在线
                            </div>
                            <div  class="paneldata" id="currentdayonline" >
                                0人
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @elseif($rolename=='room_admin' || $rolename=='group_admin' || $rolename=='agent_admin' )
            <div class="row">
                <div class="col-md-4">
                    <div class="panelccc" style="background-color:#EB4D3C;">
                        <div style="width: 40%;height:150px;line-height: 150px;float:left;text-align: center">
                            <img src="/css/register.png" style="width:70px; height: 70px;" />
                        </div>
                        <div style="width: 60%;height:150px;line-height: 150px;float:left;">
                            <div class="paneltitle">
                                当前手机在线
                            </div>
                            <div  class="paneldata" id="mobilenumber" >
                                0人
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="panelccc" style="background-color:rgb(53, 152, 219)">
                        <div style="width: 40%;height:150px;line-height: 150px;float:left;text-align: center">
                            <img src="/css/register.png" style="width:70px; height: 70px;" />
                        </div>
                        <div style="width: 60%;height:150px;line-height: 150px;float:left;">
                            <div class="paneltitle">
                                当前电脑在线
                            </div>
                            <div  class="paneldata" id="pcnumber">
                                0人
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="panelccc" style="background-color:rgb(26, 188, 156)">
                        <div style="width: 40%;height:150px;line-height: 150px;float:left;text-align: center">
                            <img src="/css/register.png" style="width:70px; height: 70px;" />
                        </div>
                        <div style="width: 60%;height:150px;line-height: 150px;float:left;">
                            <div class="paneltitle">
                                当前全部在线
                            </div>
                            <div  class="paneldata" id="allnumber">
                                0人
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style="margin-top: 10px">
                <div class="col-md-6">
                    <div class="panelccc" style="background-color:#f8ac59">
                        <div style="width: 40%;height:150px;line-height: 150px;float:left;text-align: center">
                            <img src="/css/signleregister.png" style="width:70px; height: 70px;" />
                        </div>
                        <div style="width: 60%;height:150px;line-height: 150px;float:left;">
                            <div class="paneltitle">
                                注册用户
                            </div>
                            <div  class="paneldata" id="registernumber">
                                0人
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="panelccc" style="background-color:rgb(26, 188, 156)">
                        <div style="width: 40%;height:150px;line-height: 150px;float:left;text-align: center">
                            <img src="/css/register.png" style="width:70px; height: 70px;" />
                        </div>
                        <div style="width: 60%;height:150px;line-height: 150px;float:left;">
                            <div class="paneltitle">
                                当日总在线
                            </div>
                            <div  class="paneldata" id="currentdayonline">
                                0人
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        <div id="main" style="width: 100%;height:500px;margin-top: 20px">
        </div>
    </div>
@endsection
@section('js')
<script src="/js/plugins/echarts.common.min.js"></script>
<script type="text/javascript">
$(function(){
    $.ajax({
        type: "get",
        dataType: "json",
        url: "/statistics/gethomedata/",
        data: {},
        success: function (res) {
            $("#registernumber").html(res.count[0].num+'人');
            $("#allnumber").html(res.count[1].num);
            if($("#hiddenrolename").val()=="super_admin" || $("#hiddenrolename").val()=="area_admin") {
                $("#roomnumber").html(res.count[2].num + '个');
                $("#pcnumber").html(res.count[3].num);
                $("#mobilenumber").html(res.count[4].num);
                $("#currentdayonline").html(res.count[5].num);
            }
            else{
                $("#pcnumber").html(res.count[2].num);
                $("#mobilenumber").html(res.count[3].num);
                $("#currentdayonline").html(res.count[4].num);
            }

            xname=[];
            registers=[];
            logins=[];
            ios=[];
            andriod=[];
            pc=[];
            topmax=[];

            xtime=[];
            for(var i=0;i<res.chart.length;i++){
                xname.push(res.chart[i].date);
                xtime.push({key:res.chart[i].date,value:res.chart[i].timeresult});
                registers.push(res.chart[i].newregister);
               //logins.push(res.chart[i].totalloginnumber);
                logins.push(parseInt(res.chart[i].pcnumber)+parseInt(res.chart[i].iosnumber)+parseInt(res.chart[i].androidnumber));
                topmax.push(res.chart[i].maxnumber);
                ios.push(res.chart[i].iosnumber);
                andriod.push(res.chart[i].androidnumber);
                pc.push(res.chart[i].pcnumber);
            }
            var myChart = echarts.init(document.getElementById('main'));
            var  option = {
                title: {
                    text: '历史日统计数据'
                },
                tooltip: {
                    trigger: 'axis'
                },
                legend: {
                    data:['新用户数','总登录数','峰值数量','苹果登录数','安卓登录数','电脑登录数']
                },
                toolbox: {
                    show: true,
                    feature: {
                        //dataView: {readOnly: false},
                        //restore: {},
                        saveAsImage: {}
                    }
                },
                xAxis:  {
                    type: 'category',
                    boundaryGap: false,
                    data:xname
                },
                yAxis: {
                    type: 'value'
                },
                series: [
                    {
                        name:'新用户数',
                        type:'line',
                        data:registers,
                        markPoint: {
//                            data: [
//                                {type: 'max', name: '最大值'},
//                                {type: 'min', name: '最小值'}
//                            ]
                        },
                        itemStyle : { normal: {label : {show: true}}}
                    },
                    {
                        name:'总登录数',
                        type:'line',
                        data:logins,
                        markPoint: {
//                            data: [
//                                {type: 'max', name: '最大值'},
//                                {type: 'min', name: '最小值'}
//                            ]
                        },
                        itemStyle : { normal: {label : {show: true}}}
                    },
                    {
                        name:'峰值数量',
                        type:'line',
                        data:topmax,
                        markPoint: {
//                            data: [
//                                {type: 'max', name: '最大值'},
//                                {type: 'min', name: '最小值'}
//                            ]
                        }
                        ,
                        label: {
                            normal: {
                                show: true,
                                position: 'top',
                                formatter:function(a){
                                    var result='';
                                    if(parseInt(a.value)==0) {
                                        result="暂无";
                                    }else {
                                        // alert(a.name);
                                        for (var j = 0; j < xtime.length; j++) {
                                            if (xtime[j].key == a.name) {
                                                if (xtime[j].value == '') {
                                                    result = '暂无';
                                                } else {
                                                    /*
                                                     var time= xtime[j].value.toString().substring(8);
                                                     if(time.substr(0,1)=='0') {
                                                     time=time.substr(1);
                                                     }
                                                     result =time+":00-"+(parseInt(time)+parseInt(1))+":00";
                                                     */
                                                    result = xtime[j].value;
                                                }
                                                break;
                                            }
                                        }
                                    }
                                    return result;
                                }
                            }
                        },
                        itemStyle : { normal: {label : {show: true}}}
                    },
                    {
                        name:'苹果登录数',
                        type:'line',
                        data:ios,
                        markPoint: {
//                            data: [
//                                {type: 'max', name: '最大值'},
//                                {type: 'min', name: '最小值'}
//                            ]
                        },
                        itemStyle : { normal: {label : {show: true}}}
                    },
                    {
                        name:'安卓登录数',
                        type:'line',
                        data:andriod,
                        markPoint: {
//                            data: [
//                                {type: 'max', name: '最大值'},
//                                {type: 'min', name: '最小值'}
//                            ]
                        },
                        itemStyle : { normal: {label : {show: true}}}
                    },
                    {
                        name:'电脑登录数',
                        type:'line',
                        data:pc,
                        markPoint: {
//                            data: [
//                                {type: 'max', name: '最大值'},
//                                {type: 'min', name: '最小值'}
//                            ]
                        },
                        itemStyle : { normal: {label : {show: true}}}
                    }
                ]
            };
            // 使用刚指定的配置项和数据显示图表。
            myChart.setOption(option);

        },
        error:function(res){
            alert(res.message);
        }
    })
    //获取3秒获取一次数据信息
    setInterval(function(){
        $.ajax({
            type: "get",
            dataType: "json",
            url: "/statistics/gethomecountdatainteval",
            data: {},
            success: function (res) {

                $("#registernumber").html(res.count[0].num+'人');
                $("#allnumber").html(res.count[1].num);
                if($("#hiddenrolename").val()=="super_admin" || $("#hiddenrolename").val()=="area_admin") {
                    $("#roomnumber").html(res.count[2].num + '个');
                    $("#pcnumber").html(res.count[3].num);
                    $("#mobilenumber").html(res.count[4].num);
                    $("#currentdayonline").html(res.count[5].num);
                }
                else{
                    $("#pcnumber").html(res.count[2].num);
                    $("#mobilenumber").html(res.count[3].num);
                    $("#currentdayonline").html(res.count[4].num);
                }
            },
            error:function(res){
            }
        })


    },3000);
})
</script>
@endsection