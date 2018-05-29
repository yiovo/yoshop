<?php

namespace app\admin\controller;

use app\admin\model\Wxapp as WxappModel;

/**
 * 小程序管理
 * Class Wxapp
 * @package app\admin\controller
 */
class Wxapp extends Controller
{
    /**
     * 小程序设置
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function setting()
    {
        $wxapp = WxappModel::detail();
        if ($this->request->isAjax()) {
            $data = $this->postData('wxapp');
            if ($wxapp->edit($data)) return $this->renderSuccess('更新成功');
            return $this->renderError('更新失败');
        }
        return $this->fetch('setting', compact('wxapp'));
    }

}
