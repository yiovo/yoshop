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
     * 微擎自动登录/注册
     * @throws \Exception
     * @throws \think\exception\DbException
     */
    public function we7login()
    {
        // 获取当前小程序信息
        $wxapp = WxappModel::detail();
        // 判断不存在小程序信息 则自动注册
        if (empty($wxapp)) {
            $model = new WxappModel;
            $model->add($this->store['we7_data']);
        }
        $this->redirect('index/index');
    }

}
