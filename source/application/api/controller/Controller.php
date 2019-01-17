<?php

namespace app\api\controller;

use app\api\model\User as UserModel;
use app\common\exception\BaseException;
use think\Controller as ThinkController;

/**
 * API控制器基类
 * Class BaseController
 * @package app\store\controller
 */
class Controller extends ThinkController
{
    const JSON_SUCCESS_STATUS = 1;
    const JSON_ERROR_STATUS = 0;

    /* @ver $wxapp_id 小程序id */
    protected $wxapp_id;

    /**
     * 基类初始化
     * @throws BaseException
     */
    public function _initialize()
    {
        // 当前小程序id
        $this->wxapp_id = $this->getWxappId();
    }

    /**
     * 获取当前小程序ID
     * @return mixed
     * @throws BaseException
     */
    private function getWxappId()
    {
        if (!$wxapp_id = $this->request->param('wxapp_id')) {
            throw new BaseException(['msg' => '缺少必要的参数：wxapp_id']);
        }
        return $wxapp_id;
    }

    /**
     * 获取当前用户信息
     * @return mixed
     * @throws BaseException
     * @throws \think\exception\DbException
     */
    protected function getUser()
    {
        if (!$token = $this->request->param('token')) {
            throw new BaseException(['code' => -1, 'msg' => '缺少必要的参数：token']);
        }
        if (!$user = UserModel::getUser($token)) {
            throw new BaseException(['code' => -1, 'msg' => '没有找到用户信息']);
        }
        return $user;
    }

    /**
     * 返回封装后的 API 数据到客户端
     * @param int $code
     * @param string $msg
     * @param array $data
     * @return array
     */
    protected function renderJson($code = self::JSON_SUCCESS_STATUS, $msg = '', $data = [])
    {
        return compact('code', 'msg', 'data');
    }

    /**
     * 返回操作成功json
     * @param string $msg
     * @param array $data
     * @return array
     */
    protected function renderSuccess($data = [], $msg = 'success')
    {
        return $this->renderJson(self::JSON_SUCCESS_STATUS, $msg, $data);
    }

    /**
     * 返回操作失败json
     * @param string $msg
     * @param array $data
     * @return array
     */
    protected function renderError($msg = 'error', $data = [])
    {
        return $this->renderJson(self::JSON_ERROR_STATUS, $msg, $data);
    }

    /**
     * 获取post数据 (数组)
     * @param $key
     * @return mixed
     */
    protected function postData($key)
    {
        return $this->request->post($key . '/a');
    }

}
