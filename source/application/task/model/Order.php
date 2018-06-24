<?php

namespace app\task\model;

use app\common\model\Order as OrderModel;
use think\Db;

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
     * @throws \Exception
     */
    public function updatePayStatus($transaction_id)
    {
        Db::startTrans();
        // 更新商品库存、销量
        $GoodsModel = new Goods;
        $GoodsModel->updateStockSales($this['goods']);
        // 更新订单状态
        $this->save([
            'pay_status' => 20,
            'pay_time' => time(),
            'transaction_id' => $transaction_id,
        ]);
        Db::commit();
        return true;
    }

}
