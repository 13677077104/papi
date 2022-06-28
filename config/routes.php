<?php

$adminNamespace = "Admin.";

$api =  [

    // WeChat oauth , 个人订阅号用不上h5授权。
    ['GET', '/oauth/get-redirect-url', 'Login_Wechat.getRedirectUrl'],
    ['GET', '/oauth/callback', 'Login_Wechat.callback'],
    ['GET', '/oauth/token', 'Login_Wechat.getToken'],

    //applet oauth
    ['GET', '/oauth/applet', 'Login_Applet.getAccessToken'],




    ['GET', '/user/info', 'User_Info.code'],

    // 公众号，查询天数
    ['GET', '/baby/get-week', 'Baby_Baby.getWeek'],

];

$admin = [
    // 测试接口
    ['GET', '/admin/get-info', 'User_User.getInfo'],


];
$admin = array_map(function ($route) use ($adminNamespace) {
    $route[2] = $adminNamespace . $route[2];
    return $route;
}, $admin);

return array_merge($api, $admin);