<?php

namespace app\store\model;

use app\common\model\Wxapp as WxappModel;
use think\Cache;

/**
 * 微信小程序模型
 * Class Wxapp
 * @package app\store\model
 */
class Wxapp extends WxappModel
{
    /**
     * 更新小程序设置
     * @param $data
     * @return bool
     */
    public function edit($data)
    {
        // 在线客服图标
        $service_image = isset($data['service_image']) ? $data['service_image'] : null;
        $data['service_image_id'] = $this->uploadImage(
            $this->wxapp_id,
            $this->service_image_id,
            $service_image,
            'service'
        );
        // 电话客服图标
        $phone_image = isset($data['phone_image']) ? $data['phone_image'] : null;
        $data['phone_image_id'] = $this->uploadImage(
            $this->wxapp_id,
            $this->phone_image_id,
            $phone_image,
            'service.phone'
        );
        // 删除wxapp缓存
        self::deleteCache();
        return $this->allowField(true)->save($data) !== false;
    }

    /**
     * 记录图片信息
     * @param $wxapp_id
     * @param $oldFileId
     * @param $newFileName
     * @param $fromType
     * @return int|mixed
     */
    private function uploadImage($wxapp_id, $oldFileId, $newFileName, $fromType)
    {
//        $UploadFile = new UploadFile;
        $UploadFileUsed = new UploadFileUsed;
        if ($oldFileId > 0) {
            // 获取原图片path
            $oldFileName = UploadFile::getFileName($oldFileId);
            // 新文件与原来路径一致, 代表用户未修改, 不做更新
            if ($newFileName === $oldFileName)
                return $oldFileId;
            // 删除原文件使用记录
            $UploadFileUsed->remove('service', $oldFileId);
        }
        // 删除图片
        if (empty($newFileName)) return 0;
        // 查询新文件file_id
        $fileId = UploadFile::getFildIdByName($newFileName);
        // 添加文件使用记录
        $UploadFileUsed->add([
            'file_id' => $fileId,
            'wxapp_id' => $wxapp_id,
            'from_type' => $fromType
        ]);
        return $fileId;
    }

    /**
     * 删除wxapp缓存
     * @return bool
     */
    public static function deleteCache()
    {
        return Cache::rm('wxapp_' . self::$wxapp_id);
    }

}
