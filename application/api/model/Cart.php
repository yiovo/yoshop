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
     * 添加购物车
     * @param $goods_id
     * @param $goods_num
     * @return bool
     */
    public function add($goods_id, $goods_num)
    {
        if (empty($this->cart)) {
            $this->cart[$goods_id] = compact('goods_id', 'goods_num');
            return true;
        }
        !isset($this->cart[$goods_id])
            ? $this->cart[$goods_id] = compact('goods_id', 'goods_num')
            : $this->cart[$goods_id]['goods_num'] += $goods_num;
        return true;
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
