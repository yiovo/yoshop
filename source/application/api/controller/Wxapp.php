<?php

namespace app\api\controller;

use app\api\model\Wxapp as WxappModel;
use app\api\model\WxappHelp;

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
        $wxapp = WxappModel::getWxappCache();
        return $this->renderSuccess(compact('wxapp'));
    }

    /**
     * 帮助中心
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function help()
    {
        $model = new WxappHelp;
        $list = $model->getList();
        return $this->renderSuccess(compact('list'));
    }

}
