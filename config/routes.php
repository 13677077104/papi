<?php

return [

    // WeChat oauth
    ['GET', '/oauth/login', 'Login_Wechat.getRedirectUrl'],
    ['GET', '/user/info', 'Login_Wechat.getUserInfo'],


    ['GET', '/site/index', 'Site.Index'],
    ['GET', '/examples/curd/get/{id:\d}', 'Examples_CURD.Get'],
];