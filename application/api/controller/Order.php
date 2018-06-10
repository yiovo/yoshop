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
        $order = $model->buyNow($user, $goods_id, $goods_num);

        // 创建订单
        if ($this->request->isPost()) {
            if ($model->add($user['user_id'], $order)) {
                return $this->renderSuccess([], '更新成功');
            }
            return $this->renderError('订单创建失败');
        }

        return $this->renderSuccess($order);
    }

}
