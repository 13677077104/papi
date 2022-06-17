<?php

return [

    // WeChat oauth
    ['GET', '/oauth/login', 'Login_Wechat.getRedirectUrl'],
    ['GET', '/user/info', 'Login_Wechat.getUserInfo'],

    // -------------------------------------------------
    ['GET', '/user/id', 'Login_Wechat.getUserId'],
    ['GET', '/user/bb', 'Login_Wechat.bb'],


    ['GET', '/site/index', 'Site.Index'],
    ['GET', '/examples/curd/get/{id:\d}', 'Examples_CURD.Get'],
];