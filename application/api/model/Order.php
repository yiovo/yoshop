<?php

namespace app\api\model;

use think\Db;
use app\common\model\Order as OrderModel;

/**
 * 订单模型
 * Class Order
 * @package app\api\model
 */
class Order extends OrderModel
{
    /**
     * 隐藏字段
     * @var array
     */
    protected $hidden = [
        'wxapp_id',
        'create_time',
        'update_time'
    ];

    /**
     * 订单确认-立即购买
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
        $express_price = $intra_region ?
            $goods['delivery']->calcTotalFee($goods_num, $goods_total_weight, $cityId) : 0;

        return [
            'goods_list' => [$goods],               // 商品详情
            'order_total_num' => $goods_num,        // 商品总数量
            'order_total_price' => $total_price,    // 商品总金额 (不含运费)
            'order_pay_price' => bcadd($total_price, $express_price, 2),  // 实际支付金额

            'address' => $user['address_default'],  // 默认地址
            'exist_address' => !empty($user['address']),  // 是否存在收货地址
            'express_price' => $express_price,    // 配送费用
            'intra_region' => $intra_region,    // 当前用户收货城市是否存在配送规则中
            'intra_region_error' => '很抱歉，您的收货地址不在配送范围内',
        ];
    }

    /**
     * 新增订单
     * @param $user_id
     * @param $order
     * @return bool
     */
    public function add($user_id, $order)
    {
        if (!$order['intra_region']) {
            $this->error = $order['intra_region_error'];
            return false;
        }

        Db::startTrans();
        // 记录订单信息
        $this->save([
            'user_id' => $user_id,
            'wxapp_id' => self::$wxapp_id,
            'order_no' => $this->orderNo(),
            'total_price' => $order['order_total_price'],
            'pay_price' => $order['order_pay_price'],
            'express_price' => $order['express_price'],
        ]);

        // 记录商品信息
        $goodsList = [];
        foreach ($order['goods_list'] as $goods) {
            $goodsList[] = [
                'user_id' => $user_id,
                'wxapp_id' => self::$wxapp_id,
                'goods_id' => $goods['goods_id'],
                'goods_name' => $goods['goods_name'],
                'spec_type' => $goods['spec_type'],
                'content' => $goods['content'],
                'goods_no' => $goods['spec'][0]['goods_no'],
                'goods_price' => $goods['spec'][0]['goods_price'],
                'line_price' => $goods['spec'][0]['line_price'],
                'goods_weight' => $goods['spec'][0]['goods_weight'],
                'total_num' => $goods['total_num'],
                'total_price' => $goods['total_price'],
                'image_id' => $goods['image'][0]['image_id'],
            ];
        }
        $this->goods()->saveAll($goodsList);

        // 记录收货地址
        $this->address()->save([
            'user_id' => $user_id,
            'wxapp_id' => self::$wxapp_id,
            'name' => $order['address']['name'],
            'phone' => $order['address']['phone'],
            'province_id' => $order['address']['province_id'],
            'city_id' => $order['address']['city_id'],
            'region_id' => $order['address']['region_id'],
            'detail' => $order['address']['detail'],
            'order_id' => $this['order_id'],
        ]);
        Db::commit();

        return true;
    }

}
