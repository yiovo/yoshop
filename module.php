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
    }

    /**
     * 执行模块初始化操作
     */
    public function execute()
    {
        // 验证模块核心文件
        $this->checkModuleFile();
        // 自动创建小程序信息
        $this->createWechatApp();
        // 设置session登录状态
        $this->setSession();
        // 跳转到独立后台
        $this->gotoAdmin();
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
     * 获取模块中小程序记录
     */
    private function getModuleWechatApp()
    {
        $sql = "\n SELECT * FROM yoshop_wxapp WHERE wxapp_id = :wxapp_id";
        return pdo_fetch($sql, [':wxapp_id' => $this->wechat_app['uniacid']]);
    }

    /**
     * 添加新小程序记录到模块
     * @return bool
     */
    private function createWechatApp()
    {
        if (!$this->getModuleWechatApp()) {
            $time = time();
            $sql = "\n INSERT INTO yoshop_wxapp VALUES (
            {$this->wechat_app['uniacid']}, '{$this->wechat_app['name']}',
            '{$this->wechat_app['key']}', '{$this->wechat_app['secret']}',
              '',  '{$time}', '{$time}')";
            return pdo_run($sql);
        }
        return false;
    }

    /**
     * 设置session登录态
     */
    private function setSession()
    {
        @session_start();
        $_SESSION['yoshop_admin'] = [
            'wxapp' => $this->getModuleWechatApp(),
            'is_login' => true
        ];
    }

    /**
     * 跳转到模块后台
     */
    private function gotoAdmin()
    {
        global $_W;
        $url = "{$_W['siteroot']}addons/{$_W['current_module']['name']}/web/index.php?s=admin";
        header('Location:' . $url);
        exit;
    }

}

// 执行模块初始化
(new Init)->execute();
