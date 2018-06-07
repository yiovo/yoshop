<?php

namespace app\api\model;

use app\common\model\Region;
use app\common\model\UserAddress as UserAddressModel;

/**
 * 用户收货地址模型
 * Class UserAddress
 * @package app\common\model
 */
class UserAddress extends UserAddressModel
{
    /**
     * 新增收货地址
     * @param null|static $user
     * @param $data
     * @return false|int
     */
    public function add($user, $data)
    {
        // 添加收货地址
        $region = explode(',', $data['region']);
        $this->allowField(true)->save(array_merge([
            'user_id' => $user['user_id'],
            'wxapp_id' => self::$wxapp_id,
            'province_id' => Region::getIdByName($region[0], 1),
            'city_id' => Region::getIdByName($region[1], 2),
            'region_id' => Region::getIdByName($region[2], 3),
        ], $data));
        // 设为默认收货地址
        !$user['address_id'] && $user->save(['address_id' => $this->getLastInsID()]);
        return true;
    }

}
