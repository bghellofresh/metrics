<?php

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$config['redis']['host'] = 'redis';
$config['redis']['port'] = 6379;
$config['redis']['password'] = null;
$config['redis']['timeout'] = 0.1;
$config['redis']['read_timeout'] = 10;
$config['redis']['persistent_connections'] = false;

return $config;