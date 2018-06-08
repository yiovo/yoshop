<?php

namespace app\api\model;

use app\common\model\DeliveryRule as DeliveryRuleModel;

/**
 * 配送模板区域及运费模型
 * Class DeliveryRule
 * @package app\api\model
 */
class DeliveryRule extends DeliveryRuleModel
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
     * 追加字段
     * @var array
     */
    protected $append = ['region_data'];

    /**
     * 地区集转为数组格式
     * @param $value
     * @param $data
     * @return array
     */
    public function getRegionDataAttr($value, $data)
    {
        return explode(',', $data['region']);
    }

}
