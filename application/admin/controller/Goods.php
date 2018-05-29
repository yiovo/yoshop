<?php

namespace app\admin\controller;

use app\admin\model\Category;
use app\admin\model\Delivery;

/**
 * 商品管理控制器
 * Class Goods
 * @package app\admin\controller
 */
class Goods extends Controller
{
    /**
     * 添加商品
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function index()
    {
        if ($this->request->isAjax()) {
            $data = $this->postData('goods');
         
            return $this->renderSuccess('添加成功', url('goods/index'));
        }
        // 商品分类
        $catgory = Category::getCacheTree();
        // 配送模板
        $delivery = Delivery::getAll();
        return $this->fetch('add', compact('catgory', 'delivery'));
    }

}
