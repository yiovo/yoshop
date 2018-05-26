<?php

namespace app\common\model;


/**
 * 配送模板区域及运费模型
 * Class DeliveryRule
 * @package app\admin\model
 */
class DeliveryRule extends BaseModel
{
    protected $name = 'delivery_rule';
    protected $updateTime = false;

    static $regionAll;
    static $regionTree;

    /**
     * 可配送区域
     * @param $value
     * @return array
     */
    public function getRegionAttr($value)
    {
        // 当前区域记录转换为数组
        $regionIds = explode(',', $value);
        if (count($regionIds) === 373) {
            $content = '全国';
        } else {
            // 所有地区
            if (empty(self::$regionAll)) {
                self::$regionAll = Region::getCacheAll();
                self::$regionTree = Region::getCacheTree();
            }
            // 将当前可配送区域格式化为树状结构
            $alreadyTree = [];
            foreach ($regionIds as $regionId)
                $alreadyTree[self::$regionAll[$regionId]['pid']][] = $regionId;
            $str = '';
            foreach ($alreadyTree as $provinceId => $citys) {
                $str .= self::$regionTree[$provinceId]['name'];
                if (count($citys) !== count(self::$regionTree[$provinceId]['city'])) {
                    $cityStr = '';
                    foreach ($citys as $cityId)
                        $cityStr .= self::$regionTree[$provinceId]['city'][$cityId]['name'];
                    $str .= ' (<span class="am-link-muted">' . mb_substr($cityStr,0,-1,'utf-8') . '</span>)';
                }
                $str .= '、';
            }
            $content = mb_substr($str,0,-1,'utf-8');
        }
        return compact('content', 'value');
    }

}
