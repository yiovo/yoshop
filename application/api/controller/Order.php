<?php

namespace app\api\controller;

// use app\api\model\Order as OrderModel;
use app\api\model\Goods as GoodsModel;

/**
 * 订单控制器
 * Class Order
 * @package app\api\controller
 */
class Order extends Controller
{
    /**
     * 立即购买
     * @param $goods_id
     * @param $goods_num
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function buyNow($goods_id, $goods_num)
    {
        // 默认收货地址
        $address = $this->getUser()['address_default'];
        $model = new GoodsModel;
        $data = $model->buyNow($goods_id, $goods_num, $address);
        return $this->renderSuccess($data);
    }

}
