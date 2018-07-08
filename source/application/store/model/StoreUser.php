<?php

namespace app\store\model;

use app\common\model\StoreUser as StoreUserModel;
use think\Session;

/**
 * 商家用户模型
 * Class StoreUser
 * @package app\store\model
 */
class StoreUser extends StoreUserModel
{
    /**
     * 商家用户登录
     * @param $data
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function login($data)
    {
        // 验证用户名密码是否正确
        if (!$user = self::useGlobalScope(false)->with(['wxapp'])->where([
            'user_name' => $data['user_name'],
            'password' => yoshop_hash($data['password'])
        ])->find()) {
            $this->error = '登录失败, 用户名或密码错误';
            return false;
        }
        if (empty($user['wxapp'])) {
            $this->error = '登录失败, 未找到小程序信息';
            return false;
        }
        // 保存登录状态
        Session::set('yoshop_store', [
            'user' => [
                'store_user_id' => $user['store_user_id'],
                'user_name' => $user['user_name'],
            ],
            'wxapp' => $user['wxapp']->toArray(),
            'is_login' => true,
        ]);
        return true;
    }

    /**
     * 商户信息
     * @param $store_user_id
     * @return null|static
     * @throws \think\exception\DbException
     */
    public static function detail($store_user_id)
    {
        return self::get($store_user_id);
    }

    /**
     * 更新当前管理员信息
     * @param $data
     * @return bool
     */
    public function renew($data)
    {
        if ($data['password'] !== $data['password_confirm']) {
            $this->error = '确认密码不正确';
            return false;
        }
        // 更新管理员信息
        if ($this->save([
                'user_name' => $data['user_name'],
                'password' => yoshop_hash($data['password']),
            ]) === false) {
            return false;
        }
        // 更新session
        Session::set('yoshop_store.user', [
            'store_user_id' => $this['store_user_id'],
            'user_name' => $data['user_name'],
        ]);
        return true;
    }

}
