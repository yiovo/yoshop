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
    public function getList() {
        return $this->order(['sort'=>'asc'])->select();
    }

    /**
     * 帮助详情
     * @param $help_id
     * @return null|static
     * @throws \think\exception\DbException
     */
    public static function detail($help_id) {
        return self::get($help_id);
    }

}
