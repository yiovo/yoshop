<?php

namespace app\common\model;

/**
 * 订单模型
 * Class Order
 * @package app\common\model
 */
class Order extends BaseModel
{
    protected $name = 'order';

    /**
     * 订单商品列表
     * @return \think\model\relation\HasMany
     */
    public function goods()
    {
        return $this->hasMany('OrderGoods');
    }

    /**
     * 关联订单收货地址表
     * @return \think\model\relation\HasOne
     */
    public function address()
    {
        return $this->hasOne('OrderAddress');
    }

    /**
     * 生成订单号
     */
    protected function orderNo()
    {
        return date('Ymd') . substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
    }

}
