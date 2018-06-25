<?php
namespace app\store\controller;

/**
 * 后台首页
 * Class Index
 * @package app\store\controller
 */
class Index extends Controller
{
    public function index()
    {
        return $this->fetch('index');
    }

    public function demolist()
    {
        return $this->fetch('demo-list');
    }


}
