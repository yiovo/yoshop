<?php

namespace app\admin\controller;

/**
 * 商品管理控制器
 * Class Goods
 * @package app\admin\controller
 */
class Goods extends Controller
{

    public function index()
    {
        return $this->fetch('add');
    }

}
