<?php

namespace app\admin\controller;

use app\admin\model\User as UserModel;

/**
 * 用户管理
 * Class User
 * @package app\admin\controller
 */
class User extends Controller
{
    /**
     * 用户列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $model = new UserModel;
        $list = $model->getList();
        return $this->fetch('index', compact('list'));
    }

}
