<?php

namespace app\admin\controller;

use app\admin\model\Order as OrderModel;

/**
 * 订单管理
 * Class Order
 * @package app\admin\controller
 */
class Order extends Controller
{

    /**
     * 订单列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $model = new OrderModel;
        $list = $model->getList();
        return $this->fetch('index',compact('list'));
    }
}
