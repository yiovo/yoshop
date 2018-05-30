<?php

namespace app\admin\model;

use app\common\model\Goods as GoodsModel;
use think\Db;

/**
 * 商品模型
 * Class Goods
 * @package app\admin\model
 */
class Goods extends GoodsModel
{
    /**
     * 添加新记录
     * @param array $data
     * @return bool
     */
    public function add(array $data)
    {
        if (!isset($data['images']) || empty($data['images'])) {
            $this->error = '请上传商品图片';
            return false;
        }
        $data['content'] = isset($data['content']) ? $data['content'] : '';
        $data['wxapp_id'] = $data['spec']['wxapp_id'] = self::$wxapp_id;

        // 开启事务
        Db::startTrans();
        try {
            // 添加商品
            $this->allowField(true)->save($data);
            // 商品规格
            $this->spec()->save($data['spec']);
            // 商品图片
            $this->addGoodsImages($data['images']);
            Db::commit();
            return true;
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
        }
        return false;
    }

    /**
     * 添加商品图片
     * @param $images
     * @return int
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    private function addGoodsImages($images)
    {
        $model = new UploadFile;
        $imagesIds = $model->where('file_name', 'in', $images)->column('file_id');
        $data = [];
        foreach ($imagesIds as $imageId) {
            $data[] = [
                'image_id' => $imageId,
                'wxapp_id' => self::$wxapp_id
            ];
        }
        $this->image()->delete();
        return $this->image()->saveAll($data);
    }

    /**
     * 编辑商品
     * @param $data
     * @return bool
     */
    public function edit($data)
    {
        if (!isset($data['images']) || empty($data['images'])) {
            $this->error = '请上传商品图片';
            return false;
        }
        $data['content'] = isset($data['content']) ? $data['content'] : '';
        $data['wxapp_id'] = $data['spec']['wxapp_id'] = self::$wxapp_id;

        // 开启事务
        Db::startTrans();
        try {
            // 保存商品
            $this->allowField(true)->save($data);
            // 商品规格
//            $this->spec()->delete();
            $this->spec()->update($data['spec']);
            // 商品图片
            $this->addGoodsImages($data['images']);
            Db::commit();
            return true;
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
        }
        return false;
    }

    /**
     * 删除商品
     * @return int
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function remove()
    {
        $this->spec()->delete();
        $this->image()->delete();
        return $this->delete();
    }

}
