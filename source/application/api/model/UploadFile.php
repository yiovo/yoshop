<?php

namespace app\api\model;

use app\common\model\UploadFile as UploadFileModel;

/**
 * 文件库模型
 * Class UploadFile
 * @package app\api\model
 */
class UploadFile extends UploadFileModel
{
    /**
     * 隐藏字段
     * @var array
     */
    protected $hidden = [
        'wxapp_id',
        'create_time',
    ];

}
