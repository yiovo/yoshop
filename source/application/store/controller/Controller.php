<?php

namespace app\store\controller;

use think\Config;
use think\Session;
use think\Cookie;
use app\store\model\Setting;

/**
 * 后台控制器基类
 * Class BaseController
 * @package app\store\controller
 */
class Controller extends \think\Controller
{
    /* @var array $store 商家登录信息 */
    protected $store;

    /* @var string $route 当前控制器名称 */
    protected $controller = '';

    /* @var string $route 当前方法名称 */
    protected $action = '';

    /* @var string $route 当前路由uri */
    protected $routeUri = '';

    /* @var string $route 当前路由：分组名称 */
    protected $group = '';

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
        // 商家登录信息
        $this->store = Session::get('yoshop_store');
        // 当前路由信息
        $this->getRouteinfo();
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
        // 验证当前请求是否在白名单
        if (!in_array($this->routeUri, $this->notLayoutAction)) {
            // 输出到view
            $this->assign([
                'base_url' => base_url(),                      // 当前域名
                'store_url' => url('/store'),              // 后台模块url
                'group' => $this->group,
                'menus' => $this->menus(),                     // 后台菜单
                'store' => $this->store,                       // 商家登录信息
                'setting' => Setting::getAll() ?: null,        // 当前商城设置
            ]);
        }
    }

    /**
     * 解析当前路由参数 （分组名称、控制器名称、方法名）
     */
    protected function getRouteinfo()
    {
        // 控制器名称
        $this->controller = toUnderScore($this->request->controller());
        // 方法名称
        $this->action = $this->request->action();
        // 控制器分组 (用于定义所属模块)
        $groupstr = strstr($this->controller, '.', true);
        $this->group = $groupstr !== false ? $groupstr : $this->controller;
        // 当前uri
        $this->routeUri = $this->controller . '/' . $this->action;
    }

    /**
     * 后台菜单配置
     * @return array
     */
    private function menus()
    {
        foreach ($data = Config::get('menus') as $group => $first) {
            $data[$group]['active'] = $group === $this->group;
            // 遍历：二级菜单
            if (isset($first['submenu'])) {
                foreach ($first['submenu'] as $secondKey => $second) {
                    // 二级菜单所有uri
                    $secondUris = [];
                    if (isset($second['submenu'])) {
                        // 遍历：三级菜单
                        foreach ($second['submenu'] as $thirdKey => $third) {
                            $thirdUris = [];
                            if (isset($third['uris'])) {
                                $secondUris = array_merge($secondUris, $third['uris']);
                                $thirdUris = array_merge($thirdUris, $third['uris']);
                            } else {
                                $secondUris[] = $third['index'];
                                $thirdUris[] = $third['index'];
                            }
                            $data[$group]['submenu'][$secondKey]['submenu'][$thirdKey]['active'] = in_array($this->routeUri, $thirdUris);
                        }
                    } else {
                        if (isset($second['uris']))
                            $secondUris = array_merge($secondUris, $second['uris']);
                        else
                            $secondUris[] = $second['index'];
                    }
                    // 二级菜单：active
                    !isset($data[$group]['submenu'][$secondKey]['active'])
                    && $data[$group]['submenu'][$secondKey]['active'] = in_array($this->routeUri, $secondUris);
                }
            }
        }
        return $data;
    }

    /**
     * 验证登录状态
     */
    private function checkLogin()
    {
        // 验证当前请求是否在白名单
        if (in_array($this->routeUri, $this->allowAllAction)) {
            return true;
        }
        // 验证登录状态
        if (empty($this->store)
            || (int)$this->store['is_login'] !== 1
            || !isset($this->store['wxapp'])
            || empty($this->store['wxapp'])
        ) {
			$this->redirect('passport/login');
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
