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

    public function address() {
        return $this->hasOne('OrderAddress');
    }


}
