<?php

namespace app\api\model;

use app\common\model\Goods as GoodsModel;

/**
 * 商品模型
 * Class Goods
 * @package app\api\model
 */
class Goods extends GoodsModel
{
    /**
     * 隐藏字段
     * @var array
     */
    protected $hidden = [
        'sales_initial',
        'sales_actual',
        'wxapp_id',
        'create_time',
        'update_time'
    ];

    /**
     * 立即购买
     * @param $goods_id
     * @param $goods_num
     * @param $address
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function buyNow($goods_id, $goods_num, $address)
    {
        // 商品信息
        $goods = $this->getDetail($goods_id);
        // 商品单价
        $goods['goods_price'] = $goods['spec'][0]['goods_price'];
        // 商品总价
        $goods['goods_buy_num'] = $goods_num;
        $goods['goods_total_price'] = $total_price = bcmul($goods['goods_price'], $goods_num, 2);

        return [
            'address' => $address,              // 默认收货地址
            'goods_list' => [$goods],           // 商品详情
            'order_total_num' => $goods_num,    // 商品总数量
            'order_total_price' => $total_price // 商品总价格 (包含运费)
        ];
    }

}
