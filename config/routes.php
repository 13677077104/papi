<?php

return [

    // WeChat oauth
    ['GET', '/oauth/get-redirect-url', 'Login_Wechat.getRedirectUrl'],
    ['GET', '/oauth/callback', 'Login_Wechat.callback'],
    ['GET', '/oauth/token', 'Login_Wechat.getToken'],

    ['GET', '/user/info', 'User_Info.code'],

    // 公众号，查询天数
    ['GET', '/baby/get-week', 'Baby_Baby.getWeek'],



    // ['GET', '/site/index', 'Site.Index'],
    // ['GET', '/examples/curd/get/{id:\d}', 'Examples_CURD.Get'],

    // ----admin-------------------------------------------------
    // ['GET', 'portal/admin', 'Portal.Admin.login'],

];