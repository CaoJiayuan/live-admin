@extends('layouts.table')
@section('css')
    <link href="/css/datapicker/bootstrap-datepicker.min.css" rel="stylesheet"/>
@endsection
@section('table:header')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-8">
            <h2>数据统计</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="/">首页</a>
                </li>
                <li class="active"><strong>历史统计数据</strong></li>
            </ol>
        </div>
    </div>
@endsection
@section('table:body')
    <div class="ibox-title clearfix">
        <div class="col-md-12">
            <div class="row form-horizontal">
                <div class="col-md-12">
                    <form action="{{ url()->current() }}" method="get">
                    <div class="row" style="margin-bottom: 10px" id="data_5">
                        <div class="col-sm-8">
                            <div class="input-daterange input-group" id="datepicker">
                                <span class="input-group-addon">从</span>
                                <input type="text" readonly="readonly" id="txtbegin" class="input-sm form-control" name="start" value="{{$begin}}"/>
                                <span class="input-group-addon">到</span>
                                <input type="text" readonly="readonly" id="txtend" class="input-sm form-control" name="end" value="{{$end}}" />
                            </div>
                         </div>
                    </div>
                    </form>
                    @include('components.statistics',$condition)
                </div>
            </div>
        </div>
    </div>
    <div class="ibox-content">
        <div id="main" style="width: 100%;height:600px;">

        </div>
    </div>
@endsection
@section('js')
    <script src="/css/datapicker/bootstrap-datepicker.js"></script>
    <script src="/css/datapicker/bootstrap-datepicker.zh-CN.min.js"></script>
    <script src="/js/plugins/echarts.min.js"></script>
    <script src="/js/plugins/selectaction.js"></script>
    <script type="text/javascript">
        $(function () {
            //导出
            $("#btnexport").click(function(){
                var query='';
                query='areaid='+$("#selectarea").val();
                query+='&roomid='+$("#selectroom").val();
                query+='&groupid='+$("#selectgroup").val();
                query+='&agentuserid='+$("#selectuser").val();
                query+='&begin='+$("#txtbegin").val();
                query+='&end='+$("#txtend").val();
                location.href='/statistics/excelhistory?'+query;
                return false;
            });
            $('#data_5 .input-daterange').datepicker({
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true,
                format: "yyyy/mm/dd",
                language: "zh-CN"
            });
            getchartdata('');
            $("#btnsearch").click(function(){
                var query='';
                query='areaid='+$("#selectarea").val();
                query+='&roomid='+$("#selectroom").val();
                query+='&groupid='+$("#selectgroup").val();
                query+='&agentuserid='+$("#selectuser").val();
                query+='&begin='+$("#txtbegin").val();
                query+='&end='+$("#txtend").val();
                getchartdata(query);
                return false;
            })
        })
        function getchartdata(senddata){

            $.ajax({
                type: "get",
                dataType: "json",
                url: "/statistics/gethistorytimerange",
                data: senddata,
                success: function (res) {
                    xname=[];
                    registers=[];
                    logins=[];
                    ios=[];
                    andriod=[];
                    pc=[];
                    topmax=[];

                    xtime=[];
                    for(var i=0;i<res.length;i++){
                        xname.push(res[i].date);
                        xtime.push({key:res[i].date,value:res[i].timeresult});
                        registers.push(res[i].newregister);
                        //logins.push(res[i].totalloginnumber);
                        logins.push(parseInt(res[i].pcnumber)+parseInt(res[i].iosnumber)+parseInt(res[i].androidnumber));
                        topmax.push(res[i].maxnumber);
                        ios.push(res[i].iosnumber);
                        andriod.push(res[i].androidnumber);
                        pc.push(res[i].pcnumber);
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
                                    data: [
//                                        {type: 'max', name: '最大值'},
//                                        {type: 'min', name: '最小值'}
                                    ]
                                },itemStyle : { normal: {label : {show: true}}}
                            },
                            {
                                name:'总登录数',
                                type:'line',
                                data:logins,
                                markPoint: {
                                    data: [
//                                        {type: 'max', name: '最大值'},
//                                        {type: 'min', name: '最小值'}
                                    ]
                                },itemStyle : { normal: {label : {show: true}}}
                            },
                            {
                                name:'峰值数量',
                                type:'line',
                                data:topmax,
                                markPoint: {
                                    data: [
//                                        {type: 'max', name: '最大值'},
//                                        {type: 'min', name: '最小值'}
                                    ]
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
                                                for (var j = 0; j < xtime.length; j++) {
                                                    if (xtime[j].key == a.name) {
                                                        if (xtime[j].value == '') {
                                                            result = '暂无';
                                                        } else {
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
                                    data: [
//                                        {type: 'max', name: '最大值'},
//                                        {type: 'min', name: '最小值'}
                                    ]
                                },
                                itemStyle : { normal: {label : {show: true}}}
                            },
                            {
                                name:'安卓登录数',
                                type:'line',
                                data:andriod,
                                markPoint: {
                                    data: [
//                                        {type: 'max', name: '最大值'},
//                                        {type: 'min', name: '最小值'}
                                    ]
                                },
                                itemStyle : { normal: {label : {show: true}}}
                            },
                            {
                                name:'电脑登录数',
                                type:'line',
                                data:pc,
                                markPoint: {
                                    data: [
//                                        {type: 'max', name: '最大值'},
//                                        {type: 'min', name: '最小值'}
                                    ]
                                },
                                itemStyle : { normal: {label : {show: true}}}
                            }
                        ]
                    };
                    // 使用刚指定的配置项和数据显示图表。
                    myChart.setOption(option);
                }
            });
        }
    </script>
@endsection