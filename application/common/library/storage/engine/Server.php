<?php

namespace app\common\library\storage\engine;

use think\Exception;
use think\Request;

/**
 * 存储引擎抽象类
 * Class server
 * @package app\common\library\storage\drivers
 */
abstract class Server
{
    protected $file;
    protected $error;
    protected $filePath;

    /**
     * 构造函数
     * Server constructor.
     * @throws Exception
     */
    protected function __construct()
    {
        // 接收上传的文件
        $this->file = Request::instance()->file('iFile');
        if (empty($this->file)) {
            throw new Exception('未找到上传文件的信息');
        }
        // 生成保存文件名
        $this->filePath = $this->buildSaveName();
    }

    /**
     * 返回文件路径
     * @return mixed
     */
    public function getFilePath()
    {
        return $this->filePath;
    }

    /**
     * 返回错误信息
     * @return mixed
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * 文件上传
     * @return mixed
     */
    abstract protected function upload();

    /**
     * 生成保存文件名
     */
    private function buildSaveName()
    {
        // 要上传图片的本地路径
        $realPath = $this->file->getRealPath();
        // 扩展名
        $ext = pathinfo($this->file->getInfo('name'), PATHINFO_EXTENSION);
        // 自动生成文件名
        return date('YmdHis') . substr(md5($realPath), 0, 5)
            . str_pad(rand(0, 9999),4,'0',STR_PAD_LEFT) . '.' . $ext;
    }

}
