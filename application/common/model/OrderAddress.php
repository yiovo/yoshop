<?php

namespace app\common\model;

/**
 * 订单收货地址模型
 * Class OrderAddress
 * @package app\common\model
 */
class OrderAddress extends BaseModel
{
    protected $name = 'order_address';
    protected $updateTime = false;

    /**
     * 追加字段
     * @var array
     */
    protected $append = ['region'];

    /**
     * 地区名称
     * @param $value
     * @param $data
     * @return array
     */
    public function getRegionAttr($value, $data)
    {
        return [
            'province' => Region::getNameById($data['province_id']),
            'city' => Region::getNameById($data['city_id']),
            'region' => Region::getNameById($data['region_id']),
        ];
    }

}
