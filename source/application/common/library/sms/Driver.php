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
    private $config;    // sms 配置
    private $engine;    // 当前存储引擎类

    /**
     * 构造方法
     * Driver constructor.
     * @param $config
     * @throws Exception
     */
    public function __construct($config)
    {
        $this->config = $config;
        // 实例化当前存储引擎
        $this->engine = $this->getEngineClass();
    }

    /**
     * 发送短信通知
     * @param $msgType
     * @param $templateParams
     * @return mixed
     */
    public function sendSms($msgType, $templateParams)
    {
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
        $engineName = $this->config['default'];
        $classSpace = __NAMESPACE__ . '\\engine\\' . ucfirst($engineName);
        if (!class_exists($classSpace)) {
            throw new Exception('未找到存储引擎类: ' . $engineName);
        }
        return new $classSpace($this->config['engine'][$engineName]);
    }

}
