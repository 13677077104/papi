<?php /** @noinspection PhpUnused */


function config($key, $default = null)
{
    return \PhalApi\DI()->config->get($key, $default);
}

function println($data)
{
    echo "<pre>";
    print_r($data);
}

function logData($data)
{
    if (is_array($data)) {
        $data = json_encode($data);
    }
    $dir = API_ROOT . '/runtime/logData/' . date("Ymd") . '.log';
    error_log($data . PHP_EOL, 3, $dir);
}

// 密码加密算法
function encryptPassword($password, $salt): string
{
    return md5(md5(\PhalApi\DI()->config->get('phalapi_user.common_salt')) . md5($password) . sha1($salt));
}

// 获取客户端ip
function getClientIp()
{
    $ip = false;
    if (!empty($_SERVER["HTTP_CLIENT_IP"])) {
        $ip = $_SERVER["HTTP_CLIENT_IP"];
    }
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ips = explode(", ", $_SERVER['HTTP_X_FORWARDED_FOR']);
        if ($ip) {
            array_unshift($ips, $ip);
            $ip = FALSE;
        }
        for ($i = 0; $i < count($ips); $i++) {
            if (!preg_match("/^(10│172.16│192.168)./i", $ips[$i])) {
                $ip = $ips[$i];
                break;
            }
        }
    }
    return $ip ?: $_SERVER['REMOTE_ADDR'];
}