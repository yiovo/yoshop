<?php

namespace app\common\model;

/**
 * 文件库模型
 * Class UploadFile
 * @package app\common\model
 */
class UploadFile extends BaseModel
{
    protected $name = 'upload_file';
    protected $updateTime = false;

    public function getFileUrlAttr($file_url, $data)
    {
        if ($data['storage'] === 'local') {
            $full_path = self::$base_url . DS . $data['file_path'];
        } else {
            $full_path = $file_url . DS . $data['file_path'];
        }
        return compact('file_url', 'full_path');
    }

}
