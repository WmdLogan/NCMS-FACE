<?php
//用户管理
Route::any('/auth','TestController@auth');
//增加权限
Route::any('/add_auth','TestController@add_auth');



Route::any('/system','TestController@system');
Route::any('/start','TestController@start');
Route::any('/login','TestController@login');
Route::any('/welcome','TestController@welcome');
Route::any('/index','TestController@index');


Route::any('/signup','TestController@signup');
Route::any('/usr_add','TestController@usr_add');
Route::any('/change_password','TestController@change_password');
Route::any('/update_password','TestController@update_password');

Route::any('/keyword_aichang','TestController@keyword_aichang');
Route::any('/keyword_aichang_add','TestController@keyword_aichang_add');
Route::any('/keyword_aichang_add1','TestController@keyword_aichang_add1');
Route::any('/keyword_aichang_update','TestController@keyword_aichang_update');
Route::any('/keyword_aichang_update1','TestController@keyword_aichang_update1');
Route::any('/keyword_aichang_delete','TestController@keyword_aichang_delete');
Route::any('/keyword_aichang_deletes','TestController@keyword_aichang_deletes');

//网页内容关键字
Route::any('/keyword_website','TestController@keyword_website');
Route::any('/keyword_website_add','TestController@keyword_website_add');
Route::any('/keyword_website_add1','TestController@keyword_website_add1');
Route::any('/keyword_website_update','TestController@keyword_website_update');
Route::any('/keyword_website_update1','TestController@keyword_website_update1');
Route::any('keyword_website_delete','TestController@keyword_website_delete');
Route::any('keyword_website_deletes','TestController@keyword_website_deletes');
//IP关键字
Route::any('/ip','TestController@ip');
Route::any('/ip_add','TestController@ip_add');
Route::any('/ip_add1','TestController@ip_add1');
Route::any('/ip_update','TestController@ip_update');
Route::any('/ip_update1','TestController@ip_update1');
Route::any('/ip_delete','TestController@ip_delete');
Route::any('/ip_deletes','TestController@ip_deletes');
//AM消息关键字
Route::any('/keyword_am','TestController@keyword_am');
Route::any('/keyword_am_add','TestController@keyword_am_add');
Route::any('/keyword_am_add1','TestController@keyword_am_add1');
Route::any('/keyword_am_update','TestController@keyword_am_update');
Route::any('/keyword_am_update1','TestController@keyword_am_update1');
Route::any('/keyword_am_delete','TestController@keyword_am_delete');
Route::any('/keyword_am_deletes','TestController@keyword_am_deletes');

//AM文本关键字
Route::any('/keyword_am_txt','TestController@keyword_am_txt');
Route::any('/keyword_am_txt_add','TestController@keyword_am_txt_add');
Route::any('/keyword_am_txt_add1','TestController@keyword_am_txt_add1');
Route::any('/keyword_am_txt_update','TestController@keyword_am_txt_update');
Route::any('/keyword_am_txt_update1','TestController@keyword_am_txt_update1');
Route::any('/keyword_am_txt_delete','TestController@keyword_am_txt_delete');
Route::any('/keyword_am_txt_deletes','TestController@keyword_am_txt_deletes');

//Telnet关键字
Route::any('/keyword_telnet','TestController@keyword_telnet');
Route::any('/keyword_telnet_add','TestController@keyword_telnet_add');
Route::any('/keyword_telnet_add1','TestController@keyword_telnet_add1');\
Route::any('/keyword_telnet_update','TestController@keyword_telnet_update');
Route::any('/keyword_telnet_update1','TestController@keyword_telnet_update1');
Route::any('/keyword_telnet_delete','TestController@keyword_telnet_delete');
Route::any('/keyword_telnet_deletes','TestController@keyword_telnet_deletes');

//dns关键字
Route::any('/keyword_dns','TestController@keyword_dns');
Route::any('/keyword_dns_add','TestController@keyword_dns_add');
Route::any('/keyword_dns_add1','TestController@keyword_dns_add1');
Route::any('/keyword_dns_update','TestController@keyword_dns_update');
Route::any('/keyword_dns_update1','TestController@keyword_dns_update1');
Route::any('/keyword_dns_delete','TestController@keyword_dns_delete');
Route::any('/keyword_dns_deletes','TestController@keyword_dns_deletes');
Route::any('/keyword_dns_deletes','TestController@keyword_dns_deletes');

//ftp关键字
Route::any('/keyword_ftp','TestController@keyword_ftp');
Route::any('/keyword_ftp_add','TestController@keyword_ftp_add');
Route::any('/keyword_ftp_add1','TestController@keyword_ftp_add1');
Route::any('/keyword_ftp_update','TestController@keyword_ftp_update');
Route::any('/keyword_ftp_update1','TestController@keyword_ftp_update1');
Route::any('/keyword_ftp_delete','TestController@keyword_ftp_delete');
Route::any('/keyword_ftp_deletes','TestController@keyword_ftp_deletes');

//url关键字
Route::any('/keyword_url','TestController@keyword_url');
Route::any('/keyword_url_add','TestController@keyword_url_add');
Route::any('/keyword_url_add1','TestController@keyword_url_add1');
Route::any('/keyword_url_update','TestController@keyword_url_update');
Route::any('/keyword_url_update1','TestController@keyword_url_update1');
Route::any('/keyword_url_delete','TestController@keyword_url_delete');
Route::any('/keyword_url_deletes','TestController@keyword_url_deletes');

//日志
Route::any('/diary_ac','TestController@diary_ac');
Route::any('/diary_am','TestController@diary_am');
Route::any('/diary_am_txt','TestController@diary_am_txt');
Route::any('/diary_dns','TestController@diary_dns');
Route::any('/diary_file','TestController@diary_file');
Route::any('/download','TestController@download');
Route::any('/diary_search','TestController@diary_search');
Route::any('/diary_ftp','TestController@diary_ftp');
Route::any('/diary_ip','TestController@diary_ip');
Route::any('/diary_system','TestController@diary_system');
Route::any('/diary_telnet','TestController@diary_telnet');
Route::any('/diary_url','TestController@diary_url');
Route::any('/diary_website','TestController@diary_website');
Route::any('/diary_export','TestController@diary_export');