<?php

defined('IN_IA') or exit('Access Denied');

/**
 * 模块入口文件 (初始化)
 * Class Init
 */
class Init
{
    private $wechat_app;

    /**
     * 构造方法
     * Init constructor.
     */
    public function __construct()
    {
        global $_W;
        $this->wechat_app = $_W['account'];  // 小程序信息

//        echo '<pre>';
//        print_r($this->wechat_app);
//        die;
    }

    /**
     * 执行模块初始化操作
     */
    public function execute()
    {
        // 验证模块核心文件
        $this->checkModuleFile();

        // 设置session登录状态
        $this->session();

        // 跳转到独立后台
        $this->passport();
    }

    /**
     * 验证模块核心文件
     */
    private function checkModuleFile()
    {
        $module_file = __DIR__ . '/web/index.php';
        !file_exists($module_file) && itoast('模块文件不存在', referer(), 'error');
    }

    /**
     * 设置session登录态
     */
    private function session()
    {
        @session_start();
        $_SESSION['yoshop_store'] = [
            'wxapp' => [
                'wxapp_id' => $this->wechat_app['uniacid']
            ],
            'we7_data' => [
                'wxapp_id' => $this->wechat_app['uniacid'],
                'app_name' => $this->wechat_app['name'],
                'app_id' => $this->wechat_app['key'],
                'app_secret' => $this->wechat_app['secret'],
            ],
            'is_login' => true
        ];
    }

    /**
     * 跳转到模块后台
     */
    private function passport()
    {
        global $_W;
        $passport = 'index.php?s=store/passport/we7login';
        $url = "{$_W['siteroot']}addons/{$_W['current_module']['name']}/web/" . $passport;
        header('Location:' . $url);
        exit;
    }

}

// 执行模块初始化
(new Init)->execute();
