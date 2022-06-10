<?php


$data = file_get_contents('php://input');

$arg = json_decode($data, JSON_INVALID_UTF8_IGNORE);

error_log($data, 3, '/tmp/pull.log');