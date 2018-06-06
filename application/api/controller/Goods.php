<?php

namespace app\api\controller;

use app\api\model\Goods as GoodsModel;

/**
 * 商品控制器
 * Class Goods
 * @package app\api\controller
 */
class Goods extends Controller
{
    /**
     * 商品列表
     * @param $sortType
     * @param $sortPrice
     * @return array
     * @throws \think\exception\DbException
     */
    public function lists($sortType, $sortPrice)
    {
        $model = new GoodsModel;
        $list = $model->getList($sortType, $sortPrice);
        return $this->renderSuccess(compact('list'));
    }

}
