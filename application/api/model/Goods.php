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
        'is_delete',
        'wxapp_id',
        'create_time',
        'update_time'
    ];

    /**
     * 根据商品id集获取商品列表 (购物车列表用)
     * @param $goodsIds
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getListByIds($goodsIds) {
        return $this->field('content', true)
            ->with(['category', 'image.file', 'spec', 'delivery.rule'])
            ->where('goods_id', 'in', $goodsIds)->select();
    }

}
