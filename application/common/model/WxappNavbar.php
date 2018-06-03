<?php

namespace app\common\model;

/**
 * 微信小程序导航栏模型
 * Class WxappNavbar
 * @package app\common\model
 */
class WxappNavbar extends BaseModel
{
    protected $name = 'wxapp_navbar';

    /**
     * 小程序导航栏详情
     * @return null|static
     * @throws \think\exception\DbException
     */
    public static function detail()
    {
        return self::get([]);
    }

}
