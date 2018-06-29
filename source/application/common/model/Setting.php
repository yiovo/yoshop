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
    protected $createTime = false;

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
        return self::get(compact('key'));
    }

    /**
     * 全局缓存: 系统设置
     * @return array|mixed
     */
    public static function getAll()
    {
        $self = new static;
        if (!$data = Cache::get('setting_' . $self::$wxapp_id)) {
            $data = array_column(collection($self::all())->toArray(), null, 'key');
            Cache::set('setting_' . $self::$wxapp_id, $data);
        }
        return $data;
    }

    /**
     * 获取指定项设置
     * @param $key
     * @return array
     */
    public static function getItem($key)
    {
        $data = self::getAll();
        return isset($data[$key]) ? $data[$key]['values'] : [];
    }

    /**
     * 新增默认配置
     * @param $wxapp_id
     * @param $app_name
     * @return array|false
     * @throws \Exception
     */
    public function insertDefault($wxapp_id, $app_name)
    {
        // 添加商城默认设置记录
        $setting = [
            [
                'key' => 'storage',
                'describe' => '上传设置',
                'values' => [
                    'default' => 'local',
                    'engine' => [
                        'qiniu' => [
                            'bucket' => '',
                            'access_key' => '',
                            'secret_key' => '',
                            'domain' => ''
                        ],
                    ]
                ],
                'wxapp_id' => $wxapp_id
            ],
            [
                'key' => 'store',
                'describe' => '商城设置',
                'values' => ['name' => $app_name],
                'wxapp_id' => $wxapp_id
            ],
            [
                'key' => 'trade',
                'describe' => '交易设置',
                'values' => [
                    'order' => [
                        'close_days' => '0',
                        'receive_days' => '15',
                        'refund_days' => '0'
                    ],
                    'freight_rule' => '10',
                ],
                'wxapp_id' => $wxapp_id
            ],
        ];
        return $this->saveAll($setting);
    }

}
