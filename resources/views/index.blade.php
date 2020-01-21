<!DOCTYPE HTML>
<html>
<head>

    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="Bookmark" href="/NCMS-FACE/public/favicon.ico" >a
    <link rel="Shortcut Icon" href="/NCMS-FACE/public/favicon.ico" />
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
    <title>互联网访问监控系统</title>
</head>
<body>
<header class="navbar-wrapper">
    <div class="navbar navbar-fixed-top">
        <div class="container-fluid cl"> <a class="logo navbar-logo f-l mr-10 hidden-xs" href="#">互联网访问监控系统</a>
            <a aria-hidden="false" class="nav-toggle Hui-iconfont visible-xs" href="javascript:;">&#xe667;</a>
            <nav id="Hui-userbar" class="nav navbar-nav navbar-userbar hidden-xs">
                <ul class="cl">
                    <li class="dropDown dropDown_hover">
                        <a href="#" class="dropDown_A">{{\Illuminate\Support\Facades\Session::get('username')}} <i class="Hui-iconfont">&#xe6d5;</i></a>
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <ul class="dropDown-menu menu radius box-shadow">
                            <li><a href="javascript:;" onClick="change_password('修改密码','/NCMS-FACE/public/change_password','360','400')">修改密码</a></li>
                            <li><a href="/NCMS-FACE/public/login">退出</a></li>
                        </ul>
                    <li id="Hui-skin" class="dropDown right dropDown_hover"> <a href="javascript:;" class="dropDown_A" title="换肤"><i class="Hui-iconfont" style="font-size:18px">&#xe62a;</i></a>
                        <ul class="dropDown-menu menu radius box-shadow">
                            <li><a href="javascript:;" data-val="default" title="默认（黑色）">默认（黑色）</a></li>
                            <li><a href="javascript:;" data-val="blue" title="蓝色">蓝色</a></li>
                            <li><a href="javascript:;" data-val="green" title="绿色" id="color_green">绿色</a></li>
                            <li><a href="javascript:;" data-val="red" title="红色" id="color_red">红色</a></li>
                            <li><a href="javascript:;" data-val="yellow" title="黄色">黄色</a></li>
                            <li><a href="javascript:;" data-val="orange" title="橙色">橙色</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</header>
<aside class="Hui-aside">
    <div class="menu_dropdown bk_2">
        <a data-href="/NCMS-FACE/public/system" data-title=" 系统启停" href="javascript:void(0)">
            <dl id="menu-article">
                <dt>
                    <i class="Hui-iconfont">&#xe62e;</i> 系统启停
                </dt>
            </dl></a>
        <dl id="menu-picture">
            <dt><i class="Hui-iconfont">&#xe61a;</i> 配置管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
            <dd>
                <ul>
                    <li><a data-href="/NCMS-FACE/public/keyword_website" data-title="网页内容关键字配置" href="javascript:void(0)">网页内容关键字配置</a></li>
                    <li><a data-href="/NCMS-FACE/public/ip" data-title="IP配置" href="javascript:void(0)">IP配置</a></li>
                    <li><a data-href="/NCMS-FACE/public/keyword_url" data-title="URL配置" href="javascript:void(0)">URL配置</a></li>
                    <li><a data-href="/NCMS-FACE/public/keyword_ftp" data-title="FTP文本内容关键字配置" href="javascript:void(0)">FTP文本内容关键字配置</a></li>
                    <li><a data-href="/NCMS-FACE/public/keyword_dns" data-title="域名关键字配置" href="javascript:void(0)">域名关键字配置</a></li>
                    <li><a data-href="/NCMS-FACE/public/keyword_telnet" data-title="TELNET封堵关键字配置" href="javascript:void(0)">TELNET封堵关键字配置</a></li>
                    <li><a data-href="/NCMS-FACE/public/keyword_am" data-title="AM消息关键字配置" href="javascript:void(0)">AM消息内容关键字配置</a></li>
                    <li><a data-href="/NCMS-FACE/public/keyword_am_txt" data-title="AM文本内容关键字配置" href="javascript:void(0)">AM文本内容关键字配置</a></li>
                    <li><a data-href="/NCMS-FACE/public/keyword_aichang" data-title="爱唱消息关键字配置" href="javascript:void(0)">爱唱消息内容关键字配置</a></li>
                </ul>
            </dd>
        </dl>
        <dl id="menu-comments">
            <dt><i class="Hui-iconfont">&#xe622;</i> 日志管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
            <dd>
                <ul>
                    <li><a data-href="/NCMS-FACE/public/diary_system" data-title="系统操作日志" href="javascript:;">系统操作日志</a></li>
                    <li><a data-href="/NCMS-FACE/public/diary_website" data-title="网页内容监测日志" href="javascript:void(0)">网页内容监测日志</a></li>
                    <li><a data-href="/NCMS-FACE/public/diary_ip" data-title="IP封堵日志" href="javascript:void(0)">	IP封堵日志</a></li>
                    <li><a data-href="/NCMS-FACE/public/diary_url" data-title="URL封堵日志" href="javascript:void(0)">	URL封堵日志</a></li>
                    <li><a data-href="/NCMS-FACE/public/diary_ftp" data-title="FTP文本内容监测日志" href="javascript:void(0)">FTP文本内容监测日志</a></li>
                    <li><a data-href="/NCMS-FACE/public/diary_dns" data-title="域名监测日志" href="javascript:void(0)">域名监测日志</a></li>
                    <li><a data-href="/NCMS-FACE/public/diary_telnet" data-title="TELNET封堵日志" href="javascript:void(0)">TELNET封堵日志</a></li>
                    <li><a data-href="/NCMS-FACE/public/diary_am_txt" data-title="AM文本内容监测日志" href="javascript:void(0)">AM文本内容监测日志</a></li>
                    <li><a data-href="/NCMS-FACE/public/diary_am" data-title="AM消息内容监测日志" href="javascript:void(0)">AM消息内容监测日志</a></li>
                    <li><a data-href="/NCMS-FACE/public/diary_ac" data-title="爱唱消息内容监测日志" href="javascript:void(0)">爱唱消息内容监测日志</a></li>
                    <li><a data-href="/NCMS-FACE/public/diary_file" data-title="保存文件日志" href="javascript:void(0)">保存文件日志</a></li>
                </ul>
            </dd>
        </dl>
        <dl id="menu-admin">

            <dt><i class="Hui-iconfont">&#xe62d;</i> 管理员管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
            <dd>
                <ul>
                    <li><a data-href="/NCMS-FACE/public/auth" data-title="权限管理" href="javascript:void(0)">权限管理</a></li>
                </ul>
            </dd>
        </dl>
    </div>
</aside>
<div class="dislpayArrow hidden-xs"><a class="pngfix" href="javascript:void(0);" onClick="displaynavbar(this)"></a></div>
<section class="Hui-article-box">
    <div id="Hui-tabNav" class="Hui-tabNav hidden-xs">
        <div class="Hui-tabNav-wp">
            <ul id="min_title_list" class="acrossTab cl">
                <li class="active">
                    <span title="首页" data-href="/NCMS-FACE/public/welcome">首页</span>
                    <em></em></li>
            </ul>
        </div>
        <div class="Hui-tabNav-more btn-group"><a id="js-tabNav-prev" class="btn radius btn-default size-S" href="javascript:;"><i class="Hui-iconfont">&#xe6d4;</i></a><a id="js-tabNav-next" class="btn radius btn-default size-S" href="javascript:;"><i class="Hui-iconfont">&#xe6d7;</i></a></div>
    </div>
    <div id="iframe_box" class="Hui-article">
        <div class="show_iframe">
            <div style="display:none" class="loading"></div>
            <iframe scrolling="yes" frameborder="0" src="/NCMS-FACE/public/welcome"></iframe>
        </div>
    </div>
</section>

<div class="contextMenu" id="Huiadminmenu">
    <ul>
        <li id="closethis">关闭当前 </li>
        <li id="closeall">关闭全部 </li>
    </ul>
</div>
<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="/NCMS-FACE/public/admin/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="/NCMS-FACE/public/admin/lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="/NCMS-FACE/public/admin/static/h-ui/js/H-ui.min.js"></script>
<script type="text/javascript" src="/NCMS-FACE/public/admin/static/h-ui.admin/js/H-ui.admin.js"></script> <!--/_footer 作为公共模版分离出去-->
<script type="text/javascript">
    /*密码-修改*/
    function change_password(title,url,id,w,h){
        layer_show(title,url,w,h);
    }
</script>
<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript">
    function change_green()
    {
        document.getElementById("color_green").click();
        //alert("I am an alert box!!");
    }
    function change_red()
    {
        document.getElementById("color_red").click();
        //alert("I am an alert box!!");
    }
</script>
</body>
</html>