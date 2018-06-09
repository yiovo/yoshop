<?php

namespace app\api\model;

use app\common\model\OrderGoodsImage as OrderGoodsImageModel;

/**
 * 订单商品图片模型
 * Class OrderGoodsImage
 * @package app\api\model
 */
class OrderGoodsImage extends OrderGoodsImageModel
{
    /**
     * 隐藏字段
     * @var array
     */
    protected $hidden = [
        'wxapp_id',
        'create_time',
    ];

}
