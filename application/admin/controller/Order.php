<?php

namespace app\admin\controller;

/**
 * 订单管理
 * Class Order
 * @package app\admin\controller
 */
class Order extends Controller
{
    public function index()
    {
        return $this->fetch('index');
    }
}
