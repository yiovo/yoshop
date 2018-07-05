<?php

namespace app\store\model;

use app\common\model\Goods as GoodsModel;
use think\Db;

/**
 * 商品模型
 * Class Goods
 * @package app\store\model
 */
class Goods extends GoodsModel
{
    /**
     * 获取规格信息
     * @param \think\Collection $spec_rel
     * @param \think\Collection $skuData
     * @return array
     */
    public function getManySpecData($spec_rel, $skuData)
    {
        // spec_attr
        $specAttrData = [];
        foreach ($spec_rel->toArray() as $item) {
            if (!isset($specAttrData[$item['spec_id']])) {
                $specAttrData[$item['spec_id']] = [
                    'group_id' => $item['spec']['spec_id'],
                    'group_name' => $item['spec']['spec_name'],
                    'spec_items' => [],
                ];
            }
            $specAttrData[$item['spec_id']]['spec_items'][] = [
                'item_id' => $item['spec_value_id'],
                'spec_value' => $item['spec_value'],
            ];
        }

        // spec_list
        $specListData = [];
        foreach ($skuData->toArray() as $item) {
            $specListData[] = [
                'goods_spec_id' => $item['goods_spec_id'],
                'spec_sku_id' => $item['spec_sku_id'],
                'rows' => [],
                'form' => [
                    'goods_no' => $item['goods_no'],
                    'goods_price' => $item['goods_price'],
                    'goods_weight' => $item['goods_weight'],
                    'line_price' => $item['line_price'],
                    'stock_num' => $item['stock_num'],
                ],
            ];
        }
        return json_encode(['spec_attr' => array_values($specAttrData), 'spec_list' => $specListData]);
    }

    /**
     * 添加商品
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
            $this->addGoodsSpec($this['goods_id'], $data['spec_type'], $data['spec'], $data['spec_many']);
            // 商品图片
            $this->addGoodsImages($data['images']);
            Db::commit();
            return true;
        } catch (\Exception $e) {
            pre($e->getMessage());
            Db::rollback();
        }
        return false;
    }

    /**
     * 添加商品规格
     * @param $goods_id
     * @param $spec_type
     * @param $spec
     * @param $spec_many
     * @throws \Exception
     */
    private function addGoodsSpec($goods_id, $spec_type, $spec, $spec_many)
    {
        if ($spec_type === '10')
            // 单规格
            $this->spec()->save($spec);
        else if ($spec_type === '20') {
            // 多规格
            $model = new GoodsSpec;
            // 添加商品与规格关系记录
            $model->addGoodsSpecRel($goods_id, $spec_many['spec_attr']);
            // 添加商品sku
            $model->addSkuList($goods_id, $spec_many['spec_list']);
        }
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
        $this->image()->delete();
        $model = new UploadFile;
        $imagesIds = $model->where('file_name', 'in', $images)
            ->column('file_id', 'file_name');
        $data = array_map(function ($val) use ($imagesIds) {
            return ['image_id' => $imagesIds[$val], 'wxapp_id' => self::$wxapp_id];
        }, $images);
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
//        Db::startTrans();
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
