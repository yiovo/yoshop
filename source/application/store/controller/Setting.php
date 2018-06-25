<?php

namespace app\store\controller;

use app\store\model\Setting as SettingModel;

/**
 * 系统设置
 * Class Setting
 * @package app\store\controller
 */
class Setting extends Controller
{
    /**
     * 商城设置
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function store()
    {
        $store = SettingModel::detail('store');
        if (!$this->request->isAjax()) {
            $values = $store['values'];
            return $this->fetch('store', compact('values'));
        }
        if ($store->edit($this->postData('store'))) {
            return $this->renderSuccess('更新成功');
        }
        return $this->renderError('更新失败');
    }

    /**
     * 交易设置
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function trade()
    {
        $store = SettingModel::detail('trade');
        if (!$this->request->isAjax()) {
            $values = $store['values'];
            return $this->fetch('trade', compact('values'));
        }
        if ($store->edit($this->postData('trade'))) {
            return $this->renderSuccess('更新成功');
        }
        return $this->renderError('更新失败');
    }

    /**
     * 上传设置
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function upload()
    {
        $store = SettingModel::detail('storage');
        if (!$this->request->isAjax()) {
            $values = $store['values'];
            return $this->fetch('upload', compact('values'));
        }
        if ($store->edit($this->postData('storage'))) {
            return $this->renderSuccess('更新成功');
        }
        return $this->renderError('更新失败');
    }

}
