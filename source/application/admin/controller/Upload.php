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
        $fileName = $Driver->getFileName();
        // 图片信息
        $fileInfo = $Driver->getFileInfo();
        // 添加文件库记录
        $uploadFile = $this->addUploadFile($fileName, $fileInfo, 'image');
        // 图片上传成功
        return json(['code' => 1, 'msg' => '图片上传成功', 'data' => [
            'path' => $uploadFile['file_name'],
            'file_path' => $uploadFile['file_path'],
        ]]);
    }

    /**
     * 添加文件库上传记录
     * @param $fileName
     * @param $fileInfo
     * @param $fileType
     * @return UploadFile
     */
    private function addUploadFile($fileName, $fileInfo, $fileType)
    {
        // 存储引擎
        $storage = $this->config['default'];
        // 存储域名
        $fileUrl = isset($this->config['engine'][$storage]) ? $this->config['engine'][$storage]['domain'] : '';
        // 添加文件库记录
        $model = new UploadFile;
        $model->add([
            'wxapp_id' => $this->getWxappId(),
            'storage' => $storage,
            'file_url' => $fileUrl,
            'file_name' => $fileName,
            'file_size' => $fileInfo['size'],
            'file_type' => $fileType,
            'extension' => pathinfo($fileInfo['name'], PATHINFO_EXTENSION),
        ]);
        return $model;
    }

}
