<?php

namespace app\api\controller;

use app\api\model\Cart as CartModel;

/**
 * 购物车管理
 * Class Cart
 * @package app\api\controller
 */
class Cart extends Controller
{
    /**
     * 加入购物车
     * @param $goods_id
     * @param $goods_num
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    public function add($goods_id, $goods_num)
    {
        $user = $this->getUser();
        $model = new CartModel($user['user_id']);
        if (!$model->add($goods_id, $goods_num)) {
            return $this->renderError('加入购物车失败');
        }
        $total_num = $model->getTotalNum();
        return $this->renderSuccess(['cart_total_num' => $total_num], '加入购物车成功');
    }

}
