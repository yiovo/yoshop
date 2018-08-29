<?php

namespace app\common\model;

/**
 * 订单商品模型
 * Class OrderGoods
 * @package app\common\model
 */
class OrderGoods extends BaseModel
{
    protected $name = 'order_goods';
    protected $updateTime = false;

    /**
     * 订单商品列表
     * @return \think\model\relation\BelongsTo
     */
    public function image()
    {
        return $this->belongsTo('UploadFile', 'image_id', 'file_id');
    }

    /**
     * 关联商品表
     * @return \think\model\relation\BelongsTo
     */
    public function goods()
    {
        return $this->belongsTo('Goods');
    }

    /**
     * 关联商品规格表
     * @return \think\model\relation\BelongsTo
     */
    public function spec()
    {
        return $this->belongsTo('GoodsSpec', 'spec_sku_id', 'spec_sku_id');
    }

}
