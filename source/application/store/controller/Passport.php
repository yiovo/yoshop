<?php

namespace app\store\controller;

use app\store\model\Wxapp as WxappModel;

/**
 * 商户认证
 * Class Passport
 * @package app\store\controller
 */
class Passport extends Controller
{

    /**
     * 微擎登录
     * @throws \think\exception\DbException
     */
    public function we7login()
    {
        // 获取当前小程序信息
        $wxapp = WxappModel::detail();
        // 自动注册
        if (empty($wxapp)) {
            $model = new WxappModel;
            $model->add( $this->store['we7_data']);
        }

    }

}
