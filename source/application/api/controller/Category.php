<?php

namespace app\api\controller;

use app\api\model\Goods as GoodsModel;
use app\api\model\Category as CategoryModel;

/**
 * 商品分类控制器
 * Class Goods
 * @package app\api\controller
 */
class Category extends Controller
{
    /**
     * 分类页展示全部商品
     * @return array
     * @throws \think\exception\DbException
     */
    public function index()
    {
        // 分类列表
        $categoryList = array_values(CategoryModel::getCacheTree());
        // 商品列表
        $goodsList = (new GoodsModel)->getList($this->request->param());
        return $this->renderSuccess(compact('categoryList', 'goodsList'));
    }

    /**
     * 全部分类
     * @return array
     */
    public function lists()
    {
        $list = array_values(CategoryModel::getCacheTree());
        return $this->renderSuccess(compact('list'));
    }

}
