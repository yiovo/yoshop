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
    protected $append = ['file_path'];

    /**
     * 获取图片完整路径
     * @param $value
     * @param $data
     * @return string
     */
    public function getFilePathAttr($value, $data)
    {
        if ($data['storage'] === 'local') {
            return self::$base_url . 'uploads/' . $data['file_name'];
        }
        return $data['file_url'] . '/' . $data['file_name'];
    }

    /**
     * 兼容写法 (即将废弃)
     * @param $value
     * @param $data
     * @return array
     */
//    public function getFileNameAttr($value, $data)
//    {
//        if ($data['storage'] === 'local') {
//            $file_path = self::$base_url . 'uploads' . DS . $data['file_name'];
//        } else {
//            $file_path = $data['file_url'] . DS . $data['file_name'];
//        }
//        return compact('file_path', 'value');
//    }

    /**
     * 根据文件名查询文件id
     * @param $fileName
     * @return mixed
     */
    public static function getFildIdByName($fileName)
    {
        return (new static)->where(['file_name' => $fileName])->value('file_id');
    }

    /**
     * 查询文件id
     * @param $fileId
     * @return mixed
     */
    public static function getFileName($fileId)
    {
        return (new static)->where(['file_id' => $fileId])->value('file_name');
    }

}
