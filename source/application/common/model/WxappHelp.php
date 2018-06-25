<?php

namespace app\common\model;

/**
 * 小程序帮助中心
 * Class WxappHelp
 * @package app\common\model
 */
class WxappHelp extends BaseModel
{
    protected $name = 'wxapp_help';

    /**
     * 获取帮助列表
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getList()
    {
        return $this->order(['sort' => 'asc'])->select();
    }

    /**
     * 帮助详情
     * @param $help_id
     * @return null|static
     * @throws \think\exception\DbException
     */
    public static function detail($help_id)
    {
        return self::get($help_id);
    }

    /**
     * 新增默认帮助
     * @param $wxapp_id
     * @return false|int
     */
    public function insertDefault($wxapp_id)
    {
        return $this->save([
            'title' => '关于小程序',
            'content' => '小程序本身无需下载，无需注册，不占用手机内存，可以跨平台使用，响应迅速，体验接近原生APP。',
            'sort' => 100,
            'wxapp_id'=> $wxapp_id
        ]);
    }

}
