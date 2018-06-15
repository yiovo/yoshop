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
        return $this->fetch('index', compact('list'));
    }

    /**
     * 订单详情
     * @param $order_id
     * @return mixed
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    public function detail($order_id)
    {
        $detail = OrderModel::detail($order_id);
        return $this->fetch('detail', compact('detail'));
    }

    /**
     * 确认发货
     * @param $order_id
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    public function delivery($order_id)
    {
        $model = OrderModel::detail($order_id);
        if ($model->delivery($this->postData('order'))) {
            return $this->renderSuccess('发货成功');
        }
        $error = $model->getError() ?: '发货失败';
        return $this->renderError($error);
    }

}
