<?php

namespace app\admin\model;

use app\common\model\Order as OrderModel;
use think\Request;

/**
 * 订单管理
 * Class Order
 * @package app\admin\model
 */
class Order extends OrderModel
{
    /**
     * 订单列表
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function getList()
    {
        return $this->with(['goods.image', 'address', 'user'])
            ->where([])
            ->order(['create_time' => 'desc'])->paginate(10, false, [
                'query' => Request::instance()->request()
            ]);
    }

    /**
     * 确认发货
     * @param $data
     * @return bool|false|int
     */
    public function delivery($data)
    {
        if ($this['pay_status']['value'] === 10
            || $this['delivery_status']['value'] === 20) {
            $this->error = '该订单不合法';
            return false;
        }
        return $this->save([
            'express_company' => $data['express_company'],
            'express_no' => $data['express_no'],
            'delivery_status' => 20,
            'delivery_time' => time(),
        ]);
    }

}
