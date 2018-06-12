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
     * 更新付款状态
     * @param $transaction_id
     * @return false|int
     */
    public function updatePayStatus($transaction_id)
    {
        // todo: 更新商品销量

        // 更新订单状态
        return $this->save([
            'pay_status' => 20,
            'pay_time' => time(),
            'transaction_id' => $transaction_id,
        ]);
    }

}
