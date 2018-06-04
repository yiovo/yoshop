<?php

namespace app\api\model;

use app\common\model\User as UserModel;
use app\common\library\wechat\WxUser;
use app\common\model\Wxapp;
use app\common\exception\BaseException;
use think\Cache;
use think\Request;

/**
 * 用户模型类
 * Class User
 * @package app\api\model
 */
class User extends UserModel
{
    protected $hidden = ['create_time', 'update_time'];
    private $token;

    /**
     * 获取用户信息
     * @param $token
     * @return null|static
     * @throws \think\exception\DbException
     */
    public function getUser($token)
    {
        $session = Cache::get($token);
        return self::get(['open_id' => $session['openid']]);
    }

    /**
     * 设置微信用户信息
     * @return false|int
     */
    public function setUserInfo()
    {
        $post = Request::instance()->post();
        return $this->save([
            'nick_name' => preg_replace('/[\xf0-\xf7].{3}/', '', $post['nickName']),
            'gender' => $post['gender'],
            'city' => $post['city'],
            'province' => $post['province'],
            'country' => $post['country'],
            'avatar' => $post['avatarUrl'],
        ]);
    }

    /**
     * 用户登录
     * @param $wxapp_id
     * @return string
     * @throws BaseException
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public function login($wxapp_id)
    {
        // 微信登录 获取session_key
        $session = $this->wxlogin($wxapp_id);
        // 自动注册用户
        $user_id = $this->register($session['openid'], $wxapp_id);
        // 生成token (session3rd)
        $this->token = $this->token($session['openid'], $wxapp_id);
        // 记录缓存, 7天
        Cache::set($this->token, $session,86400 * 7);
        return $user_id;
    }

    /**
     * 获取token
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * 微信登录
     * @param $wxapp_id
     * @return array|mixed
     * @throws BaseException
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    private function wxlogin($wxapp_id)
    {
        // 获取当前小程序信息
        $wxapp = Wxapp::getWxappCache($wxapp_id);
        // 微信登录 (获取session_key)
        $code = \request()->post('code');
        $WxUser = new WxUser($wxapp['app_id'], $wxapp['app_secret']);
        if (!$session = $WxUser->sessionKey($code))
            throw new BaseException(['msg' => 'session_key 获取失败']);
        return $session;
    }

    /**
     * 生成用户认证的token
     * @param $openid
     * @param $wxapp_id
     * @return string
     */
    private function token($openid, $wxapp_id)
    {
        return md5($openid . $wxapp_id . 'token_salt');
    }

    /**
     * 自动注册会员
     * @param $open_id
     * @param $wxapp_id
     * @return mixed
     * @throws BaseException
     * @throws \think\exception\DbException
     */
    private function register($open_id, $wxapp_id)
    {
        if (!$user = $this->get(['open_id' => $open_id])) {
            if (!$this->save(compact('open_id', 'wxapp_id')))
                throw new BaseException(['msg' => '用户注册失败']);
            return $this->user_id;
        } else {
            return $user->user_id;
        }
    }

}
