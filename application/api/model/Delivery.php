<?php

namespace app\api\model;

use app\common\model\Delivery as DeliveryModel;

/**
 * 配送模板模型
 * Class Delivery
 * @package app\api\model
 */
class Delivery extends DeliveryModel
{
    /**
     * 隐藏字段
     * @var array
     */
    protected $hidden = [
        'wxapp_id',
        'create_time',
        'update_time'
    ];

    /**
     * 计算配送费用
     * @param $total_num
     * @param $total_weight
     * @param $city_id
     * @return float|int|mixed
     */
    public function calcTotalFee($total_num, $total_weight, $city_id)
    {
        $rule = [];  // 当前规则
        foreach ($this['rule'] as $item) {
            if (in_array($city_id, $item['region_data'])) {
                $rule = $item;
                break;
            }
        }
        // 商品总数量or总重量
        $total = $this['method']['value'] === 10 ? $total_num : $total_weight;
        if ($total <= $rule['first']) {
            $freight = $rule['first_fee'];
        } else {
            // 续件or续重 数量
            $additional = $total - $rule['first'];
            if ($additional <= $rule['additional']) {
                $additional_fee = $rule['additional_fee'];
            } else {
                $additional_fee = bcdiv($rule['additional_fee'], $rule['additional'], 2) * $additional;
            }
            $freight = $rule['first_fee'] + $additional_fee;
        }

        return number_format($freight, 2);
    }

    /**
     * 验证用户收货地址是否存在运费规则中
     * @param $city_id
     * @return bool
     */
    public function checkAddress($city_id)
    {
        $cityIds = explode(',', implode(',', array_column($this['rule']->toArray(), 'region')));
        return in_array($city_id, $cityIds);
    }

    /**
     * 根据运费组合策略 计算最终运费
     * @param $allExpressPrice
     * @return float|int|mixed
     * @throws \think\exception\DbException
     */
    public static function freightRule($allExpressPrice)
    {
        $freight_rule = Setting::getItem('trade')['freight_rule'];
        $expressPrice = 0.00;
        switch ($freight_rule) {
            case 10:    // 策略1: 叠加
                $expressPrice = array_sum($allExpressPrice);
                break;
            case 20:    // 策略2: 以最低运费结算
                $expressPrice = min($allExpressPrice);
                break;
            case 30:    // 策略3: 以最高运费结算
                $expressPrice = max($allExpressPrice);
                break;
        }
        return $expressPrice;
    }

}
