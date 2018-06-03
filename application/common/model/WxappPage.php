<?php

namespace app\common\model;

/**
 * 微信小程序diy页面模型
 * Class WxappPage
 * @package app\common\model
 */
class WxappPage extends BaseModel
{
    protected $name = 'wxapp_page';

    /**
     * 格式化页面数据
     * @param $json
     * @return array
     */
    public function getPageDataAttr($json)
    {
        $array = json_decode($json, true);
        return compact('array', 'json');
    }

    /**
     * diy页面详情
     * @return null|static
     * @throws \think\exception\DbException
     */
    public static function detail()
    {
        return self::get([]);
    }

}
