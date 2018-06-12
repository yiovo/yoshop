<?php

namespace app\api\controller;

use app\api\model\Goods as GoodsModel;
use app\api\model\Cart as CartModel;

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

    /**
     * 获取商品详情
     * @param $goods_id
     * @return array
//     * @throws \app\common\exception\BaseException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function detail($goods_id)
    {
        // 商品详情
        $detail = (new GoodsModel)->getDetail($goods_id);
//        $user = $this->getUser();
        // 购物车商品总数量
//        $cart_total_num = (new CartModel($user['user_id']))->getTotalNum();
        return $this->renderSuccess(compact('detail', 'cart_total_num'));
    }

}
