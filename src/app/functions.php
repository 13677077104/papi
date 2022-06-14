<?php


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