<?php

namespace app\common\model;

/**
 * 商品图片模型
 * Class GoodsImage
 * @package app\common\model
 */
class GoodsImage extends BaseModel
{
    protected $name = 'goods_image';
    protected $updateTime = false;

    /**
     * 关联文件库
     * @return \think\model\relation\BelongsTo
     */
    public function file()
    {
        return $this->belongsTo('UploadFile', 'image_id', 'file_id')
            ->bind(['file_path', 'file_name', 'file_url']);
    }

}
