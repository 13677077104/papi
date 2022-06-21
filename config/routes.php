<?php

return [

    // WeChat oauth
    ['GET', '/oauth/get-redirect-url', 'Login_Wechat.getRedirectUrl'],
    ['GET', '/oauth/callback', 'Login_Wechat.callback'],
    ['GET', '/oauth/token', 'Login_Wechat.getToken'],

    // -------------------------------------------------
    ['GET', '/user/info', 'User_Info.code'],

    // ['GET', '/site/index', 'Site.Index'],
    // ['GET', '/examples/curd/get/{id:\d}', 'Examples_CURD.Get'],
];