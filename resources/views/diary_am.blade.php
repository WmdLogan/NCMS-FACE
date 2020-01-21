<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="stylesheet" type="text/css" href="/NCMS-FACE/public/admin/static/h-ui/css/H-ui.min.css" />
    <link rel="stylesheet" type="text/css" href="/NCMS-FACE/public/admin/static/h-ui.admin/css/H-ui.admin.css" />
    <link rel="stylesheet" type="text/css" href="/NCMS-FACE/public/admin/lib/Hui-iconfont/1.0.8/iconfont.css" />
    <link rel="stylesheet" type="text/css" href="/NCMS-FACE/public/admin/static/h-ui.admin/skin/default/skin.css" id="skin" />
    <link rel="stylesheet" type="text/css" href="/NCMS-FACE/public/admin/static/h-ui.admin/css/style.css" />
    <title>AM消息内容监测日志</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 日志管理 <span class="c-gray en">&gt;</span> AM消息内容监测日志</nav>
<div class="page-container">
    <form action="/NCMS-FACE/public/diary_search" method="post" class="form form-horizontal">
        <div class="text-c">
            <input type="text"  placeholder="输入要查询的源地址"  class="input-text" style="width:300px" id="saddr" name="saddr" >
            <input type="text"  placeholder="输入要查询的源端口"  class="input-text" style="width:200px" id="sport" name="sport" >
            <input type="text"  placeholder="输入要查询的目的地址"  class="input-text" style="width:300px" id="daddr" name="daddr" >
            <input type="text"  placeholder="输入要查询的目的端口"  class="input-text" style="width:200px" id="dport" name="dport" >
            <br><br>
            <input type="text"  placeholder="输入要查询的日志编号"  class="input-text" style="width:200px" id="log_id" name="log_id">
            <input type="text"  placeholder="输入要查询的关键字"  class="input-text" style="width:250px"  id="keyword" name="keyword">
            日期范围：
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <input type="text" onfocus="WdatePicker({ maxDate:'#F{$dp.$D(\'datemax\')||\'%y-%M-%d\'}' })" id="datemin" name="datemin" class="input-text Wdate" style="width:120px;">
            <input type="text" onfocus="WdatePicker({ minDate:'#F{$dp.$D(\'datemin\')}',maxDate:'%y-%M-%d' })" id="datemax" name="datemax" class="input-text Wdate" style="width:120px;">
            <input type="hidden"  id="table" name="table" value="10">
            <input type="submit" class="btn btn-success radius" value="查询">
        </div>
    </form>
    <div class="cl pd-5 bg-1 bk-gray mt-20">
        <span class="l">
            <a href="javascript:"  onclick="location.href='/NCMS-FACE/public/diary_export?id=1'" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe632;</i> 日志导出</a>
        </span>
    </div>
    <div class="mt-20">
        <table class="table table-border table-bordered table-hover table-bg table-sort">
            <thead>
            <tr class="text-c">
                <th width="30">日志编号</th>
                <th width="80">AM消息内容关键字</th>
                <th width="100">源地址</th>
                <th width="40">源端口</th>
                <th width="100">目的地址</th>
                <th width="40">目的端口</th>
                <th width="100">时间</th>
            </tr>
            </thead>
            <tbody>
            @foreach($model as $val)
                <tr class="text-c">
                    <td>{{$val -> log_id}}</td>
                    <td>{{$val -> keyword}}</td>
                    <td>{{$val ->saddr}}</td>
                    <td>{{$val ->sport}}</td>
                    <td>{{$val ->daddr}}</td>
                    <td>{{$val ->dport}}</td>
                    <td>{{$val ->log_time}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="/NCMS-FACE/public/admin/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="/NCMS-FACE/public/admin/lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="/NCMS-FACE/public/admin/static/h-ui/js/H-ui.min.js"></script>
<script type="text/javascript" src="/NCMS-FACE/public/admin/static/h-ui.admin/js/H-ui.admin.js"></script> <!--/_footer 作为公共模版分离出去-->

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="/NCMS-FACE/public/admin/lib/My97DatePicker/4.8/WdatePicker.js"></script>
<script type="text/javascript" src="/NCMS-FACE/public/admin/lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/NCMS-FACE/public/admin/lib/laypage/1.2/laypage.js"></script>
<script type="text/javascript">
    $(function(){
        $('.table-sort').dataTable({
            "aaSorting": [[ 6, "desc" ]],//默认第几个排序
            "bStateSave": true,//状态保存
            "aoColumnDefs": [
                //{"bVisible": false, "aTargets": [ 3 ]} //控制列的隐藏显示
                {"orderable":false,"aTargets":[0,1,2,3,4,5]}// 制定列不参与排序
            ]
        });

    });
</script>
</body>
</html>