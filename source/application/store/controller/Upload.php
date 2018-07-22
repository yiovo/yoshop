<?php

namespace app\store\controller;

use app\store\model\UploadFile;
use app\common\library\storage\Driver as StorageDriver;
use app\store\model\Setting as SettingModel;

/**
 * 文件库管理
 * Class Upload
 * @package app\store\controller
 */
class Upload extends Controller
{
    private $config;

    /**
     * 构造方法
     */
    public function _initialize()
    {
        parent::_initialize();
        // 存储配置信息
        $this->config = SettingModel::getItem('storage');
    }

    /**
     * 文件库列表
     * @param string $type
     * @param int $group_id
     * @return \think\response\Json
     */
    public function library($type = 'image', $group_id = -1)
    {
        $data = [
            'file_group' => [
                ['group_id' => 10001, 'group_name' => '商品封面'],
                ['group_id' => 10002, 'group_name' => '商品详情']
            ],
            'file_list' => [
                [
                    'file_id' => 1,
                    'file_name' => 'test1.jpg',
                    'file_path' => 'http://img.zhichiwangluo.com/zcimgdir/album/file_5b509c90a08c1.jpg',
                ],
                [
                    'file_id' => 2,
                    'file_name' => 'test2.jpg',
                    'file_path' => 'https://image-c.weimobwmc.com/saas-wxbiz/6ad060cd46694f8985ac17c3ea622f38.jpg'
                ],
                [
                    'file_id' => 3,
                    'file_name' => 'test3.jpg',
                    'file_path' => 'http://img.zhichiwangluo.com/zcimgdir/album/file_5b509ad3e1d24.jpg'
                ],
                [
                    'file_id' => 4,
                    'file_name' => 'test4.jpg',
                    'file_path' => 'http://img.weiye.me/zcimgdir/album/file_581c3e72cfcc4.gif'
                ],
                [
                    'file_id' => 5,
                    'file_name' => 'test5.jpg',
                    'file_path' => 'http://img.zhichiwangluo.com/zcimgdir/album/file_5ad0751fdc2cb.png'
                ],
            ],
            'active_group_id' => (int)$group_id,

        ];
        shuffle($data['file_list']);
        return json($data);
    }

    /**
     * 图片上传接口
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function images()
    {
        // 实例化存储驱动
        $StorageDriver = new StorageDriver($this->config);
        // 上传图片
        if (!$StorageDriver->upload())
            return json(['code' => 1, 'msg' => '图片上传失败' . $StorageDriver->getError()]);
        // 图片上传路径
        $fileName = $StorageDriver->getFileName();
        // 图片信息
        $fileInfo = $StorageDriver->getFileInfo();
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
