<?php

namespace App\Http\Controllers;
use App\Aichanglog;
use App\Am;
use App\Amlog;
use App\Amtxt;
use App\Amtxtlog;
use App\Dns;
use App\Dnslog;
use App\File;
use App\Ftp;
use App\Ftplog;
use App\Ip;
use App\Iplog;
use App\Syslog;
use App\Telnet;
use App\Telnetlog;
use App\Url;
use App\Urllog;
use App\Weblog;
use App\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use App\Aichang;
use App\Usr;
use Excel;
use function Sodium\compare;


class TestController extends Controller
{
    public function system(){
        return view('systemcontrol');
    }


    public function start(Request $request){
        $model = new Syslog();
       // $socket_dest="192.168.103.93";
        $port=8001;
        $id = $request->get('id');
        switch ($id) {
            case 'start':
                $model->username = Session::get('username');
                $model->operate_type = '启动系统';
                $model->save();
                break;
            case 'end':
                $model->username = Session::get('username');
                $model->operate_type = '关闭系统';
                $model->save();
                break;
            case 'restart':
                $model->username = Session::get('username');
                $model->operate_type = '重新启动系统';
                $model->save();
                break;
        }
        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP) or die("创建失败") ;
        $connection = socket_connect($socket, "192.168.103.93", $port) or die("链接错误");
        $id_len = strlen($id);
        socket_write($socket, $id,$id_len);
        $recvbuff=socket_read($socket,8001);
         Session::put('state',$recvbuff);
         if($recvbuff=="后台尚未启动，请先开启后台"||$recvbuff=="后台启动失败"||$recvbuff=="后台尚未开启"||$recvbuff=="后台关闭成功")
         {
             Session::put('system',"关闭");
         }
         if($recvbuff=="后台启动成功"||$recvbuff=="后台在运行状态中!"||$recvbuff=="后台重启成功")
         {
             Session::put('system',"正在运行");
         }
        socket_close($socket);
        return view('systemcontrol');
    }

    //用户管理
    public function auth(){
        $model = Usr::get();
        return view('auth' ,compact('model'));
    }
    //增加权限
    public function add_auth(Request $request){
        $id = $request->get('id');
        $usr = Usr::where("usr_id",$id)->first();
        $usr->auth = 1;
        $usr -> save();
        $model = Usr::get();
        return view('auth' ,compact('model'));
    }

    public function login(){
        Session::forget('system');
        return view('login');
    }
    public function welcome(){
        return view('welcome');
    }

//登录
    public function index(Request $request){
        $this->validate($request ,[
            'username' => 'required|min:1|max:20',
            'password' => 'required|min:1|max:20'
        ]);
       $username = $request->get('username');
       $password = $request->get('password');
       if(Usr::where("username",$username)->first()){
           $model = Usr::where("username",$username)->first();
           $pw = $model->passwd;
           if($pw == $password){
               Session::put('username', $model->username);
               $auth = Usr::where("username",$model->username)->first()->auth;
               if($auth == 1){
                   return view('index');
               }else{
                   return view('index2');
               }
           }else{
               return redirect('/login');
           }
       }else{
           return redirect('/login');
       }
    }
//注册
    public function signup(){
        return view('signup');
    }
    public function usr_add(Request $request){
            $model = new Usr();
           if(Usr::where('username' , $request->get('username'))->get()->isEmpty()){
                $model -> USERNAME = $request->get('username');
                $model -> PASSWD = $request->get('newpassword');
                $model -> AUTH = 0;
                $model -> USR_ID = '';
                $model->save();
                return 1;
           }
            return true;
    }
    public function change_password(){
        $username = Session::get('username');
        $model = Usr::where("username",$username)->first();
        return view('change_password',compact('model'));
    }

    public function update_password(Request $request){
        if (Input::method() == 'POST') {
            $this->validate($request ,[
                'newpassword' => 'required|min:1|max:20'
            ]);
            $username = Session::get('username');
            $model = Usr::where("username",$username)->first();
            $pw = $request->get('newpassword');
            $model->passwd = $pw;
            $model->save();
            return 1;
        }else{
            return 1;
        }
    }



//aichang
    public function keyword_aichang(){
        $model = Aichang::get();
        $username = Session::get('username');
        $auth = Usr::where("username",$username)->first()->auth;
        return view('keyword_aichang' ,compact('model','auth'));
    }
    public function keyword_aichang_add(){
        return view('keyword_aichang_add');
    }
    public function keyword_aichang_add1(Request $request){
        if (Input::method() == 'POST') {
            $model = new Aichang();
            $log = new Syslog();
            $log->operate_type = "添加爱唱消息内容关键字：{$request->get('keyword')}";
            $log->username = $request->get('usrname');
            $log->save();
            $result = $model->create($request->all());
            if ($result != false) {
               $result = $this->model_update('aichang_message');
               }
            return $result ? '1' : '0';
        }else{
            return view('keyword_aichang_add');
        }
    }
    public function keyword_aichang_update(Request $request){
        $id = $request->get('id');
        $model = Aichang::find($id);
        return view('keyword_aichang_update',compact('model'));
    }
    public function keyword_aichang_update1(Request $request){
        if (Input::method() == 'POST') {
            $id = $request->get('keyword_id');
            $model = Aichang::find($id);
            $model->keyword = $request->get('keyword');
            $model->usrname = $request->get('usrname');
            $result = $model->save();
            if ($result != false) {
                $result = $this->model_update('aichang_message');
            }
            return $result ? '1' : '0';
        }else{
            return view('keyword_aichang_update');
        }

    }
    public function keyword_aichang_delete(Request $request){
        $id = $request->get('id');
        $model = Aichang::find($id);
        $log = new Syslog();
        $log->operate_type = "删除爱唱消息内容关键字：{$model->keyword}";
        $log->username = Session::get('username');
        $log->save();
        $result = $model->delete();
        if ($result != false) {
            $result = $this->model_update('aichang_message');
        }
        if($result!=false){
            $data = [
                'status' => 0,
                'message' => '删除成功'
            ];
        }else{
            $data = [
                'status' => 1,
                'message' => '删除失败'
            ];
        }
        return $data;
    }
    public function keyword_aichang_deletes(Request $request){
        for ($i=0; $i<count($request['keys']); $i++) {
            $model = Aichang::find($request['keys'][$i]);
            $log = new Syslog();
            $log->operate_type = "删除爱唱消息内容关键字：{$model->keyword}";
            $log->username = Session::get('username');
            $log->save();
            $result = $model->delete();
        }
        if ($result != false) {
            $result = $this->model_update('aichang_message');
        }
        if($result != false){
            $data = [
                'status' => 0,
                'message' => '删除成功'
            ];
        }else{
            $data = [
                'status' => 1,
                'message' => '删除失败'
            ];
        }
        return $data;
    }
    //website
    public function keyword_website(){
        $model = Website::get();
        $username = Session::get('username');
        $auth = Usr::where("username",$username)->first()->auth;
        return view('keyword_website' ,compact('model','auth'));
    }
    public function keyword_website_add(){
        return view('keyword_website_add');
    }
    public function keyword_website_add1(Request $request){
        if (Input::method() == 'POST') {
            $model = new Website();
            $log = new Syslog();
            $log->operate_type = "添加网页内容关键字：{$request->get('keyword')}";
            $log->username = $request->get('usrname');
            $log->save();
            $result = $model->create($request->all());
            if ($result != false) {
                $result = $this->model_update('website');
            }
            return $result ? '1' : '0';
        }else{
            return view('keyword_website_add');
        }
    }
    public function keyword_website_update(Request $request){
        $id = $request->get('id');
        $model = Website::where("keyword_id",$id)->first();
        return view('keyword_website_update',compact('model'));
    }
    public function keyword_website_update1(Request $request){
        if (Input::method() == 'POST') {
            $id = $request->get('keyword_id');
            $model = Website::find($id);
            $log = new Syslog();
            $log->operate_type = "修改网页内容关键字：{$model->keyword} 为：{$request->get('keyword')}";
            $log->username = Session::get('username');
            $log->save();
            $model->keyword = $request->get('keyword');
            $model->usrname = $request->get('usrname');
            $result = $model->save();
            if ($result != false) {
                $result = $this->model_update('website');
            }
            return $result ? '1' : '0';
        }else{
            return view('keyword_website_update');
        }

    }
    public function keyword_website_delete(Request $request){
        $id = $request->get('id');
        $model = Website::find($id);
        $log = new Syslog();
        $log->operate_type = "删除网页内容关键字：{$model->keyword}";
        $log->username = Session::get('username');
        $log->save();
        $result = $model->delete();
        if ($result != false) {
            $result = $this->model_update('website');
        }
        if($result != false){
            $data = [
                'status' => 0,
                'message' => '删除成功'
            ];
        }else{
            $data = [
                'status' => 1,
                'message' => '删除失败'
            ];
        }
        return $data;
    }
    public function keyword_website_deletes(Request $request){
        for ($i=0; $i<count($request['keys']); $i++) {
            //删除数据库记录
            $model = Website::find($request['keys'][$i]);
            $log = new Syslog();
            $log->operate_type = "删除网页内容关键字：{$model->keyword}";
            $log->username = Session::get('username');
            $log->save();
            $result = $model->delete();
        }
        if ($result != false) {
            $result = $this->model_update('website');
        }
        if($result != false){
            $data = [
                'status' => 0,
                'message' => '删除成功'
            ];
        }else{
            $data = [
                'status' => 1,
                'message' => '删除失败'
            ];
        }
        return $data;
    }

    //ip
    public function ip(){
        $model = Ip::get();
        $username = Session::get('username');
        $auth = Usr::where("username",$username)->first()->auth;
        return view('keyword_ip',compact('model','auth'));
    }
    public function ip_add(){
        return view('keyword_ip_add');
    }
    public function ip_add1(Request $request){
        if (Input::method() == 'POST') {
            $model = new Ip();
            $result = $model->create($request->all());
            $log = new Syslog();
            $log->operate_type = "添加IP关键字：{$request->get('keyword')}";
            $log->username = $request->get('usrname');
            $log->save();
            if ($result != false) {
                $result = $this->model_update('ip');
            }
            return $result ? '1' : '0';
        }else{
            return view('keyword_ip_add');
        }
    }
    public function ip_update(Request $request){
        $id = $request->get('id');
        $model = Ip::find($id);
        return view('keyword_ip_update',compact('model'));
    }
    public function ip_update1(Request $request){
        if (Input::method() == 'POST') {
            $id = $request->get('keyword_id');
            $model = Ip::find($id);
            $log = new Syslog();
            $log->operate_type = "修改IP关键字：{$model->keyword} 为：{$request->get('keyword')}";
            $log->username = Session::get('username');
            $log->save();
            $model->keyword = $request->get('keyword');
            $model->usrname = $request->get('usrname');
            $result = $model->save();
            if ($result != false) {
                $result = $this->model_update('ip');
            }
            return $result ? '1' : '0';
        }else{
            return view('keyword_ip_update');
        }

    }
    public function ip_delete(Request $request){
        $id = $request->get('id');
        $model = Ip::find($id);
        $log = new Syslog();
        $log->operate_type = "删除IP关键字：{$model->keyword}";
        $log->username = Session::get('username');
        $log->save();
        $result = $model->delete();
        if ($result != false) {
            $result = $this->model_update('ip');
        }
        if($result != false){
            $data = [
                'status' => 0,
                'message' => '删除成功'
            ];
        }else{
            $data = [
                'status' => 1,
                'message' => '删除失败'
            ];
        }
        return $data;
    }
    public function ip_deletes(Request $request){
        for ($i=0; $i<count($request['keys']); $i++) {
            //删除数据库记录
            $model = Ip::find($request['keys'][$i]);
            $log = new Syslog();
            $log->operate_type = "删除IP关键字：{$model->keyword}";
            $log->username = Session::get('username');
            $log->save();
            $result = $model->delete();
        }
        if ($result != false) {
            $result = $this->model_update('ip');
        }
        if($result != false){
            $data = [
                'status' => 0,
                'message' => '删除成功'
            ];
        }else{
            $data = [
                'status' => 1,
                'message' => '删除失败'
            ];
        }
        return $data;
    }
//telnet
    public function keyword_telnet(){
        $model = Telnet::get();
        $username = Session::get('username');
        $auth = Usr::where("username",$username)->first()->auth;
        return view('keyword_telnet' ,compact('model','auth'));
    }
    public function keyword_telnet_add(){
        return view('keyword_telnet_add');
    }
    public function keyword_telnet_add1(Request $request){
        if (Input::method() == 'POST') {
            $model = new Telnet();
            $result = $model->create($request->all());
            $log = new Syslog();
            $log->operate_type = "添加TELNET关键字：{$request->get('keyword')}";
            $log->username = $request->get('usrname');
            $log->save();
            if ($result != false) {
                $result = $this->model_update('telnet');
            }
            return $result ? '1' : '0';
        }else{
            return view('keyword_telnet_add');
        }
    }
    public function keyword_telnet_update(Request $request){
        $id = $request->get('id');
        $model = Telnet::find($id);
        return view('keyword_telnet_update',compact('model'));
    }
    public function keyword_telnet_update1(Request $request){
        if (Input::method() == 'POST') {
            $id = $request->get('keyword_id');
            $model = Telnet::find($id);
            $log = new Syslog();
            $log->operate_type = "修改TELNET关键字：{$model->keyword} 为：{$request->get('keyword')}";
            $log->username = Session::get('username');
            $log->save();
            $model->keyword = $request->get('keyword');
            $model->usrname = $request->get('usrname');
            $result = $model->save();
            if ($result != false) {
                $result = $this->model_update('telnet');
            }
            return $result ? '1' : '0';
        }else{
            return view('keyword_telnet_update');
        }

    }
    public function keyword_telnet_delete(Request $request){
        $id = $request->get('id');
        $model = Telnet::find($id);
        $log = new Syslog();
        $log->operate_type = "删除TELNET关键字：{$model->keyword}";
        $log->username = Session::get('username');
        $log->save();
        $result = $model->delete();
        if ($result != false) {
            $result = $this->model_update('telnet');
        }
        if($result != false){
            $data = [
                'status' => 0,
                'message' => '删除成功'
            ];
        }else{
            $data = [
                'status' => 1,
                'message' => '删除失败'
            ];
        }
        return $data;
    }
    public function keyword_telnet_deletes(Request $request){
        for ($i=0; $i<count($request['keys']); $i++) {
            //删除数据库记录
            $model = Telnet::find($request['keys'][$i]);
            $log = new Syslog();
            $log->operate_type = "删除TELNET关键字：{$model->keyword}";
            $log->username = Session::get('username');
            $log->save();
            $result = $model->delete();
        }
        if ($result != false) {
            $result = $this->model_update('telnet');
        }
        if($result != false){
            $data = [
                'status' => 0,
                'message' => '删除成功'
            ];
        }else{
            $data = [
                'status' => 1,
                'message' => '删除失败'
            ];
        }
        return $data;
    }
    //am_message
    public function keyword_am(){
        $model = Am::get();
        $username = Session::get('username');
        $auth = Usr::where("username",$username)->first()->auth;
        return view('keyword_am' ,compact('model','auth'));
    }
    public function keyword_am_add(){
        return view('keyword_am_add');
    }
    public function keyword_am_add1(Request $request){
        if (Input::method() == 'POST') {
            $model = new Am();
            $result = $model->create($request->all());
            $log = new Syslog();
            $log->operate_type = "添加AM消息内容关键字：{$request->get('keyword')}";
            $log->username = $request->get('usrname');
            $log->save();
            if ($result != false) {
                $result = $this->model_update('am_message');
            }
            return $result ? '1' : '0';
        }else{
            return view('keyword_am_add');
        }
    }
    public function keyword_am_update(Request $request){
        $id = $request->get('id');
        $model = Am::find($id);
        return view('keyword_am_update',compact('model'));
    }
    public function keyword_am_update1(Request $request){
        if (Input::method() == 'POST') {
            $id = $request->get('keyword_id');
            $model = Am::find($id);
            $log = new Syslog();
            $log->operate_type = "修改AM消息内容关键字：{$model->keyword} 为：{$request->get('keyword')}";
            $log->username = Session::get('username');
            $log->save();
            $model->keyword = $request->get('keyword');
            $model->usrname = $request->get('usrname');
            $result = $model->save();
            if ($result != false) {
                $result = $this->model_update('am_message');
            }
            return $result ? '1' : '0';
        }else{
            return view('keyword_am_update');
        }

    }
    public function keyword_am_delete(Request $request){
        $id = $request->get('id');
        $model = Am::find($id);
        $log = new Syslog();
        $log->operate_type = "删除AM消息内容关键字：{$model->keyword}";
        $log->username = Session::get('username');
        $log->save();
        $result = $model->delete();
        if ($result != false) {
            $result = $this->model_update('am_message');
        }
        if($result != false){
            $data = [
                'status' => 0,
                'message' => '删除成功'
            ];
        }else{
            $data = [
                'status' => 1,
                'message' => '删除失败'
            ];
        }
        return $data;
    }
    public function keyword_am_deletes(Request $request){
        for ($i=0; $i<count($request['keys']); $i++) {
            //删除数据库记录
            $model = Am::where('keyword_id',$request['keys'][$i])->first();
            $log = new Syslog();
            $log->operate_type = "删除AM消息内容关键字：{$model->keyword}";
            $log->username = Session::get('username');
            $log->save();
            $result = $model->delete();
        }
        if ($result != false) {
            $result = $this->model_update('am_message');
        }
        if($result != false){
            $data = [
                'status' => 0,
                'message' => '删除成功'
            ];
        }else{
            $data = [
                'status' => 1,
                'message' => '删除失败'
            ];
        }
        return $data;
    }
//am_txt
    public function keyword_am_txt(){
        $model = Amtxt::get();
        $username = Session::get('username');
        $auth = Usr::where("username",$username)->first()->auth;
        return view('keyword_am_txt' ,compact('model','auth'));
    }
    public function keyword_am_txt_add(){
        return view('keyword_am_txt_add');
    }
    public function keyword_am_txt_add1(Request $request){
        if (Input::method() == 'POST') {
            $model = new Amtxt();
            $result = $model->create($request->all());
            $log = new Syslog();
            $log->operate_type = "添加AM文本内容关键字：{$request->get('keyword')}";
            $log->username = $request->get('usrname');
            $log->save();
            if ($result != false) {
                $result = $this->model_update('am_txt');
            }
            return $result ? '1' : '0';
        }else{
            return view('keyword_am_txt_add');
        }
    }
    public function keyword_am_txt_update(Request $request){
        $id = $request->get('id');
        $model = Amtxt::find($id);
        return view('keyword_am_txt_update',compact('model'));
    }
    public function keyword_am_txt_update1(Request $request){
        if (Input::method() == 'POST') {
            $id = $request->get('keyword_id');
            $model = Amtxt::find($id);
            $log = new Syslog();
            $log->operate_type = "修改AM文本内容关键字：{$model->keyword} 为：{$request->get('keyword')}";
            $log->username = Session::get('username');
            $log->save();
            $model->keyword = $request->get('keyword');
            $model->usrname = $request->get('usrname');
            $result = $model->save();
            if ($result != false) {
                $result = $this->model_update('am_txt');
            }
            return $result ? '1' : '0';
        }else{
            return view('keyword_am_txt_update');
        }

    }
    public function keyword_am_txt_delete(Request $request){
        $id = $request->get('id');
        $model = Amtxt::find($id);
        $log = new Syslog();
        $log->operate_type = "删除AM文本内容关键字：{$model->keyword}";
        $log->username = Session::get('username');
        $log->save();
        $result = $model->delete();
        if ($result != false) {
            $result = $this->model_update('am_txt');
        }
        if($result != false){
            $data = [
                'status' => 0,
                'message' => '删除成功'
            ];
        }else{
            $data = [
                'status' => 1,
                'message' => '删除失败'
            ];
        }
        return $data;
    }
    public function keyword_am_txt_deletes(Request $request){
        for ($i=0; $i<count($request['keys']); $i++) {
            //删除数据库记录
            $model = Amtxt::find($request['keys'][$i]);
            $log = new Syslog();
            $log->operate_type = "删除AM文本关键字：{$model->keyword}";
            $log->username = Session::get('username');
            $log->save();
            $result = $model->delete();
        }
        if ($result != false) {
            $result = $this->model_update('am_txt');
        }
        if($result != false){
            $data = [
                'status' => 0,
                'message' => '删除成功'
            ];
        }else{
            $data = [
                'status' => 1,
                'message' => '删除失败'
            ];
        }
        return $data;
    }
//dns
    public function keyword_dns(){
        $model = Dns::get();
        $username = Session::get('username');
        $auth = Usr::where("username",$username)->first()->auth;
        return view('keyword_dns' ,compact('model','auth'));
    }
    public function keyword_dns_add(){
        return view('keyword_dns_add');
    }
    public function keyword_dns_add1(Request $request){
        if (Input::method() == 'POST') {
            $model = new Dns();
            $result = $model->create($request->all());
            $log = new Syslog();
            $log1 = new Syslog();
            $log->operate_type = "添加域名关键字：{$request->get('keyword')}";
            $log1->operate_type = "添加欺骗IP:{$request->get('cheat_ip')}";
            $log->username = $request->get('usrname');
            $log1->username = $request->get('usrname');
            $log->save();
            $log1->save();
            if ($result != false) {
                $result = $this->model_update('dns_update');
            }
            return $result ? '1' : '0';
        }else{
            return view('keyword_dns_add');
        }
    }
    public function keyword_dns_update(Request $request){
        $id = $request->get('id');
        $model = Dns::find($id);
        return view('keyword_dns_update',compact('model'));
    }
    public function keyword_dns_update1(Request $request){
        if (Input::method() == 'POST') {
            $id = $request->get('keyword_id');
            $model = Dns::find($id);
            $log = new Syslog();
            $log->operate_type = "修改域名关键字：{$model->keyword} 为：{$request->get('keyword')}";
            $log->username = Session::get('username');
            $log->save();
            $log1 = new Syslog();
            $log1->operate_type = "修改欺骗IP：{$model->cheat_ip} 为：{$request->get('cheat_ip')}";
            $log1->username = Session::get('username');
            $log1->save();
            $model->keyword = $request->get('keyword');
            $model->usrname = $request->get('usrname');
            $model->cheat_ip = $request->get('cheat_ip');
            $result = $model->save();
            if ($result != false) {
                $result = $this->model_update('dns_update');
            }
            return $result ? '1' : '0';
        }else{
            return view('keyword_dns_update');
        }

    }
    public function keyword_dns_delete(Request $request){
        $id = $request->get('id');
        $model = Dns::find($id);
        $log = new Syslog();
        $log->operate_type = "删除域名关键字：{$model->keyword}";
        $log->username = Session::get('username');
        $log->save();
        $log1 = new Syslog();
        $log1->operate_type = "删除欺骗IP：{$model->cheat_ip}";
        $log1->username = Session::get('username');
        $log1->save();
        $result = $model->delete();
        if ($result != false) {
            $result = $this->model_update('dns_update');
        }
        if($result != false){
            $data = [
                'status' => 0,
                'message' => '删除成功'
            ];
        }else{
            $data = [
                'status' => 1,
                'message' => '删除失败'
            ];
        }
        return $data;
    }
    public function keyword_dns_deletes(Request $request){
        for ($i=0; $i<count($request['keys']); $i++) {
            //删除数据库记录
            $model = Dns::find($request['keys'][$i]);
            $log = new Syslog();
            $log->operate_type = "删除域名关键字：{$model->keyword}";
            $log->username = Session::get('username');
            $log->save();
            $log1 = new Syslog();
            $log1->operate_type = "删除欺骗IP：{$model->cheat_ip}";
            $log1->username = Session::get('username');
            $log1->save();
            $result = $model->delete();
        }
        if ($result != false) {
            $result = $this->model_update('dns_update');
        }
        if($result != false){
            $data = [
                'status' => 0,
                'message' => '删除成功'
            ];
        }else{
            $data = [
                'status' => 1,
                'message' => '删除失败'
            ];
        }
        return $data;
    }

//ftp
    public function keyword_ftp(){
        $model = Ftp::get();
        $username = Session::get('username');
        $auth = Usr::where("username",$username)->first()->auth;
        return view('keyword_ftp' ,compact('model','auth'));
    }
    public function keyword_ftp_add(){
        return view('keyword_ftp_add');
    }
    public function keyword_ftp_add1(Request $request){
        if (Input::method() == 'POST') {
            $model = new Ftp();
            $result = $model->create($request->all());
            $log = new Syslog();
            $log->operate_type = "添加FTP文本内容关键字：{$request->get('keyword')}";
            $log->username = $request->get('usrname');
            $log->save();
            if ($result != false) {
                $result = $this->model_update('ftp_update');
            }
            return $result ? '1' : '0';
        }else{
            return view('keyword_ftp_add');
        }
    }
    public function keyword_ftp_update(Request $request){
        $id = $request->get('id');
        $model = Ftp::find($id);
        return view('keyword_ftp_update',compact('model'));
    }
    public function keyword_ftp_update1(Request $request){
        if (Input::method() == 'POST') {
            $id = $request->get('keyword_id');
            $model = Ftp::find($id);
            $log = new Syslog();
            $log->operate_type = "修改FTP文本内容关键字：{$model->keyword} 为：{$request->get('keyword')}";
            $log->username = Session::get('username');
            $log->save();
            $model->keyword = $request->get('keyword');
            $model->usrname = $request->get('usrname');
            $result = $model->save();
            if ($result != false) {
                $result = $this->model_update('ftp_update');
            }
            return $result ? '1' : '0';
        }else{
            return view('keyword_ftp_update');
        }

    }
    public function keyword_ftp_delete(Request $request){
        $id = $request->get('id');
        $model = Ftp::find($id);
        $log = new Syslog();
        $log->operate_type = "删除FTP文本内容关键字：{$model->keyword}";
        $log->username = Session::get('username');
        $log->save();
        $result = $model->delete();
        if ($result != false) {
            $result = $this->model_update('ftp_update');
        }
        if($result != false){
            $data = [
                'status' => 0,
                'message' => '删除成功'
            ];
        }else{
            $data = [
                'status' => 1,
                'message' => '删除失败'
            ];
        }
        return $data;
    }
    public function keyword_ftp_deletes(Request $request){
        for ($i=0; $i<count($request['keys']); $i++) {
            //删除数据库记录
            $model = Ftp::find($request['keys'][$i]);
            $log = new Syslog();
            $log->operate_type = "删除FTP文本内容关键字：{$model->keyword}";
            $log->username = Session::get('username');
            $log->save();
            $result = $model->delete();
        }
        if ($result != false) {
            $result = $this->model_update('ftp_update');
        }
        if($result != false){
            $data = [
                'status' => 0,
                'message' => '删除成功'
            ];
        }else{
            $data = [
                'status' => 1,
                'message' => '删除失败'
            ];
        }
        return $data;
    }

//url
    public function keyword_url(){
        $model = Url::get();
        $username = Session::get('username');
        $auth = Usr::where("username",$username)->first()->auth;
        return view('keyword_url' ,compact('model','auth'));
    }
    public function keyword_url_add(){
        return view('keyword_url_add');
    }
    public function keyword_url_add1(Request $request){
        if (Input::method() == 'POST') {
            $model = new Url();
            $result = $model->create($request->all());
            $model->usrname = $request->get('usrname');
            $log = new Syslog();
            $log->operate_type = "添加URL关键字：{$request->get('keyword')}";
            $log->username = $request->get('usrname');
            $log->save();
            if ($result != false) {
                $result = $this->model_update('url_update');
            }
            return $result ? '1' : '0';
        }else{
            return view('keyword_url_add');
        }
    }
    public function keyword_url_update(Request $request){
        $id = $request->get('id');
        $model = Url::find($id);
        return view('keyword_url_update',compact('model'));
    }
    public function keyword_url_update1(Request $request){
        if (Input::method() == 'POST') {
            $id = $request->get('keyword_id');
            $model = Url::find($id);
            $log = new Syslog();
            $log->operate_type = "修改URL关键字：{$model->keyword} 为：{$request->get('keyword')}";
            $log->username = Session::get('username');
            $log->save();
            $model->keyword = $request->get('keyword');
            $model->usrname = $request->get('usrname');
            $result = $model->save();
            if ($result != false) {
                $result = $this->model_update('url_update');
            }
            return $result ? '1' : '0';
        }else{
            return view('keyword_url_update');
        }

    }
    public function keyword_url_delete(Request $request){
        $id = $request->get('id');
        $model = Url::find($id);
        $log = new Syslog();
        $log->operate_type = "删除URL关键字：{$model->keyword}";
        $log->username = Session::get('username');
        $log->save();
        $result = $model->delete();
        if ($result != false) {
            $result = $this->model_update('url_update');
        }
        if($result != false){
            $data = [
                'status' => 0,
                'message' => '删除成功'
            ];
        }else{
            $data = [
                'status' => 1,
                'message' => '删除失败'
            ];
        }
        return $data;
    }
    public function keyword_url_deletes(Request $request){
        for ($i=0; $i<count($request['keys']); $i++) {
            //删除数据库记录
            $model = Url::find($request['keys'][$i]);
            $log = new Syslog();
            $log->operate_type = "删除URL关键字：{$model->keyword}";
            $log->username = Session::get('username');
            $log->save();
            $result = $model->delete();
        }
        if ($result != false) {
            $result = $this->model_update('url_update');
        }
        if($result != false){
            $data = [
                'status' => 0,
                'message' => '删除成功'
            ];
        }else{
            $data = [
                'status' => 1,
                'message' => '删除失败'
            ];
        }
        return $data;
    }

    public function diary_ac(){
        $model = Aichanglog::get();
        return view('diary_ac',compact('model'));
    }
    public function diary_am(){
        $model = Amlog::get();
        return view('diary_am',compact('model'));
    }
    public function diary_am_txt(){
        $model = Amtxtlog::get();
        return view('diary_am_txt',compact('model'));
    }
    public function diary_dns(){
        $model = Dnslog::get();
        return view('diary_dns' ,compact('model'));
    }
    public function diary_file(){
        $model = File::get();
        return view('diary_file' ,compact('model'));
    }
    public function model_update($id){
        $socket_dest="192.168.103.93";
        $port=8002;
        $socket=socket_create(AF_INET,SOCK_STREAM,SOL_TCP)or die("创建失败");
        $connection=socket_connect($socket,$socket_dest,$port)or die("链接错误");
        $result = socket_write($socket,$id);
        return $result;
    }
    public function download(Request $request){
        $id = $request->get('id');
        //$filepath = File::find($id) -> addr;
        $filename = File::find($id) -> filename;
       // $filename=iconv('utf-8','gbk',$filename);
        $suffix = File::find($id) -> suffix;
        $curl = curl_init();
        //设置被下载文件的url
        curl_setopt($curl, CURLOPT_URL,"ftp://192.168.103.93/$filename.$suffix");
        //设置返回信息中不包含响应头信息
        curl_setopt($curl, CURLOPT_HEADER,0);
        //设置执行之后的结果不直接打印出来
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
     //   设置下载ftp服务器上的文件的相关参数
        //设置下载超时终止时间,单位是秒
        curl_setopt($curl,CURLOPT_TIMEOUT,300);
        //设置连接ftp服务器的用户名密码
        curl_setopt($curl, CURLOPT_USERPWD, 'ftp1'.':'.'12345');
        //设置下载文件保存到本地的文件名
        $filename=iconv('utf-8','gbk',$filename);
        $downfile = fopen("D:\\filesave\\$filename.$suffix",'wb');
        curl_setopt($curl,CURLOPT_FILE,$downfile);
        //执行
        $output = curl_exec($curl);
        curl_close($curl);
        if($output != false){
            $data = [
                'status' => 0,
                'message' => '文件保存到D盘filesave夹下'
            ];
        }else{
            $data = [
                'status' => 1,
                'message' => '下载失败'
            ];
        }
        return $data;
    }
    public function diary_search(Request $request){
        $datemin = $request->get('datemin');
        $datemax = $request->get('datemax');
        $id = $request->get('log_id');
        $saddr = $request->get('saddr');
        $sport = $request->get('sport');
        $daddr = $request->get('daddr');
        $dport = $request->get('dport');
        $keyword = $request->get('keyword');
        $table = $request->get('table');
        switch ($table) {
            case 1 :
                $model = File::get();
                $suffix = $request->get('suffix');
                if($datemax != NULL){ $model = $model -> where('log_time', '<', $datemax);}
                if($datemin != NULL){ $model = $model -> where('log_time', '>', $datemin); }
                if($id != NULL){$model = $model -> where('keyword_id', '=', $id); }
                if($keyword != NULL){$model = $model -> where('filename', $keyword); }
                if($suffix != NULL){$model = $model -> where('suffix', $suffix); }
                if($saddr != NULL){$model = $model -> where('saddr', '=', $saddr); }
                if($sport != NULL){$model = $model -> where('sport', '=', $sport); }
                if($daddr != NULL){$model = $model -> where('daddr', '=', $daddr); }
                if($dport != NULL){$model = $model -> where('dport', '=', $dport); }
                return view('diary_file', compact('model'));
            case 2:
                 $model = Syslog::get();
                if($datemax != NULL){ $model = $model -> where('log_time', '<', $datemax);}
                if($datemin != NULL){ $model = $model -> where('log_time', '>', $datemin); }
                if($id != NULL){$model = $model -> where('log_id', '=', $id); }
                if($saddr != NULL){$model = $model -> where('username', '=', $saddr); }
                if($daddr != NULL){$model = $model -> where('operate_type', '=', $daddr); }
                return view('diary_system', compact('model'));
            case 3:
                $model = Weblog::get();
                if($datemax != NULL){ $model = $model -> where('log_time', '<', $datemax);}
                if($datemin != NULL){ $model = $model -> where('log_time', '>', $datemin); }
                if($id != NULL){$model = $model -> where('log_id', '=', $id); }
                if($keyword != NULL){$model = $model -> where('keyword', $keyword); }
                if($saddr != NULL){$model = $model -> where('saddr', '=', $saddr); }
                if($sport != NULL){$model = $model -> where('sport', '=', $sport); }
                if($daddr != NULL){$model = $model -> where('daddr', '=', $daddr); }
                if($dport != NULL){$model = $model -> where('dport', '=', $dport); }
                return view('diary_website', compact('model'));
            case 4:
                $model = Iplog::get();
                if($datemax != NULL){ $model = $model -> where('log_time', '<', $datemax);}
                if($datemin != NULL){ $model = $model -> where('log_time', '>', $datemin); }
                if($id != NULL){$model = $model -> where('log_id', '=', $id); }
                if($keyword != NULL){$model = $model -> where('keyword', $keyword); }
                if($saddr != NULL){$model = $model -> where('saddr', '=', $saddr); }
                if($sport != NULL){$model = $model -> where('sport', '=', $sport); }
                if($daddr != NULL){$model = $model -> where('daddr', '=', $daddr); }
                if($dport != NULL){$model = $model -> where('dport', '=', $dport); }
                return view('diary_ip', compact('model'));
            case 5:
                $model = Urllog::get();
                if($datemax != NULL){ $model = $model -> where('log_time', '<', $datemax);}
                if($datemin != NULL){ $model = $model -> where('log_time', '>', $datemin); }
                if($id != NULL){$model = $model -> where('log_id', '=', $id); }
                if($keyword != NULL){$model = $model -> where('keyword', $keyword); }
                if($saddr != NULL){$model = $model -> where('saddr', '=', $saddr); }
                if($sport != NULL){$model = $model -> where('sport', '=', $sport); }
                if($daddr != NULL){$model = $model -> where('daddr', '=', $daddr); }
                if($dport != NULL){$model = $model -> where('dport', '=', $dport); }
                return view('diary_url', compact('model'));
            case 6:
                $model = Ftplog::get();
                if($datemax != NULL){ $model = $model -> where('log_time', '<', $datemax);}
                if($datemin != NULL){ $model = $model -> where('log_time', '>', $datemin); }
                if($id != NULL){$model = $model -> where('log_id', '=', $id); }
                if($keyword != NULL){$model = $model -> where('keyword', $keyword); }
                if($saddr != NULL){$model = $model -> where('saddr', '=', $saddr); }
                if($sport != NULL){$model = $model -> where('sport', '=', $sport); }
                if($daddr != NULL){$model = $model -> where('daddr', '=', $daddr); }
                if($dport != NULL){$model = $model -> where('dport', '=', $dport); }
                return view('diary_ftp', compact('model'));
            case 7:
                $model = Dnslog::get();
                $cheat_ip = $request->get('cheat_ip');
                if($datemax != NULL){ $model = $model -> where('log_time', '<', $datemax);}
                if($datemin != NULL){ $model = $model -> where('log_time', '>', $datemin); }
                if($id != NULL){$model = $model -> where('log_id', '=', $id); }
                if($keyword != NULL){$model = $model -> where('keyword', $keyword); }
                if($cheat_ip != NULL){$model = $model -> where('cheat_ip', $cheat_ip); }
                if($saddr != NULL){$model = $model -> where('saddr', '=', $saddr); }
                if($sport != NULL){$model = $model -> where('sport', '=', $sport); }
                if($daddr != NULL){$model = $model -> where('daddr', '=', $daddr); }
                if($dport != NULL){$model = $model -> where('dport', '=', $dport); }
                return view('diary_dns', compact('model'));
            case 8:
                $model = Telnetlog::get();
                if($datemax != NULL){ $model = $model -> where('log_time', '<', $datemax);}
                if($datemin != NULL){ $model = $model -> where('log_time', '>', $datemin); }
                if($id != NULL){$model = $model -> where('log_id', '=', $id); }
                if($keyword != NULL){$model = $model -> where('keyword', $keyword); }
                if($saddr != NULL){$model = $model -> where('saddr', '=', $saddr); }
                if($sport != NULL){$model = $model -> where('sport', '=', $sport); }
                if($daddr != NULL){$model = $model -> where('daddr', '=', $daddr); }
                if($dport != NULL){$model = $model -> where('dport', '=', $dport); }
                return view('diary_telnet', compact('model'));
            case 9:
                $model = Amtxtlog::get();
                if($datemax != NULL){ $model = $model -> where('log_time', '<', $datemax);}
                if($datemin != NULL){ $model = $model -> where('log_time', '>', $datemin); }
                if($id != NULL){$model = $model -> where('log_id', '=', $id); }
                if($keyword != NULL){$model = $model -> where('keyword', $keyword); }
                if($saddr != NULL){$model = $model -> where('saddr', '=', $saddr); }
                if($sport != NULL){$model = $model -> where('sport', '=', $sport); }
                if($daddr != NULL){$model = $model -> where('daddr', '=', $daddr); }
                if($dport != NULL){$model = $model -> where('dport', '=', $dport); }
                return view('diary_am_txt', compact('model'));
            case 10:
                $model = Amlog::get();
                if($datemax != NULL){ $model = $model -> where('log_time', '<', $datemax);}
                if($datemin != NULL){ $model = $model -> where('log_time', '>', $datemin); }
                if($id != NULL){$model = $model -> where('log_id', '=', $id); }
                if($keyword != NULL){$model = $model -> where('keyword', $keyword); }
                if($saddr != NULL){$model = $model -> where('saddr', '=', $saddr); }
                if($sport != NULL){$model = $model -> where('sport', '=', $sport); }
                if($daddr != NULL){$model = $model -> where('daddr', '=', $daddr); }
                if($dport != NULL){$model = $model -> where('dport', '=', $dport); }
                return view('diary_am', compact('model'));
            case 11:
                $model = Aichanglog::get();
                if($datemax != NULL){ $model = $model -> where('log_time', '<', $datemax);}
                if($datemin != NULL){ $model = $model -> where('log_time', '>', $datemin); }
                if($id != NULL){$model = $model -> where('log_id', '=', $id); }
                if($keyword != NULL){$model = $model -> where('keyword', $keyword); }
                if($saddr != NULL){$model = $model -> where('saddr', '=', $saddr); }
                if($sport != NULL){$model = $model -> where('sport', '=', $sport); }
                if($daddr != NULL){$model = $model -> where('daddr', '=', $daddr); }
                if($dport != NULL){$model = $model -> where('dport', '=', $dport); }
                return view('diary_ac', compact('model'));
        }
    }
    public function diary_ftp(){
        $model = Ftplog::get();
        return view('diary_ftp',compact('model'));
    }
    public function diary_ip(){
        $model = Iplog::get();
        return view('diary_ip',compact('model'));
    }
    public function diary_system(){
        $model = Syslog::get();
        return view('diary_system' ,compact('model'));
    }
    public function diary_telnet(){
        $model = Telnetlog::get();
        return view('diary_telnet',compact('model'));
    }
    public function diary_url(){
        $model = Urllog::get();
        return view('diary_url' ,compact('model'));
    }
    public function diary_website(){
        $model = Weblog::get();
        return view('diary_website',compact('model'));
    }
    public function diary_export(Request $request){
        $table = $request->get('id');
        switch ($table) {
            case 1 :
                $cellData = [
                    ['时间','AM消息内容关键字','源地址','源端口','目的地址','目的端口']
                ];
                $data = Amlog::all();
                foreach ($data as $key => $value){
                    $cellData[] = [
                        $value -> log_time, $value -> keyword, $value -> saddr, $value -> sport, $value -> daddr, $value -> dport,
                    ];
                }
                Excel::create('AM消息内容监测日志',function($excel) use ($cellData){
                    $excel->sheet('AM消息内容监测日志', function($sheet) use ($cellData){
                        $sheet->rows($cellData);
                    });
                })->export('xls');
                break;
            case 2:
                $cellData = [
                    ['时间','文件名','后缀','源地址','源端口','目的地址','目的端口']
                ];
                $data = File::all();
                foreach ($data as $key => $value){
                    $cellData[] = [
                        $value -> log_time, $value -> filename, $value -> suffix, $value -> saddr, $value -> sport, $value -> daddr, $value -> dport,
                    ];
                }
                Excel::create('保存文件日志',function($excel) use ($cellData){
                    $excel->sheet('保存文件日志', function($sheet) use ($cellData){
                        $sheet->rows($cellData);
                    });
                })->export('xls');
                break;
            case 3:
                $cellData = [
                    ['时间','爱唱消息内容关键字','源地址','源端口','目的地址','目的端口']
                ];
                $data = Aichanglog::all();
                foreach ($data as $key => $value){
                    $cellData[] = [
                        $value -> log_time, $value -> keyword, $value -> saddr, $value -> sport, $value -> daddr, $value -> dport,
                    ];
                }
                Excel::create('爱唱消息内容监测日志',function($excel) use ($cellData){
                    $excel->sheet('爱唱消息内容监测日志', function($sheet) use ($cellData){
                        $sheet->rows($cellData);
                    });
                })->export('xls');
                break;
            case 4:
                $cellData = [
                    ['时间','AM文本内容关键字','源地址','源端口','目的地址','目的端口']
                ];
                $data = Amtxtlog::all();
                foreach ($data as $key => $value){
                    $cellData[] = [
                        $value -> log_time, $value -> keyword, $value -> saddr, $value -> sport, $value -> daddr, $value -> dport,
                    ];
                }
                Excel::create('AM文本内容监测日志',function($excel) use ($cellData){
                    $excel->sheet('AM文本内容监测日志', function($sheet) use ($cellData){
                        $sheet->rows($cellData);
                    });
                })->export('xls');
                break;
            case 5:
                $cellData = [
                    ['时间','FTP文本内容关键字','源地址','源端口','目的地址','目的端口']
                ];
                $data = Ftplog::all();
                foreach ($data as $key => $value){
                    $cellData[] = [
                        $value -> log_time, $value -> keyword, $value -> saddr, $value -> sport, $value -> daddr, $value -> dport,
                    ];
                }
                Excel::create('FTP文本内容监测日志',function($excel) use ($cellData){
                    $excel->sheet('FTP文本内容监测日志', function($sheet) use ($cellData){
                        $sheet->rows($cellData);
                    });
                })->export('xls');
                break;
            case 6:
                $cellData = [
                    ['时间','IP关键字','源地址','源端口','目的地址','目的端口']
                ];
                $data = Iplog::all();
                foreach ($data as $key => $value){
                    $cellData[] = [
                        $value -> log_time, $value -> keyword, $value -> saddr, $value -> sport, $value -> daddr, $value -> dport,
                    ];
                }
                Excel::create('IP封堵日志',function($excel) use ($cellData){
                    $excel->sheet('IP封堵日志', function($sheet) use ($cellData){
                        $sheet->rows($cellData);
                    });
                })->export('xls');
                break;
            case 7:
                $cellData = [
                    ['时间','Telnet关键字','源地址','源端口','目的地址','目的端口']
                ];
                $data = Telnetlog::all();
                foreach ($data as $key => $value){
                    $cellData[] = [
                        $value -> log_time, $value -> keyword, $value -> saddr, $value -> sport, $value -> daddr, $value -> dport,
                    ];
                }
                Excel::create('Telnet封堵日志',function($excel) use ($cellData){
                    $excel->sheet('Telnet封堵日志', function($sheet) use ($cellData){
                        $sheet->rows($cellData);
                    });
                })->export('xls');
                break;
            case 8:
                $cellData = [
                    ['时间','Url关键字','源地址','源端口','目的地址','目的端口']
                ];
                $data = Urllog::all();
                foreach ($data as $key => $value){
                    $cellData[] = [
                        $value -> log_time, $value -> keyword, $value -> saddr, $value -> sport, $value -> daddr, $value -> dport,
                    ];
                }
                Excel::create('Url封堵日志',function($excel) use ($cellData){
                    $excel->sheet('Url封堵日志', function($sheet) use ($cellData){
                        $sheet->rows($cellData);
                    });
                })->export('xls');
                break;
            case 9:
                $cellData = [
                    ['时间','网页内容关键字','源地址','源端口','目的地址','目的端口']
                ];
                $data = Weblog::all();
                foreach ($data as $key => $value){
                    $cellData[] = [
                        $value -> log_time, $value -> keyword, $value -> saddr, $value -> sport, $value -> daddr, $value -> dport,
                    ];
                }
                Excel::create('网页内容监测日志',function($excel) use ($cellData){
                    $excel->sheet('网页内容监测日志', function($sheet) use ($cellData){
                        $sheet->rows($cellData);
                    });
                })->export('xls');
                break;
            case 10:
                $cellData = [
                    ['时间','请求域名','欺骗地址','源地址','源端口','目的地址','目的端口']
                ];
                $data = Dnslog::all();
                foreach ($data as $key => $value){
                    $cellData[] = [
                        $value -> log_time, $value -> keyword,$value -> cheat_addr, $value -> saddr, $value -> sport, $value -> daddr, $value -> dport,
                    ];
                }
                Excel::create('域名监测日志',function($excel) use ($cellData){
                    $excel->sheet('域名监测日志', function($sheet) use ($cellData){
                        $sheet->rows($cellData);
                    });
                })->export('xls');
                break;
            case 11:
                $cellData = [
                    ['时间','用户','操作']
                ];
                $data = Syslog::all();
                foreach ($data as $key => $value){
                    $cellData[] = [
                        $value -> created_at, $value -> username,$value -> operate_type,
                    ];
                }
                Excel::create('系统操作日志',function($excel) use ($cellData){
                    $excel->sheet('系统操作日志', function($sheet) use ($cellData){
                        $sheet->rows($cellData);
                    });
                })->export('xls');
                break;
        }
    }

}
