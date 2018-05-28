<?php

namespace app\admin\controller;

use app\admin\model\UploadFile;
use app\common\library\storage\Driver;
use app\admin\model\Setting as SettingMdeol;

/**
 * 后台文件上传
 * Class Upload
 * @package app\admin\controller
 */
class Upload extends Controller
{
    private $config;

    /**
     * 构造方法
     * @throws \think\exception\DbException
     */
    public function _initialize()
    {
        parent::_initialize();
        // 存储配置信息
        $this->config = SettingMdeol::getItem('storage');
    }

    /**
     * 图片上传接口
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function images()
    {
        // 实例化存储驱动
        $Driver = new Driver($this->config);
        // 上传图片
        if (!$Driver->upload())
            return json(['code' => 1, 'msg' => '图片上传失败' . $Driver->getError()]);
        // 图片上传路径
        $filePath = $Driver->getFilePath();
        // 图片信息
        $fileInfo = $Driver->getFileInfo();
        // 添加文件库记录
        $this->addUploadFile($filePath, $fileInfo, 'image');
        // 图片上传成功
        return json(['code' => 1, 'msg' => '图片上传成功', 'data' => [
            'path' => $Driver->getFilePath()
        ]]);
    }

    /**
     * 添加文件库上传记录
     * @param $filePath
     * @param $fileInfo
     * @param $fileType
     * @return false|int
     */
    private function addUploadFile($filePath, $fileInfo, $fileType)
    {
        // 存储引擎
        $storage = $this->config['default'];
        // 上传的文件信息
        $file = $this->request->file('iFile');
        // 存储域名
        $fileUrl = isset($this->config['engine'][$storage]) ? $this->config['engine'][$storage]['domain'] : '';
        // 添加文件库记录
        return (new UploadFile)->add([
            'wxapp_id' => $this->getWxappId(),
            'storage' => $storage,
            'file_url' => $fileUrl,
            'file_path' => $filePath,
            'file_size' => $fileInfo['size'],
            'file_type' => $fileType,
            'extension' => pathinfo($fileInfo['name'], PATHINFO_EXTENSION),
        ]);

    }

}
