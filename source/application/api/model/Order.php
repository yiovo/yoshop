<?php

namespace app\api\model;

use think\Db;
use app\common\model\Order as OrderModel;

/**
 * 订单模型
 * Class Order
 * @package app\api\model
 */
class Order extends OrderModel
{
    /**
     * 隐藏字段
     * @var array
     */
    protected $hidden = [
        'wxapp_id',
        'update_time'
    ];

    /**
     * 订单确认-立即购买
     * @param User $user
     * @param $goods_id
     * @param $goods_num
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getBuyNow($user, $goods_id, $goods_num)
    {
        // 商品信息
        /* @var array|false|\PDOStatement|string|\think\Model|\think\Collection $goods */
        $goods = (new Goods)->getDetail($goods_id);
        // 商品单价
        $goods['goods_price'] = $goods['spec'][0]['goods_price'];
        // 商品总价
        $goods['total_num'] = $goods_num;
        $goods['total_price'] = $totalPrice = bcmul($goods['goods_price'], $goods_num, 2);
        // 商品总重量
        $goods_total_weight = bcmul($goods['spec'][0]['goods_weight'], $goods_num, 2);
        // 当前用户收货城市id
        $cityId = $user['address_default'] ? $user['address_default']['city_id'] : null;
        // 验证用户收货地址是否存在运费规则中
        $intraRegion = $goods['delivery']->checkAddress($cityId);
        // 计算配送费用
        $expressPrice = $intraRegion ?
            $goods['delivery']->calcTotalFee($goods_num, $goods_total_weight, $cityId) : 0;

        return [
            'goods_list' => [$goods],               // 商品详情
            'order_total_num' => $goods_num,        // 商品总数量
            'order_total_price' => $totalPrice,    // 商品总金额 (不含运费)
            'order_pay_price' => bcadd($totalPrice, $expressPrice, 2),  // 实际支付金额

            'address' => $user['address_default'],  // 默认地址
            'exist_address' => !$user['address']->isEmpty(),  // 是否存在收货地址
            'express_price' => $expressPrice,    // 配送费用
            'intra_region' => $intraRegion,    // 当前用户收货城市是否存在配送规则中
            'intra_region_error' => '很抱歉，您的收货地址不在配送范围内',
        ];
    }

    /**
     * 订单确认-购物车结算
     * @param $user
     * @return array
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getCart($user)
    {
        $model = new Cart($user['user_id']);
        return $model->getList($user);
    }

    /**
     * 新增订单
     * @param $user_id
     * @param $order
     * @return bool
     */
    public function add($user_id, $order)
    {
        if (empty($order['address'])) {
            $this->error = '请先选择收货地址';
            return false;
        }

        if (!$order['intra_region']) {
            $this->error = $order['intra_region_error'];
            return false;
        }

        Db::startTrans();
        // 记录订单信息
        $this->save([
            'user_id' => $user_id,
            'wxapp_id' => self::$wxapp_id,
            'order_no' => $this->orderNo(),
            'total_price' => $order['order_total_price'],
            'pay_price' => $order['order_pay_price'],
            'express_price' => $order['express_price'],
        ]);

        // 记录商品信息
        $goodsList = [];
        foreach ($order['goods_list'] as $goods) {
            $goodsList[] = [
                'user_id' => $user_id,
                'wxapp_id' => self::$wxapp_id,
                'goods_id' => $goods['goods_id'],
                'goods_name' => $goods['goods_name'],
                'spec_type' => $goods['spec_type'],
                'goods_spec_id' => $goods['spec'][0]['goods_spec_id'],
                'content' => $goods['content'],
                'goods_no' => $goods['spec'][0]['goods_no'],
                'goods_price' => $goods['spec'][0]['goods_price'],
                'line_price' => $goods['spec'][0]['line_price'],
                'goods_weight' => $goods['spec'][0]['goods_weight'],
                'total_num' => $goods['total_num'],
                'total_price' => $goods['total_price'],
                'image_id' => $goods['image'][0]['image_id'],
            ];
        }
        $this->goods()->saveAll($goodsList);

        // 记录收货地址
        $this->address()->save([
            'user_id' => $user_id,
            'wxapp_id' => self::$wxapp_id,
            'name' => $order['address']['name'],
            'phone' => $order['address']['phone'],
            'province_id' => $order['address']['province_id'],
            'city_id' => $order['address']['city_id'],
            'region_id' => $order['address']['region_id'],
            'detail' => $order['address']['detail'],
        ]);
        Db::commit();

        return true;
    }

    /**
     * 用户中心订单列表
     * @param $user_id
     * @param string $type
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getList($user_id, $type = 'all')
    {
        // 筛选条件
        $filter = [];
        // 订单数据类型
        switch ($type) {
            case 'all':
                break;
            case 'payment';
                $filter['pay_status'] = 10;
                break;
            case 'delivery';
                $filter['pay_status'] = 20;
                $filter['delivery_status'] = 10;
                break;
            case 'received';
                $filter['pay_status'] = 20;
                $filter['delivery_status'] = 20;
                $filter['receipt_status'] = 10;
                break;
        }
        return $this->with(['goods.image'])
            ->where('user_id', '=', $user_id)
            ->where('order_status', '<>', 20)
            ->where($filter)
            ->order(['create_time' => 'desc'])
            ->select();
    }

    /**
     * 取消订单
     * @return bool|false|int
     */
    public function cancel()
    {
        if ($this['pay_status']['value'] === 20) {
            $this->error = '已付款订单不可取消';
            return false;
        }
        return $this->save(['order_status' => 20]);
    }

    /**
     * 确认收货
     * @return bool|false|int
     */
    public function receipt()
    {
        if ($this['delivery_status']['value'] === 10 || $this['receipt_status']['value'] === 20) {
            $this->error = '该订单不合法';
            return false;
        }
        return $this->save([
            'receipt_status' => 20,
            'receipt_time' => time(),
            'order_status' => 30
        ]);
    }

    /**
     * 获取订单总数
     * @param $user_id
     * @param string $type
     * @return int|string
     */
    public function getCount($user_id, $type = 'all')
    {
        // 筛选条件
        $filter = [];
        // 订单数据类型
        switch ($type) {
            case 'all':
                break;
            case 'payment';
                $filter['pay_status'] = 10;
                break;
            case 'received';
                $filter['pay_status'] = 20;
                $filter['receipt_status'] = 10;
                break;
        }
        return $this->where('user_id', '=', $user_id)
            ->where('order_status', '<>', 20)
            ->where($filter)
            ->count();
    }

}
