<?php

namespace app\common\model;

use app\common\exception\BaseException;
use think\Cache;

/**
 * 微信小程序模型
 * Class Wxapp
 * @package app\common\model
 */
class Wxapp extends BaseModel
{
    protected $name = 'wxapp';

    /**
     * 小程序导航
     * @return \think\model\relation\HasOne
     */
    public function navbar()
    {
        return $this->hasOne('WxappNavbar');
    }

    /**
     * 小程序页面
     * @return \think\model\relation\HasOne
     */
    public function diyPage()
    {
        return $this->hasOne('WxappPage');
    }

    /**
     * 在线客服图标
     * @return \think\model\relation\BelongsTo
     */
    public function serviceImage()
    {
        return $this->belongsTo('uploadFile', 'service_image_id');
    }

    /**
     * 电话客服图标
     * @return \think\model\relation\BelongsTo
     */
    public function phoneImage()
    {
        return $this->belongsTo('uploadFile', 'phone_image_id');
    }

    /**
     * 获取小程序信息
     * @return null|static
     * @throws \think\exception\DbException
     */
    public static function detail()
    {
        return self::get([], ['serviceImage', 'phoneImage']);
    }

    /**
     * 从缓存中获取小程序信息
     * @return array|mixed
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public static function getWxappCache()
    {
        $self = new static();
        if (!$data = Cache::get('wxapp_' . $self::$wxapp_id)) {
            $data = self::get([], ['serviceImage', 'phoneImage', 'navbar']);
            if (empty($data)) throw new BaseException(['msg' => '未找到当前小程序信息']);
            Cache::set('wxapp_' . $self::$wxapp_id, $data);
        }
        return $data;
    }


    public static function getWxConfig()
    {
        $self = new static();
        return self::get([]);
//        return $self->field(['app_id', 'app_secret', 'mchid', 'apikey'])->find();

    }


}
