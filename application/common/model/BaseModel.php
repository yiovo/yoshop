<?php

namespace app\common\model;

use think\Model;
use think\Request;
use think\Session;

/**
 * 模型基类
 * Class BaseModel
 * @package app\common\model
 */
class BaseModel extends Model
{
    public static $wxapp_id;
    public static $base_url;

    /**
     * 模型基类初始化
     */
    public static function init()
    {
        parent::init();
        // 后期静态绑定类名称
        if (preg_match('/app\\\(\w+)/', get_called_class(), $match)) {
            $callfunc = "set{$match[1]}WxappId";
            self::$callfunc();
        }
        // 获取当前域名
        self::$base_url = self::baseUrl();
    }

    /**
     * 获取当前域名
     * @return string
     */
    protected static function baseUrl()
    {
        $request = Request::instance();
        return $request->scheme() . '://' . $request->host() . dirname($request->baseUrl());
    }

    /**
     * 设置wxapp_id (admin模块)
     */
    protected static function setAdminWxappId()
    {
        $session = Session::get('best_shop_admin');
        self::$wxapp_id = $session['wxapp']['wxapp_id'];
    }

    /**
     * 设置wxapp_id (api模块)
     */
    protected static function setApiWxappId() {
        $request = Request::instance();
        self::$wxapp_id  = $request->param('wxapp_id');
    }

    /**
     * 定义全局的查询范围
     * @param \think\db\Query $query
     */
    protected function base($query)
    {
        $query->where('wxapp_id', self::$wxapp_id);
    }

}
