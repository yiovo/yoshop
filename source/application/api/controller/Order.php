<?php

namespace app\api\controller;

use app\api\model\Order as OrderModel;
use app\api\model\Wxapp as WxappModel;
use app\api\model\Cart as CartModel;
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
     * @param $goods_sku_id
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     * @throws \Exception
     */
    public function buyNow($goods_id, $goods_num, $goods_sku_id)
    {
        // 商品结算信息
        $model = new OrderModel;
        $order = $model->getBuyNow($this->user, $goods_id, $goods_num, $goods_sku_id);
        if (!$this->request->isPost()) {
            return $this->renderSuccess($order);
        }
        if ($model->hasError()) {
            return $this->renderError($model->getError());
        }
        // 创建订单
        if ($model->add($this->user['user_id'], $order)) {
            // 发起微信支付
            return $this->renderSuccess([
                'payment' => $this->wxPay($model['order_no'], $this->user['open_id']
                    , $order['order_pay_price']),
                'order_id' => $model['order_id']
            ]);
        }
        $error = $model->getError() ?: '订单创建失败';
        return $this->renderError($error);
    }

    /**
     * 订单确认-购物车结算
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \Exception
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
            // 清空购物车
            $Card = new CartModel($this->user['user_id']);
            $Card->clearAll();
            // 发起微信支付
            return $this->renderSuccess([
                'payment' => $this->wxPay($model['order_no'], $this->user['open_id']
                    , $order['order_pay_price']),
                'order_id' => $model['order_id']
            ]);
        }
        $error = $model->getError() ?: '订单创建失败';
        return $this->renderError($error);
    }

    /**
     * 构建微信支付
     * @param $order_no
     * @param $open_id
     * @param $pay_price
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    private function wxPay($order_no, $open_id, $pay_price)
    {
        $wxConfig = WxappModel::getWxappCache();
        $WxPay = new WxPay($wxConfig);
        return $WxPay->unifiedorder($order_no, $open_id, $pay_price);
    }

}
