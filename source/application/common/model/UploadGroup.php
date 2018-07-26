<?php

namespace app\common\model;

/**
 * 文件库分组模型
 * Class UploadGroup
 * @package app\common\model
 */
class UploadGroup extends BaseModel
{
    protected $name = 'upload_group';

    /**
     * 分组详情
     * @param $group_id
     * @return null|static
     * @throws \think\exception\DbException
     */
    public static function detail($group_id) {
        return self::get($group_id);
    }

}
