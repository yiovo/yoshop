<?php

namespace app\api\controller;

use app\api\model\Wxapp as WxappModel;

/**
 * 微信小程序
 * Class Wxapp
 * @package app\api\controller
 */
class Wxapp extends Controller
{
    /**
     * 小程序基础信息
     * @return array
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public function base()
    {
        $wxapp = WxappModel::getWxappCache($this->wxapp_id);
        return $this->renderSuccess(compact('wxapp'));
    }

}
