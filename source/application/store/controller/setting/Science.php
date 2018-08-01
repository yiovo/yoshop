<?php

namespace app\store\controller\setting;

use app\store\controller\Controller;

/**
 * 环境检测
 * Class Science
 * @package app\store\controller\setting
 */
class Science extends Controller
{
    /**
     * 状态class
     * @var array
     */
    private $statusClass = [
        'normal' => '',
        'warning' => 'am-active',
        'danger' => 'am-danger'
    ];

    /**
     * 环境检测
     */
    public function index()
    {
        return $this->fetch('index', [
            'statusClass' => $this->statusClass,
            'phpinfo' => $this->phpinfo(),  // 服务器信息
            'server' => $this->server(), // PHP环境要求
            'writeable' => $this->writeable(), // 目录权限监测
        ]);
    }

    /**
     * 服务器信息
     * @return array
     */
    private function server()
    {
        return [
            'system' => [
                'name' => '服务器操作系统',
                'value' => PHP_OS,
                'status' => PHP_SHLIB_SUFFIX === 'dll' ? 'warning' : 'normal',
                'remark' => '建议使用 Linux 系统以提升程序性能'
            ],
            'webserver' => [
                'name' => 'Web服务器环境',
                'value' => $this->request->server('SERVER_SOFTWARE'),
                'status' => PHP_SAPI === 'isapi' ? 'warning' : 'normal',
                'remark' => '建议使用 Apache 或 Nginx 以提升程序性能'
            ],
            'php' => [
                'name' => 'PHP版本',
                'value' => PHP_VERSION,
                'status' => version_compare(PHP_VERSION, '5.4.0') === -1 ? 'danger' : 'normal',
                'remark' => 'PHP版本必须为 5.4.0 以上'
            ],
            'upload_max' => [
                'name' => '文件上传限制',
                'value' => @ini_get('file_uploads') ? ini_get('upload_max_filesize') : 'unknow',
                'status' => 'normal',
                'remark' => ''
            ],
            'web_path' => [
                'name' => '程序运行目录',
                'value' => WEB_PATH,
                'status' => 'normal',
                'remark' => ''
            ],
        ];
    }

    /**
     * PHP环境要求
     * @return array
     */
    private function phpinfo()
    {
        return [
            'php_version' => [
                'name' => 'PHP版本',
                'value' => '5.4.0及以上',
                'status' => version_compare(PHP_VERSION, '5.4.0') === -1 ? 'danger' : 'normal',
                'remark' => 'PHP版本必须为 5.4.0及以上'
            ],
            'curl' => [
                'name' => 'CURL',
                'value' => '支持',
                'status' => extension_loaded('curl') && function_exists('curl_init') ? 'normal' : 'danger',
                'remark' => '您的PHP环境不支持CURL, 系统无法正常运行'
            ],
            'openssl' => [
                'name' => 'OpenSSL',
                'value' => '支持',
                'status' => extension_loaded('openssl') ? 'normal' : 'danger',
                'remark' => '没有启用OpenSSL, 将无法访问微信平台的接口'
            ],
            'pdo' => [
                'name' => 'PDO',
                'value' => '支持',
                'status' => extension_loaded('PDO') && extension_loaded('pdo_mysql') ? 'normal' : 'danger',
                'remark' => '您的PHP环境不支持PDO, 系统无法正常运行'
            ],
            'bcmath' => [
                'name' => 'BCMath',
                'value' => '支持',
                'status' => extension_loaded('bcmath') ? 'normal' : 'danger',
                'remark' => '您的PHP环境不支持BCMath, 系统无法正常运行'
            ],
        ];

    }

    /**
     * 目录权限监测
     */
    private function writeable()
    {
        $paths = [
            'uploads' => realpath(WEB_PATH) . '/uploads/',
            'wxpay_log' => realpath(APP_PATH) . '/common/library/wechat/logs/',
            'behavior_log' => realpath(APP_PATH) . '/task/behavior/logs/',
        ];
        return [
            'uploads' => [
                'name' => '文件上传目录',
                'value' => $paths['uploads'],
                'status' => $this->checkWriteable($paths['uploads']) ? 'normal' : 'danger',
                'remark' => '目录不可写，系统将无法正常上传文件'
            ],
            'wxpay_log' => [
                'name' => '微信支付日志目录',
                'value' => $paths['wxpay_log'],
                'status' => $this->checkWriteable($paths['wxpay_log']) ? 'normal' : 'danger',
                'remark' => '目录不可写，系统将无法正常上传文件'
            ],
            'behavior_log' => [
                'name' => '自动任务日志目录',
                'value' => $paths['behavior_log'],
                'status' => $this->checkWriteable($paths['behavior_log']) ? 'normal' : 'danger',
                'remark' => '目录不可写，系统将无法正常上传文件'
            ],
        ];

    }

    /**
     * 检查目录是否可写
     * @param $path
     * @return bool
     */
    private function checkWriteable($path)
    {
        try {
            !is_dir($path) && mkdir($path, 0755);
            if (!is_dir($path))
                return false;
            $fileName = $path . '/_test_write.txt';
            if ($fp = fopen($fileName, 'w')) {
                return fclose($fp) && unlink($fileName);
            }
        } catch (\Exception $e) {
        }
        return false;
    }

}
