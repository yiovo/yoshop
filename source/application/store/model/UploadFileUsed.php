<?php

namespace app\store\model;

use app\common\model\UploadFileUsed as UploadFileUsedModel;

/**
 * 已上传文件使用记录表MO型
 * Class UploadFileUsed
 * @package app\store\model
 */
class UploadFileUsed extends UploadFileUsedModel
{
    protected $updateTime = false;

    /**
     * 新增记录
     * @param $data
     * @return false|int
     */
    public function add($data) {
        return $this->save($data);
    }

    /**
     * 移除记录
     * @param $from_type
     * @param $file_id
     * @param null $from_id
     * @return int
     */
    public function remove($from_type, $file_id, $from_id = null)
    {
        $where = compact('from_type', 'file_id');
        !is_null($from_id) && $where['from_id'] = $from_id;
        return $this->where($where)->delete();
    }
}
