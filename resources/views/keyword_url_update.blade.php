<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="Bookmark" href="/favicon.ico" >
    <link rel="Shortcut Icon" href="/favicon.ico" />
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
    <!--/meta 作为公共模版分离出去-->

    <title>配置URL</title>
</head>
<body>
<article class="page-container">
    <form action="" method="post" class="form form-horizontal" id="form-member-add">
        <form  action="/NCMS-FACE/public/keyword_url_update1" class="form form-horizontal" id="form-member-add">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <div class="row cl">
                <label class="form-label col-xs-3 col-sm-4"><span class="c-red">*</span>URL关键字：</label>
                <div class="formControls col-xs-9 col-sm-8">
                    <input type="text" class="input-text" value="{{$model->keyword}}" placeholder="" id="keyword" name="keyword">
                    <input type="hidden" class="input-text" value="{{$model->keyword_id}}" placeholder="" id="keyword_id" name="keyword_id">
                    <input type="hidden" class="input-text" id="usrname" name="usrname" value="{{\Illuminate\Support\Facades\Session::get('username')}}">
                </div>
            </div>
        <div class="row cl">
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
            </div>
        </div>
    </form>
</article>
<!---->
<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="/NCMS-FACE/public/admin/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="/NCMS-FACE/public/admin/lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="/NCMS-FACE/public/admin/static/h-ui/js/H-ui.min.js"></script>
<script type="text/javascript" src="/NCMS-FACE/public/admin/static/h-ui.admin/js/H-ui.admin.js"></script> <!--/_footer 作为公共模版分离出去-->

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="/NCMS-FACE/public/admin/lib/My97DatePicker/4.8/WdatePicker.js"></script>
<script type="text/javascript" src="/NCMS-FACE/public/admin/lib/jquery.validation/1.14.0/jquery.validate.js"></script>
<script type="text/javascript" src="/NCMS-FACE/public/admin/lib/jquery.validation/1.14.0/validate-methods.js"></script>
<script type="text/javascript" src="/NCMS-FACE/public/admin/lib/jquery.validation/1.14.0/messages_zh.js"></script>
<script type="text/javascript">
    $(function(){
        $("#form-member-add").validate({
            rules:{
                keyword:{
                    required:true,
                    minlength:1,
                    maxlength:200,
                },
            },
            onkeyup:false,
            focusCleanup:true,
            success:"valid",
            submitHandler:function(form){
                $(form).ajaxSubmit({
                    type:'post',
                    url:"/NCMS-FACE/public/keyword_url_update1",
                    success: function () {
                        layer.msg('修改成功！',{icon:1 ,time:1000} ,function () {
                            var index = parent.layer.getFrameIndex(window.name);
                            parent.window.location = parent.window.location;
                            parent.layer.close(index);
                        })
                    },
                    error:function () {
                        layer.msg('修改失败！',{icon:5 ,time:1000} ,function () {
                            var index = parent.layer.getFrameIndex(window.name);
                            parent.$('.btn-refresh').click();
                            parent.layer.close(index);
                        })
                    },
                });

            }
        });
    });
</script>
<!--/请在上方写此页面业务相关的脚本-->
</body>
</html>