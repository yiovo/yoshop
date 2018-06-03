<?php

namespace app\admin\model;

use app\common\model\WxappPage as WxappPageModel;

/**
 * 微信小程序diy页面模型
 * Class WxappPage
 * @package app\common\model
 */
class WxappPage extends WxappPageModel
{

    /**
     * 自动转换data为json格式
     * @param $value
     * @return string
     */
    public function setPageDataAttr($value)
    {
        return json_encode($value);
    }

    /**
     * 更新页面数据
     * @param $page_data
     * @return bool
     */
    public function edit($page_data) {
        return $this->save(['page_data' => $page_data]) !== false;
    }

}
