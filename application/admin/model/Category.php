<?php

namespace app\admin\model;

use app\common\model\Category as CategoryModel;
use think\Cache;

/**
 * 商品分类模型
 * Class Category
 * @package app\admin\model
 */
class Category extends CategoryModel
{
    /**
     * 所有分类
     * @return mixed
     */
    public static function getALL()
    {
        if (!Cache::get('category_' . self::$wxapp_id)) {
            $all = $data = (new self)->column('category_id, name, parent_id', 'category_id');
            $tree = [];
            foreach ($data as $first) {
                if ($first['parent_id'] !== 0) continue;
                $twoTree = [];
                foreach ($data as $two) {
                    if ($two['parent_id'] !== $first['category_id']) continue;
                    $threeTree = [];
                    foreach ($data as $three)
                        $three['parent_id'] === $two['category_id']
                        && $threeTree[$three['category_id']] = $three;
                    !empty($threeTree) && $two['child'] = $threeTree;
                    $twoTree[$two['category_id']] = $two;
                }
                !empty($twoTree) && $first['child'] = $twoTree;
                $tree[$first['category_id']] = $first;
            }
            Cache::set('category_' . self::$wxapp_id, compact('all', 'tree'));
        }
        return Cache::get('category_' . self::$wxapp_id);
    }


    /**
     * 获取所有分类(树状结构)
     * @return mixed
     */
    public static function getCacheTree()
    {
        return self::getALL()['tree'];
    }

    /**
     * 获取所有分类
     * @return mixed
     */
    public static function getCacheAll()
    {
        return self::getALL()['all'];
    }

}
