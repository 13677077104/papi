<?php

return [

    // WeChat oauth
    ['GET', '/oauth/get-redirect-url', 'Login_Wechat.getRedirectUrl'],
    ['GET', '/oauth/callback', 'Login_Wechat.callback'],

    // -------------------------------------------------
    ['GET', '/user/id', 'Login_Wechat.getUserId'],

    ['GET', '/site/index', 'Site.Index'],
    ['GET', '/examples/curd/get/{id:\d}', 'Examples_CURD.Get'],
];