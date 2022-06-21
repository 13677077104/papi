<?php
/**
 * 请在下面放置任何您需要的应用配置
 *
 * @license     http://www.phalapi.net/license GPL 协议
 * @link        http://www.phalapi.net/
 * @author dogstar <chanzonghuang@gmail.com> 2017-07-13
 */

$routes = require 'routes.php';

return array(

    /**
     * 应用接口层的统一参数
     */
    'apiCommonRules' => array(
        //'sign' => array('name' => 'sign', 'require' => true),
    ),

    /**
     * 接口服务白名单，格式：接口服务类名.接口服务方法名
     *
     * 示例：
     * - *.*         通配，全部接口服务，慎用！
     * - Site.*      Api_Default接口类的全部方法
     * - *.Index     全部接口类的Index方法
     * - Site.Index  指定某个接口服务，即Api_Default::Index()
     */
    'service_whitelist' => array(
        'Site.Index',
    ),

    'wechat_config' => [
        'app_id' => $_ENV['WECHAT_APP_ID'] ?? null, # 'wx43752d2a1be56fe4',
        'secret' => $_ENV['WECHAT_SECRET'] ?? null, #'470b9c08434ce1d3b6b722f7e4922323',
        'token' => $_ENV['WECHAT_TOKEN'] ?? null,
        'response_type' => 'array',
        'log' => [
            'level' => 'debug',
            'permission' => '0777',
            'file' => API_ROOT . '/runtime/log/wechat.log',
        ],
    ],

    'FastRoute' => array(
        /**
         * 格式：array($method, $routePattern, $handler)
         *
         * @param string/array $method 允许的HTTP请求方式，可以为：GET/POST/HEAD/DELETE 等
         * @param string $routePattern 路由的正则表达式
         * @param string $handler 对应PhalApi中接口服务名称，即：?service=$handler
         */
        'routes' => $routes,
    ),

    'cors' => array(
        //域名白名单
        'whitelist' => array(
            'http://localhost/',
            'https://open.weixin.qq.com',
            //'http://xxx.xxx.xxx'
        ),
        //header头
        'headers' => array(
            'Access-Control-Allow-Methods' => 'GET, POST, PUT, DELETE, OPTIONS', //支持的请求类型
            'Access-Control-Allow-Credentials' => 'true' //支持cookie
        )
    ),

    'jwt' => [
        'key' => $_ENV['JWT_KEY'] ?? null,
        'expire_time' => 30 * 60, // token 的有效期
    ]
);
