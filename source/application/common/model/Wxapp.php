<?php

namespace app\common\model;

use app\common\exception\BaseException;
use think\Cache;
use think\Db;

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
     * @param null $wxapp_id
     * @return mixed|null|static
     * @throws BaseException
     * @throws \think\exception\DbException
     */
    public static function getWxappCache($wxapp_id = null)
    {
        if (is_null($wxapp_id)) {
            $self = new static();
            $wxapp_id = $self::$wxapp_id;
        }
        if (!$data = Cache::get('wxapp_' . $wxapp_id)) {
            $data = self::get($wxapp_id, ['serviceImage', 'phoneImage', 'navbar']);
            if (empty($data)) throw new BaseException(['msg' => '未找到当前小程序信息']);
            Cache::set('wxapp_' . $wxapp_id, $data);
        }
        return $data;
    }

    /**
     * 创建小程序
     * @param $data
     * @return bool
     * @throws \Exception
     */
    public function add($data)
    {
        Db::startTrans();

        // 添加小程序记录
        $this->save($data);

        // 商城默认设置
        $Setting = new Setting;
        $Setting->insertDefault($data['wxapp_id'], $data['app_name']);

        // 新增商家用户信息
        $StoreUser = new StoreUser;
        $StoreUser->insertDefault($data['wxapp_id']);

        // 新增小程序默认帮助
        $Help = new WxappHelp;
        $Help->insertDefault($data['wxapp_id']);

        // 新增小程序导航栏默认设置
        $Navbar = new WxappNavbar;
        $Navbar->insertDefault($data['wxapp_id'], $data['app_name']);

        // 新增小程序diy配置
        $Page = new WxappPage;
        $Page->insertDefault($data['wxapp_id']);

        Db::commit();

        return true;
    }

}
