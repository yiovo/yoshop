<?php

namespace app\api\model;

use app\common\model\Order as OrderModel;

/**
 * 订单模型
 * Class Order
 * @package app\api\model
 */
class Order extends OrderModel
{
    /**
     * 立即购买
     * @param $user
     * @param $goods_id
     * @param $goods_num
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function buyNow($user, $goods_id, $goods_num)
    {
        // 商品信息
        $goods = (new Goods)->getDetail($goods_id);
        // 商品单价
        $goods['goods_price'] = $goods['spec'][0]['goods_price'];
        // 商品总价
        $goods['total_num'] = $goods_num;
        $goods['total_price'] = $total_price = bcmul($goods['goods_price'], $goods_num, 2);
        // 商品总重量
        $goods_total_weight = bcmul($goods['spec'][0]['goods_weight'], $goods_num, 2);
        // 当前用户收货城市id
        $cityId = $user['address_default'] ? $user['address_default']['city_id'] : null;
        // 验证用户收货地址是否存在运费规则中
        $intra_region = $goods['delivery']->checkAddress($cityId);
        // 计算配送费用
        $delivery_fee = $intra_region ?
            $goods['delivery']->calcTotalFee($goods_num, $goods_total_weight, $cityId) : 0;

        return [
            'goods_list' => [$goods],               // 商品详情
            'order_total_num' => $goods_num,        // 商品总数量
            'order_total_price' => $total_price,    // 商品总金额 (不含运费)
            'order_pay_price' => bcadd($total_price, $delivery_fee, 2),  // 实际支付金额

            'address' => $user['address_default'],  // 默认地址
            'exist_address' => !empty($user['address']),  // 是否存在收货地址
            'delivery_fee' => $delivery_fee,    // 配送费用
            'intra_region' => $intra_region,    // 当前用户收货城市是否存在配送规则中
            'intra_region_error' => '很抱歉，您的收货地址不在配送范围内',
        ];
    }
}
