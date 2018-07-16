<?php

namespace app\store\controller;

use think\Config;
use think\Session;
use app\store\model\Setting;

/**
 * 后台控制器基类
 * Class BaseController
 * @package app\store\controller
 */
class Controller extends \think\Controller
{
    /* @var array $store 商城session信息 */
    protected $store;

    /* @var array $allowAllAction 登录验证白名单 */
    protected $allowAllAction = [
        // 登录页面
        'passport/login',
    ];

    /* @var array $notLayoutAction 无需全局layout */
    protected $notLayoutAction = [
        // 登录页面
        'passport/login',
    ];

    /**
     * 后台初始化
     */
    public function _initialize()
    {
        // 验证登录
        $this->checkLogin();
        // 全局layout
        $this->layout();
    }

    /**
     * 全局layout模板输出
     */
    private function layout()
    {
        // 路由信息
        list ($controller, $action, $group) = $this->getRouteinfo();
        // 验证当前请求是否在白名单
        if (in_array($controller . '/' . $action, $this->notLayoutAction)) {
            return true;
        }
        // 当前商城设置
        $setting = Setting::getAll() ?: null;
        // 后台菜单
        $menus = $this->menus();
        // 当前小程序信息
        $store = $this->store;
        // 输出到view
        $this->assign(compact('group', 'controller', 'action', 'menus'
            , 'store', 'setting'));
        return true;
    }

    /**
     * 解析当前路由参数 （分组名称、控制器名称、方法名）
     * @return array
     */
    protected function getRouteinfo()
    {
        // 控制器名称
        $controller = toUnderScore($this->request->controller());
        // 方法名称
        $action = $this->request->action();
        // 控制器分组 (用于定义所属模块)
        $groupstr = strstr($controller, '.', true);
        $group = $groupstr !== false ? $groupstr : $controller;
        return [$controller, $action, $group];
    }

    /**
     * 后台菜单配置
     * @return array
     */
    private function menus()
    {
        return Config::get('menus');
    }

    /**
     * 验证登录状态
     */
    private function checkLogin()
    {
        // 记录session信息
        $this->store = Session::get('yoshop_store');

        // 路由信息
        list ($controller, $action) = $this->getRouteinfo();

        // 验证当前请求是否在白名单
        if (in_array($controller . '/' . $action, $this->allowAllAction)) {
            return true;
        }

        // 验证登录状态
        if (empty($this->store)
            || (int)$this->store['is_login'] !== 1
            || !isset($this->store['wxapp'])
            || empty($this->store['wxapp'])
        ) {
            $this->error('您还没有登录', 'passport/login');
            return false;
        }
        return true;
    }

    /**
     * 获取当前wxapp_id
     */
    protected function getWxappId()
    {
        return $this->store['wxapp']['wxapp_id'];
    }

    /**
     * 返回封装后的 API 数据到客户端
     * @param int $code
     * @param string $msg
     * @param string $url
     * @param array $data
     * @return array
     */
    protected function renderJson($code = 1, $msg = '', $url = '', $data = [])
    {
        return compact('code', 'msg', 'url', 'data');
    }

    /**
     * 返回操作成功json
     * @param string $msg
     * @param string $url
     * @param array $data
     * @return array
     */
    protected function renderSuccess($msg = 'success', $url = '', $data = [])
    {
        return $this->renderJson(1, $msg, $url, $data);
    }

    /**
     * 返回操作失败json
     * @param string $msg
     * @param string $url
     * @param array $data
     * @return array
     */
    protected function renderError($msg = 'error', $url = '', $data = [])
    {
        return $this->renderJson(0, $msg, $url, $data);
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
