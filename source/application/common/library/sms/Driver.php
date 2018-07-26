<?php

namespace app\common\library\sms;

use think\Exception;

/**
 * 短信通知模块驱动
 * Class driver
 * @package app\common\library\sms
 */
class Driver
{
    private $config;    // 配置信息
    private $engine;    // 当前短信引擎类
    private $engineName;    // 当前短信引擎名称

    /**
     * 构造方法
     * Driver constructor.
     * @param $config
     * @throws Exception
     */
    public function __construct($config)
    {
        // 配置信息
        $this->config = $config;
        // 当前引擎名称
        $this->engineName = $this->config['default'];
        // 实例化当前存储引擎
        $this->engine = $this->getEngineClass();
    }

    /**
     * 发送短信通知
     * @param $msgType
     * @param $templateParams
     * @param bool $isTest
     * @return bool
     */
    public function sendSms($msgType, $templateParams, $isTest = false)
    {
        if ($isTest === false
            && $this->config['engine'][$this->engineName][$msgType]['is_enable'] === '0') {
            return false;
        }
        return $this->engine->sendSms($msgType, $templateParams);
    }

    /**
     * 获取错误信息
     * @return mixed
     */
    public function getError()
    {
        return $this->engine->getError();
    }

    /**
     * 获取当前的存储引擎
     * @return mixed
     * @throws Exception
     */
    private function getEngineClass()
    {
        $classSpace = __NAMESPACE__ . '\\engine\\' . ucfirst($this->engineName);
        if (!class_exists($classSpace)) {
            throw new Exception('未找到存储引擎类: ' . $this->engineName);
        }
        return new $classSpace($this->config['engine'][$this->engineName]);
    }

}
