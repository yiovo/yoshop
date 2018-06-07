<?php

namespace app\api\controller;

use app\api\model\User as UserModel;

/**
 * 用户管理
 * Class User
 * @package app\api
 */
class User extends Controller
{
    /**
     * 用户自动登录
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public function login()
    {
        $model = new UserModel;
        $user_id = $model->login($this->wxapp_id);
        $token = $model->getToken();
        return $this->renderSuccess(compact('user_id', 'token'));
    }

    /**
     * 更新微信用户信息
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    public function append()
    {
        $model = $this->getUser();
        $model->setUserInfo();
        return $this->renderSuccess();
    }

}
