<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <!--[if lt IE 9]>
    <script type="text/javascript" src="lib/html5shiv.js"></script>
    <script type="text/javascript" src="lib/respond.min.js"></script>
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
    <title>域名关键字配置</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 配置管理 <span class="c-gray en">&gt;</span> 域名关键字配置 </nav>
<div class="page-container">
    @if($auth == 1)
    <div class="cl pd-5 bg-1 bk-gray mt-20">
        <span class="l"><a href="javascript:;" onclick="member_add('配置URL','/NCMS-FACE/public/keyword_dns_add','600','270')"class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 配置域名关键字</a>
        <a  href="javascript:;" onclick="delKeys(this,1)" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a></span>
    </div>
@endif

    <div class="mt-20">
        <table class="table table-border table-bordered table-hover table-bg table-sort">
            <thead>
            <tr class="text-c">
                <th width="10"><input type="checkbox" name="" value=""></th>
                <th width="80">域名关键字</th>
                <th width="80">欺骗IP</th>
                <th width="100">添加时间</th>
                <th width="100">修改时间</th>
                <th width="100">添加用户</th>
                @if($auth == 1)
                <th width="40">操作</th>
                    @endif
            </tr>
            </thead>
            <tbody>
            @foreach($model as $val)
                <tr class="text-c">
                    <td><input type="checkbox" class="ck checkbox-inline" value="{{$val -> keyword_id}}" ></td>
                    <td>{{$val -> keyword}}</td>
                    <td>{{$val -> cheat_ip}}</td>
                    <td>{{$val -> created_at}}</td>
                    <td>{{$val -> updated_at}}</td>
                    <td>{{$val -> usrname}}</td>
                    @if($auth == 1)
                    <td  class="td-manage">
                        <a title="编辑" href="javascript:" onclick="member_edit('编辑','/NCMS-FACE/public/keyword_dns_update?id={{$val -> keyword_id}}','','600','270')" class="ml-5" style="text-decoration:none"><i  class="Hui-iconfont">&#xe6df;</i></a>
                        <a title="删除" href="javascript:" onclick="member_del(this,{{$val -> keyword_id}})" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a>
                    </td>
                        @endif
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
            "aaSorting": [[ 3, "desc" ]],//默认第几个排序
            "bStateSave": true,//状态保存
            "aoColumnDefs": [
                {"orderable":false,"aTargets":[0,1,2,3,4,5]}// 制定列不参与排序
            ]
        });
    });
    /*用户-添加*/
    function member_add(title,url,w,h){
        layer_show(title,url,w,h);
    }
    /*用户-编辑*/
    function member_edit(title,url,id,w,h){
        layer_show(title,url,w,h);
    }
    /*密码-修改*/
    function change_password(title,url,id,w,h){
        layer_show(title,url,w,h);
    }
    function member_del(obj,id){
        layer.confirm( '确认要删除吗？',function(index){
            $.post('/NCMS-FACE/public/keyword_dns_delete',{
                    'id':id,
                    '_token':"{{csrf_token()}}",
                },
                function (data) {
                    if( data.status == 0 ){
                        $(obj).parents("tr").remove();
                        layer.msg(data.message,{icon:1,time:1000});
                    }else{
                        layer.msg(data.message,{icon:1,time:1000});
                    }
                }
            )
        });
    }
    function delKeys(obj,id)
    {
        let ck = $('.ck');
        let items = [];
        for (let i=0; i<ck.length; i++) {
            if (ck[i].checked) {
                items.push(ck[i].value);        // 将id都放进数组
            }
        }
        if (items == null || items.length == 0)        // 当没选的时候，不做任何操作
        {
            return false;
        }
        layer.confirm('您确定要删除我们吗？', function() {
            $.post("/NCMS-FACE/public/keyword_dns_deletes", {
                "_token": "{{ csrf_token() }}",
                "keys": items
            }, function(data) {
                if (data.status == 0) {
                    layer.msg(data.message, {icon:1,time:100});
                    location.href = location.href;
                } else {
                    layer.msg(data.message, {icon:5,time:1000});
                }
            });
        });}
</script>
</body>
</html>