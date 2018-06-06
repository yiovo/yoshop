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
        // 获取当前域名
        self::$base_url = self::baseUrl();
        // 后期静态绑定类名称
        self::staticBindWxappId(get_called_class());
    }

    /**
     * 后期静态绑定类名称
     * 用于定义全局查询范围的wxapp_id条件
     * 子类调用方式:
     *   非静态方法:  self::$wxapp_id
     *   静态方法中:  $self = new static();   $self::$wxapp_id
     * @param $calledClass
     */
    public static function staticBindWxappId($calledClass)
    {
        if (preg_match('/app\\\(\w+)/', $calledClass, $match)) {
            $callfunc = 'set' . $match[1] . 'WxappId';
            self::$callfunc();
        }
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
    protected static function setApiWxappId()
    {
        $request = Request::instance();
        self::$wxapp_id = $request->param('wxapp_id');
    }

    /**
     * 设置wxapp_id (common模块)
     */
    protected static function setCommonWxappId()
    {
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
     * 定义全局的查询范围
     * @param \think\db\Query $query
     */
    protected function base($query)
    {
        $query->where('wxapp_id', self::$wxapp_id);
    }

}
