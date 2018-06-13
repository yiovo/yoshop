<?php

namespace app\api\controller\user;

use app\api\controller\Controller;
use app\api\model\Order as OrderModel;

/**
 * 用户订单管理
 * Class Order
 * @package app\api\controller\user
 */
class Order extends Controller
{
    /**
     * 我的订单列表
     * @param $dataType
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function lists($dataType)
    {
        $user = $this->getUser();
        $model = new OrderModel;
        $list = $model->getList($user['user_id'], $dataType);
        return $this->renderSuccess(compact('list'));
    }

    /**
     * 取消订单
     * @param $order_id
     * @return array
     * @throws \think\exception\DbException
     */
    public function cancel($order_id)
    {
        $order = OrderModel::detail($order_id);
        if (empty($order)) {
            return $this->renderError('订单不存在');
        }
        if ($order['pay_status']['value'] === 20) {
            return $this->renderError('已付款订单不可取消');
        }
        $order->cancel();
        return $this->renderSuccess();
    }

}
