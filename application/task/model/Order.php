<?php

namespace app\task\model;

use app\common\model\Order as OrderModel;

/**
 * 订单模型
 * Class Order
 * @package app\common\model
 */
class Order extends OrderModel
{
    /**
     * 待支付订单详情
     * @param $order_no
     * @return null|static
     * @throws \think\exception\DbException
     */
    public function payDetail($order_no)
    {
        return self::get(['order_no' => $order_no, 'pay_status' => 10], ['goods']);
    }

    /**
     * 更新付款状态
     * @param $transaction_id
     * @return false|int
     */
    public function updatePayStatus($transaction_id)
    {
        // 更新商品库存、销量
        $GoodsModel = new Goods;
        $GoodsModel->updateStock($this['goods']);

        // 更新订单状态
        return $this->save([
            'pay_status' => 20,
            'pay_time' => time(),
            'transaction_id' => $transaction_id,
        ]);
    }

}
