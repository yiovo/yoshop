<?php

namespace app\api\controller;

use app\api\model\WxappPage;

/**
 * 首页控制器
 * Class Index
 * @package app\api\controller
 */
class Index extends Controller
{
    /**
     * 首页diy数据
     * @return array
     * @throws \think\exception\DbException
     */
    public function page()
    {
        $wxappPage = WxappPage::detail();
        $items = $wxappPage['page_data']['array']['items'];
        return $this->renderSuccess(compact('items'));
    }

}
