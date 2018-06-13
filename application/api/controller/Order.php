<?php

namespace app\api\controller;

use app\api\model\Order as OrderModel;
use app\api\model\Wxapp as WxappModel;
use app\common\library\wechat\WxPay;

/**
 * 订单控制器
 * Class Order
 * @package app\api\controller
 */
class Order extends Controller
{
    /* @var \app\api\model\User $user */
    private $user;

    /**
     * 构造方法
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    public function _initialize()
    {
        parent::_initialize();
        $this->user = $this->getUser();   // 用户信息
    }

    /**
     * 订单确认-立即购买
     * @param $goods_id
     * @param $goods_num
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function buyNow($goods_id, $goods_num)
    {
        // 商品结算信息
        $model = new OrderModel;
        $order = $model->getBuyNow($this->user, $goods_id, $goods_num);
        if (!$this->request->isPost()) {
            return $this->renderSuccess($order);
        }
        // 创建订单
        if ($model->add($this->user['user_id'], $order)) {
            return $this->renderSuccess([], '更新成功');
        }
        return $this->renderError('订单创建失败');
    }

    /**
     * 订单确认-购物车结算
     * @return array
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function cart()
    {
        // 商品结算信息
        $model = new OrderModel;
        $order = $model->getCart($this->user);
        if (!$this->request->isPost()) {
            return $this->renderSuccess($order);
        }
        // 创建订单
        if ($model->add($this->user['user_id'], $order)) {
            // todo: 清空购物车

            // 发起微信支付
            $wxConfig = WxappModel::getWxappCache();
            $WxPay = new WxPay($wxConfig);
            $wxParams = $WxPay->unifiedorder($model['order_no'], $this->user['open_id']
                , $order['order_pay_price']);
            return $this->renderSuccess($wxParams);
        }
        return $this->renderError('订单创建失败');
    }

}
