<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <!--[if lt IE 9]>
    <script type="text/javascript" src="/NCMS-FACE/public/admin/lib/html5shiv.js"></script>
    <script type="text/javascript" src="/NCMS-FACE/public/admin/lib/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="/NCMS-FACE/public/admin/static/h-ui/css/H-ui.min.css" />
    <link rel="stylesheet" type="text/css" href="/NCMS-FACE/public/admin/static/h-ui.admin/css/H-ui.admin.css" />
    <link rel="stylesheet" type="text/css" href="/NCMS-FACE/public/admin/lib/Hui-iconfont/1.0.8/iconfont.css" />
    <link rel="stylesheet" type="text/css" href="/NCMS-FACE/public/admin/static/h-ui.admin/skin/default/skin.css" id="skin" />
    <link rel="stylesheet" type="text/css" href="/NCMS-FACE/public/admin/static/h-ui.admin/css/style.css" />
    <!--[if IE 6]>
    <script type="text/javascript" src="/NCMS-FACE/public/admin/lib/DD_belatedPNG_0.0.8a-min.js" ></script>
    <script>DD_belatedPNG.fix('*');</script>
    <![endif]-->
    <script>

    </script>
    <title>系统启停</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 首页 <span class="c-gray en">&gt;</span> 系统启停</nav>
<div class="page-container">

    <div class="cl pd-5 bg-1 bk-gray mt-20">
		<span class="l">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <input type="hidden" id="start" value="start">
            <input type="hidden" id="end" value="end">
            <input type="hidden" id="restart" value="restart">

            @if( \Illuminate\Support\Facades\Session::get('system') == NULL)
                <a href="/NCMS-FACE/public/start?id=start" class="btn btn-primary radius" onclick="show(0)" ><i class="Hui-iconfont">&#xe726;</i> 启动</a>
            @else
                @if( \Illuminate\Support\Facades\Session::get('system') == "正在运行")
                    <a href="/NCMS-FACE/public/start?id=end" class="btn btn-primary radius" onClick="show(1)"><i class="Hui-iconfont">&#xe726;</i> 停止</a>
                    <a href="/NCMS-FACE/public/start?id=restart" class="btn btn-primary radius" onClick="show(2)"><i class="Hui-iconfont">&#xe726;</i> 重新启动</a>
                @endif
                @if( \Illuminate\Support\Facades\Session::get('system') == "关闭")
                        <a href="/NCMS-FACE/public/start?id=start" class="btn btn-primary radius" onclick="show(0)" ><i class="Hui-iconfont">&#xe726;</i> 启动</a>
                 @endif
            @endif
	    </span>
        <span class="r">系统状态：<strong>{{\Illuminate\Support\Facades\Session::get('system')}}</strong> </span> </div>
    <div class="mt-20">

    </div>
</div>
<div id="modal-demo" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content radius">
            <div class="modal-header">
                <h3 class="modal-title">系统提示</h3>
                <a class="close" data-dismiss="modal" aria-hidden="true" href="javascript:void();">×</a>
            </div>
            <div class="modal-body">
               <p>后台返回信息：<strong>{{\Illuminate\Support\Facades\Session::get('state')}}</strong> <p>
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">关闭</button>
            </div>
        </div>
    </div>
</div>
<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="/NCMS-FACE/public/admin/lib/jquery/1.9.1/jquery.js"></script>
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
            "aaSorting": [[ 1, "desc" ]],//默认第几个排序
            "bStateSave": true,//状态保存
            "aoColumnDefs": [
                //{"bVisible": false, "aTargets": [ 3 ]} //控制列的隐藏显示
                {"orderable":false,"aTargets":[0]}// 制定列不参与排序
            ]
        });

    });


</script>
<script>
    function show(num){
        var content = document.getElementsByClassName('btn btn-primary radius'); // getElementsByClassName得到的是数组形式
        var content_span=document.getElementsByClassName('r');
        // 如果对象中的diplay状态为none
        if(num==0)
        {
            window.parent.change_green();
        }
        else if(num==1)
        {
            window.parent.change_red();
        }
        else
        {
            window.parent.change_green();
        }
    }
</script>
</body>
</html>