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

}
