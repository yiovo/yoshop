<?php

namespace app\api\controller;

 use app\api\model\Order as OrderModel;

/**
 * 订单控制器
 * Class Order
 * @package app\api\controller
 */
class Order extends Controller
{
    /**
     * 立即购买
     * @param $goods_id
     * @param $goods_num
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function buyNow($goods_id, $goods_num)
    {
        //  用户信息
        $user = $this->getUser();
        // 商品结算信息
        $model = new OrderModel;
        $data = $model->buyNow($user, $goods_id, $goods_num);
        return $this->renderSuccess($data);
    }

}
