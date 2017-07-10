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
                    topmax=[];

                    xtime=[];
                    for(var i=0;i<res.length;i++){
                        xname.push(res[i].date);
                        xtime.push({key:res[i].date,value:res[i].timeresult});
                        registers.push(res[i].newregister);
                        logins.push(res[i].totalloginnumber);
                        topmax.push(res[i].maxnumber);
                    }

                    //for(var i=0;i<topmax.length;i++){
                      //  alert(topmax[i]);
                    //}

                   registers=[1,2,3,4,5,6,7,8,9,10]
                    logins=[10,9,8,7,6,5,4,3,2,1];
                    // 基于准备好的dom，初始化echarts实例
                    var myChart = echarts.init(document.getElementById('main'));
                    var option = {
                        title: {
                            text: '历史日统计数据'
                        },
                        tooltip : {
                            trigger: 'axis',
                            axisPointer: {
                                type: 'cross',
                                label: {
                                    backgroundColor: '#6a7985'
                                }
                            }
                        },
                        legend: {
                           // data:['新用户数','总登录数','峰值数量']
                            data:['新用户数','总登录数']
                        },
                        toolbox: {
                            feature: {
                                saveAsImage: {}
                            }
                        },
                        grid: {
                            left: '3%',
                            right: '4%',
                            bottom: '3%',
                            containLabel: true
                        },
                        xAxis : [
                            {
                                show:true,
                                type : 'category',
                                boundaryGap : false,
                                axisLabel:{
                                    rotate:23,
                                    interval:0
                                },
                                //data : ['周一','周二','周三','周四','周五','周六','周日']
                                data:xname
                            }
                        ],
                        yAxis : [
                            {
                                type : 'value'
                            }
                        ],
                        series : [
                            {
                                name:'新用户数',
                                type:'line',
                                stack: '总量',
                                areaStyle: {normal: {}},
                                //data:[150, 232, 201, 154, 190, 330, 410]
                                data:registers
                            }
                            ,
                            {
                                name:'总登录数',
                                type:'line',
                                stack: '总量',
                                areaStyle: {normal: {}},
                                //data:[320, 332, 301, 334, 390, 330, 320]
                                data:logins
                            }
                            /*
                            {
                                name:'峰值数量',
                                type:'line',
                                stack: '总量',
                                label: {
                                    normal: {
                                        show: true,
                                        position: 'top',
                                        formatter:function(a){
                                            //alert(a.name);
                                            var result='';
                                            for(var j=0;j<xtime.length;j++){
                                                if(xtime[j].key== a.name){
                                                    if(xtime[j].value=='') {
                                                        result='暂无';
                                                    }else {
                                                       var time= xtime[j].value.toString().substring(8);
                                                        if(time.substr(0,1)=='0') {
                                                            time=time.substr(1);
                                                        }
                                                       result = '峰值时间:'+time+":00-"+(parseInt(time)+parseInt(1))+":00";
                                                        //result = '峰值时间:'+xtime[j].value;
                                                    }
                                                    break;
                                                }
                                            }
                                            return result;
                                            //return '最大峰值:'+pms.value+'\n峰值时间: 9:00-10:00';
                                        }
                                    }
                                },
                                areaStyle: {normal: {}},
                                //data:[820, 932, 901, 934, 1290, 1330, 1320]
                                data:topmax
                            }*/
                        ]
                    };
                    // 使用刚指定的配置项和数据显示图表。
                    myChart.setOption(option);
                }
            });



        }
    </script>
@endsection