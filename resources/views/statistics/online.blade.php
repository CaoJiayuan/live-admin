@extends('layouts.table')
@section('table:header')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-8">
            <h2>数据统计</h2>
            <ol class="breadcrumb">
                <li><a href="/">首页</a></li>
                <li class="active"><strong>日在线统计</strong></li>
            </ol>
        </div>
    </div>
@endsection
@section('table:body')
    <div class="ibox-title clearfix">
        <div class="col-md-12">
            <div class="row form-horizontal">
                <div class="col-md-3">
                    <div class="input-group date">
                        <input id="txtdatetime" type="text" class="form-control" value="{{$currentdate}}"/>
                        <input type="hidden" id="hiddenrolename" value="{{$rolename}}"/>
                    </div>
                </div>
                <div class="col-md-3">
                <button type="submit" id="btnquery" class="btn btn-info"><i class="fa fa-search"></i>&nbsp;&nbsp;查&nbsp;&nbsp;询</button>
                    <button  id="btnexport" class="btn btn-info"><i class="glyphicon glyphicon-download-alt"></i>&nbsp;&nbsp;导&nbsp;&nbsp;出</button>
                </div>
            </div>
        </div>
    </div>
    <div class="ibox-content">
        <div id="main" style="width: 100%;height:550px;margin-top: 10px">
        </div>
    </div>
@endsection

@section('js')
    <link href="/css/datapicker/bootstrap-datepicker.min.css" rel="stylesheet"/>
    <script src="/css/datapicker/bootstrap-datepicker.js"></script>
    <script src="/css/datapicker/bootstrap-datepicker.zh-CN.min.js"></script>
    <script src="/js/plugins/echarts.common.min.js"></script>
    <script type="text/javascript">
            $(function(){
                $("#btnexport").click(function(){
                    //区域统计重新计算
                    location.href = '/statistics/excelonline?date=' + $("#txtdatetime").val();
                    return false;
                });
                $("#txtdatetime").datepicker({
                    language: "zh-CN",
                    autoclose: true,//选中之后自动隐藏日期选择框
                    clearBtn: true,//清除按钮
                    todayBtn: true,//今日按钮
                    format: "yyyy-mm-dd"//日期格式，详见 http://bootstrap-datepicker.readthedocs.org/en/release/options.html#format

                });
                $('#btnquery').click(function () {
                    if($("#hiddenrolename").val()=="area_admin"){
                        ResetAreaChart($("#txtdatetime").val());
                    }
                    else{
                        ResetChart($("#txtdatetime").val());
                    }
                });
                if($("#hiddenrolename").val()=="area_admin"){
                    ResetAreaChart('');
                }else {
                    ResetChart('');
                }
            });
            function ResetChart(date) {
                $.ajax({
                    type: "get",
                    dataType: "json",
                    url: "/statistics/getdatechart/",
                    data: {"date":date},
                    success: function (res) {
                        var xdata=[];
                        var ydata=[];
                         if(res.length>0)
                         {
                             for(var i=0;i<res.length;i++) {
                                 xdata.push(res[i].date);
                                 ydata.push(res[i].number);
                             }
                         }
                         console.log(xdata);
                         console.log(ydata);

                        // 基于准备好的dom，初始化echarts实例
                        var myChart = echarts.init(document.getElementById('main'));
                        var option = {
                            title: {
                                text: '09:00-23:00在线人数统计趋势图',
                                subtext: '趋势图'
                            },
                            tooltip: {
                                trigger: 'axis',
                                axisPointer : {            // 坐标轴指示器，坐标轴触发有效
                                    type : 'shadow'        // 默认为直线，可选为：‘line‘ | ‘shadow‘
                                }
                            },
                            legend: {
                                data:['最高在线','最低在线']
                            },
                            toolbox: {
                                show: true,
                                feature: {
                                    //  dataZoom: {
                                    //      yAxisIndex: 'none'
                                    // },
                                    //dataView: {readOnly: false},
                                    //magicType: {type: ['line', 'bar']},
                                    //restore: {},
                                    saveAsImage: {}
                                }
                            },
                            xAxis:  {
                                type: 'category',
                                boundaryGap: false,
                                axisLabel:{
                                    interval:0,
                                    rotate:-60,
                                    margin:2,
                                    textStyle:{
                                        color:"#222"
                                    }
                                },
                                //data: ['2017-05-27 09:00/2017-05-27 10:00','2017-04-09','2017-04-08','2017-04-07','2017-04-06','2017-04-05','2017-04-04','2017-04-03','2017-04-02','2017-04-01']
                                data:xdata
                            },
                            yAxis: {
                                type: 'value',
                                axisLabel: {
                                    formatter: '{value}'
                                }
                            },
                            series: [
                                {
                                    name:'在线人数',
                                    type:'line',
                                    // data:[5, 6,6, 7, 5, 6, 7,7.2,6.5,5.2],
                                    data:ydata,
                                    markPoint: {
//                                        data: [
//                                            {type: 'max', name: '最大值'},
//                                            {type: 'min', name: '最小值'}
//                                        ]
                                    },
                                    markLine: {
//                                        data: [
//                                            {type: 'average', name: '平均值'}
//                                        ]
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
            //获取区域统计数据
            function ResetAreaChart(date){
                $.ajax({
                    type: "get",
                    dataType: "json",
                    url: "/statistics/getdatechart/",
                    data: {"date":date},
                    success: function (res) {
                        var xdata=[];
                        var ydata=[];
                        var lecturernames=[];
                        if(res.length>0)
                        {
                            for(var i=0;i<res.length;i++)
                            {
                                xdata.push(res[i].date);
                                ydata.push(res[i].number);
                                lecturernames.push(res[i].lecturername);
                            }
                        }
                        console.log(xdata);
                        console.log(ydata);

                        // 基于准备好的dom，初始化echarts实例
                        var myChart = echarts.init(document.getElementById('main'));
                        var option = {
                            title: {
                                text: '09:00-23:00在线人数统计趋势图',
                                subtext: '趋势图'
                            },
                            tooltip: {
                                trigger: 'axis',
                                axisPointer : {            // 坐标轴指示器，坐标轴触发有效
                                    type : 'shadow'        // 默认为直线，可选为：‘line‘ | ‘shadow‘
                                },
                                formatter:function(params){
                                    //1:拿到横坐标下标
                                    var num=0;
                                    for(var j=0;j<=xdata.length;j++){
                                        if(xdata[j]==params[0].name){
                                            num=j;
                                            break;
                                        }
                                    }
                                    //2:拿到当前的讲师
                                    var currentname=  lecturernames[num];
                                    //3:拿到当前的项
                                    var sname = params[0].seriesName;
                                    //4:拿到当前的值
                                    var svalue=params[0].value;

                                    var resultstr='';

                                    resultstr+='当前讲师:'+currentname+'<br/>';
                                    resultstr+=sname+':'+svalue+"人<br/>";

                                    return  resultstr;
                                }
                            },
                            legend: {
                                data:['最高在线','最低在线']
                            },
                            toolbox: {
                                show: true,
                                feature: {
                                    //  dataZoom: {
                                    //      yAxisIndex: 'none'
                                    // },
                                    //dataView: {readOnly: false},
                                    //magicType: {type: ['line', 'bar']},
                                    //restore: {},
                                    saveAsImage: {}
                                }
                            },
                            xAxis:  {
                                type: 'category',
                                boundaryGap: false,
                                axisLabel:{
                                    interval:0,
                                    rotate:-60,
                                    margin:2,
                                    textStyle:{
                                        color:"#222"
                                    }
                                },
                                //data: ['2017-05-27 09:00/2017-05-27 10:00','2017-04-09','2017-04-08','2017-04-07','2017-04-06','2017-04-05','2017-04-04','2017-04-03','2017-04-02','2017-04-01']
                                data:xdata
                            },
                            yAxis: {
                                type: 'value',
                                axisLabel: {
                                    formatter: '{value}'
                                }
                            },
                            series: [
                                {
                                    name:'在线人数',
                                    type:'line',
                                    // data:[5, 6,6, 7, 5, 6, 7,7.2,6.5,5.2],
                                    data:ydata,
                                    markPoint: {
//                                        data: [
//                                            {type: 'max', name: '最大值'},
//                                            {type: 'min', name: '最小值'}
//                                        ]
                                    },
                                    markLine: {
//                                        data: [
//                                            {type: 'average', name: '平均值'}
//                                        ]
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