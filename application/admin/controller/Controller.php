<?php

namespace app\admin\controller;

use think\Config;
use think\Session;
use think\Controller as ThinkController;

/**
 * 后台控制器基类
 * Class BaseController
 * @package app\admin\controller
 */
class Controller extends ThinkController
{
    protected $admin;

    /**
     * 后台初始化
     */
    public function _initialize()
    {
        // test.start
        Session::set('best_shop_admin', [
            'is_login' => true,
            'wxapp' => [
                'wxapp_id' => 5,
            ],
        ]);
        // test.end

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
        list ($group, $controller, $action) = $this->getRouteinfo();
        // 后台菜单
        $menus = $this->menus();
        // 当前小程序信息
        $wxapp = $this->admin['wxapp'];
        // 输出到view
        $this->assign(compact('group', 'controller', 'action', 'menus', 'wxapp'));
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
        return [$group, $controller, $action];
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
        $this->admin = Session::get('best_shop_admin');
        if (empty($this->admin)
            || (int)$this->admin['is_login'] !== 1
            || !isset($this->admin['wxapp'])
            || empty($this->admin['wxapp'])
        ) {
            $this->error('登录状态无效');
        }
    }

    /**
     * 获取当前wxapp_id
     */
    protected function getWxappId()
    {
        return $this->admin['wxapp']['wxapp_id'];
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
