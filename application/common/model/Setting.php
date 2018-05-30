<?php

namespace app\common\model;

use think\Cache;

/**
 * 系统设置模型
 * Class Setting
 * @package app\common\model
 */
class Setting extends BaseModel
{
    protected $name = 'setting';

    /**
     * 获取器: 转义数组格式
     * @param $value
     * @return mixed
     */
    public function getValuesAttr($value)
    {
        return json_decode($value, true);
    }

    /**
     * 修改器: 转义成json格式
     * @param $value
     * @return string
     */
    public function setValuesAttr($value)
    {
        return json_encode($value);
    }

    /**
     * 获取设置项信息
     * @param $key
     * @return null|static
     * @throws \think\exception\DbException
     */
    public static function detail($key)
    {
        return self::get($key);
    }

    /**
     * 全局缓存: 系统设置
     * @return false|static[]
     * @throws \think\exception\DbException
     */
    public static function getAll()
    {
        if (!$data = Cache::get('setting')) {
            $data = array_column(collection(self::all())->toArray(), null, 'key');
            Cache::set('setting', $data);
        }
        return $data;
    }

    /**
     * 获取指定项设置
     * @param $key
     * @return array|static
     * @throws \think\exception\DbException
     */
    public static function getItem($key)
    {
        $data = self::getAll();
        return isset($data[$key]) ? $data[$key]['values'] : [];
    }

}