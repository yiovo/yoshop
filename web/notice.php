<?php

// [ 支付通知入口文件 ]

// 手动定义路由
$_GET['s'] = '/task/notify/order';

// 定义应用目录
define('APP_PATH', __DIR__ . '/../source/application/');

// 加载框架引导文件
require __DIR__ . '/../source/thinkphp/start.php';
