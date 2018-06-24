<?php

namespace app\task\model;

use app\common\model\Goods as GoodsModel;

/**
 * 商品模型
 * Class Goods
 * @package app\task\model
 */
class Goods extends GoodsModel
{
    /**
     * 更新商品库存销量
     * @param $goodsList
     * @throws \Exception
     */
    public function updateStockSales($goodsList)
    {
        // 整理批量更新的数据
        $goodsData = [];
        foreach ($goodsList as $goods) {
            $goodsData[] = [
                'goods_id' => $goods['goods_id'],
                'sales_actual' => ['inc', $goods['total_num']],
                'goods_spec' => [
                    'goods_spec_id' => $goods['goods_spec_id'],
                    'goods_sales' => ['inc', $goods['total_num']],
                    'stock_num' => ['dec', $goods['total_num']]
                ]
            ];
        }
        // 更新商品总销量
        $this->allowField(true)->isUpdate()->saveAll($goodsData);
        // 更新商品规格库存
        $GoodsSpec = new GoodsSpec;
        $GoodsSpec->isUpdate()->saveAll(array_column($goodsData, 'goods_spec'));
    }

}
