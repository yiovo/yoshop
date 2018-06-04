<?php

namespace app\api\model;

use app\common\model\WxappNavbar as WxappNavbarModel;

/**
 * 微信小程序导航栏模型
 * Class WxappNavbar
 * @package app\api\model
 */
class WxappNavbar extends WxappNavbarModel
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

}
