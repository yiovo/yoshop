<?php

namespace app\admin\controller\goods;

use app\admin\controller\Controller;
use app\admin\model\Category as CategoryModel;

/**
 * 商品分类
 * Class Category
 * @package app\admin\controller\goods
 */
class Category extends Controller
{
    /**
     * 商品分类列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $model = new CategoryModel;
        $list = $model->getCacheTree();
        return $this->fetch('index', compact('list'));
    }

}
