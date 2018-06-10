<?php

namespace app\api\model;

use think\Cache;

/**
 * 购物车管理
 * Class Cart
 * @package app\api\model
 */
class Cart
{
    private $user_id;
    private $cart;

    /**
     * 构造方法
     * Cart constructor.
     * @param $user_id
     */
    public function __construct($user_id)
    {
        $this->user_id = $user_id;
        $this->cart = Cache::get('cart_' . $this->user_id) ?: [];
    }

    /**
     * 购物车列表
     * @param \think\Model|\think\Collection $user
     * @return array
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getList($user)
    {
        // 商品列表
        $goodsList = [];
        $goodsIds = array_unique(array_column($this->cart, 'goods_id'));
        foreach ((new Goods)->getListByIds($goodsIds) as $goods) {
            $goodsList[$goods['goods_id']] = $goods;
        }
        // 当前用户收货城市id
        $cityId = $user['address_default'] ? $user['address_default']['city_id'] : null;
        // 商品是否在配送范围
        $intraRegion = true;
        $intraRegionError = '';
        // 购物车商品列表
        $cartList = [];
        foreach ($this->cart as $key => $cart) {
            /* @var $goods array|false|\PDOStatement|string|\think\Model */
            $goods = $goodsList[$cart['goods_id']];
            // 商品单价
            $goods['goods_price'] = $goods['spec'][0]['goods_price'];
            // 商品总价
            $goods['total_num'] = $cart['goods_num'];
            $goods['total_price'] = $total_price = bcmul($goods['goods_price'], $cart['goods_num'], 2);
            // 商品总重量
            $goods['goods_total_weight'] = bcmul($goods['spec'][0]['goods_weight'], $cart['goods_num'], 2);
            // 验证用户收货地址是否存在运费规则中
            if ($goods['delivery']->checkAddress($cityId)) {
                $goods['express_price'] = $goods['delivery']->calcTotalFee(
                    $cart['goods_num'], $goods['goods_total_weight'], $cityId);
            } else {
                empty($intraRegionError)
                && $intraRegionError = "很抱歉，您的收货地址不在商品[{$goods['goods_name']}]的配送范围内";
            }
            $cartList[] = $goods->toArray();
        }
        // 商品总金额
        $orderTotalPrice = array_sum(array_column($cartList, 'total_price'));
        // 所有商品的运费金额
        $allExpressPrice = array_column($cartList, 'express_price');
        // 订单总运费金额
        $expressPrice = Delivery::freightRule($allExpressPrice);

        return [
            'goods_list' => $cartList,  // 商品列表
            'order_total_num' => $this->getTotalNum(),  // 商品总数量
            'order_total_price' => number_format($orderTotalPrice, 2),    // 商品总金额 (不含运费)
            'order_pay_price' => bcadd($orderTotalPrice, $expressPrice, 2),  // 实际支付金额

            'address' => $user['address_default'],  // 默认地址
            'exist_address' => $user['address']->isEmpty(),  // 是否存在收货地址
            'express_price' => $expressPrice,   // 配送费用
            'intra_region' => $intraRegion,     // 当前用户收货城市是否存在配送规则中
            'intra_region_error' => $intraRegionError,
        ];
    }

    /**
     * 添加购物车
     * @param $goods_id
     * @param $goods_num
     * @return bool
     */
    public function add($goods_id, $goods_num)
    {
        $index = $goods_id . '_0';
        $create_time = time();
        if (empty($this->cart)) {
            $this->cart[$index] = compact('goods_id', 'goods_num', 'create_time');
            return true;
        }
        !isset($this->cart[$index])
            ? $this->cart[$index] = compact('goods_id', 'goods_num', 'create_time')
            : $this->cart[$index]['goods_num'] += $goods_num;
        return true;
    }

    /**
     * 减少购物车中某商品数量
     * @param $goods_id
     */
    public function sub($goods_id)
    {
        $index = $goods_id . '_0';
        $this->cart[$index]['goods_num'] > 1 && $this->cart[$index]['goods_num']--;
    }

    /**
     * 删除购物车中指定商品
     * @param $goods_id
     */
    public function delete($goods_id)
    {
        $index = $goods_id . '_0';
        unset($this->cart[$index]);
    }

    /**
     * 获取当前用户购物车商品总数量
     * @return int
     */
    public function getTotalNum()
    {
        return array_sum(array_column($this->cart, 'goods_num'));
    }

    /**
     * 析构方法
     * 将cart数据保存到缓存文件
     */
    public function __destruct()
    {
        Cache::set('cart_' . $this->user_id, $this->cart);
    }

}
