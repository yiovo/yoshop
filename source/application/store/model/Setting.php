<?php

namespace app\store\model;

use app\common\model\Setting as SettingModel;
use think\Cache;

/**
 * 系统设置模型
 * Class Wxapp
 * @package app\store\model
 */
class Setting extends SettingModel
{
    /**
     * 更新系统设置
     * @param $key
     * @param $values
     * @return bool
     */
    public function edit($key, $values)
    {
        $describe = '';
        switch ($key) {
            case 'sms':
                $describe = '短信通知';
                break;
            case 'storage':
                $describe = '上传设置';
                break;
            case 'store':
                $describe = '商城设置';
                break;
            case 'trade':
                $describe = '交易设置';
                break;
        }
        // 删除系统设置缓存
        Cache::rm('setting_' . self::$wxapp_id);
        return $this->save([
            'key' => $key,
            'describe' => $describe,
            'values' => $values,
            'wxapp_id' => self::$wxapp_id,
        ]) !== false ?: false;
    }

}
