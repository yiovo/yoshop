<?php

namespace app\store\model;

use app\common\model\WxappNavbar as WxappNavbarModel;

/**
 * 微信小程序导航栏模型
 * Class WxappNavbar
 * @package app\common\model
 */
class WxappNavbar extends WxappNavbarModel
{
    /**
     * 更新页面数据
     * @param $data
     * @return bool
     */
    public function edit($data)
    {
        // 删除wxapp缓存
        Wxapp::deleteCache();
        return $this->save($data) !== false;
    }

}
