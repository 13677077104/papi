<?php

return [

    // WeChat oauth
    ['GET', '/oauth/login', 'Login_Wechat.getRedirectUrl'],


    ['GET', '/site/index', 'Site.Index'],
    ['GET', '/code', 'Callback.code'],
    ['GET', '/examples/curd/get/{id:\d}', 'Examples_CURD.Get'],
];