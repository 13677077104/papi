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