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
     * 隐藏字段
     * @var array
     */
    protected $hidden = [
        'wxapp_id',
        'create_time',
        'update_time'
    ];

    /**
     * @param $user_id
     * @return false|static[]
     * @throws \think\exception\DbException
     */
    public function getList($user_id)
    {
        return self::all(compact('user_id'));
    }

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
        $province_id = Region::getIdByName($region[0], 1);
        $city_id = Region::getIdByName($region[1], 2, $province_id);
        $region_id = Region::getIdByName($region[2], 3, $city_id);
        $this->allowField(true)->save(array_merge([
            'user_id' => $user['user_id'],
            'wxapp_id' => self::$wxapp_id,
            'province_id' => $province_id,
            'city_id' => $city_id,
            'region_id' => $region_id,
        ], $data));
        // 设为默认收货地址
        !$user['address_id'] && $user->save(['address_id' => $this->getLastInsID()]);
        return true;
    }

    /**
     * 编辑收货地址
     * @param $data
     * @return false|int
     */
    public function edit($data)
    {
        // 添加收货地址
        $region = explode(',', $data['region']);
        $province_id = Region::getIdByName($region[0], 1);
        $city_id = Region::getIdByName($region[1], 2, $province_id);
        $region_id = Region::getIdByName($region[2], 3, $city_id);
        return $this->allowField(true)
            ->save(array_merge(compact('province_id', 'city_id', 'region_id'), $data));
    }

    /**
     * 设为默认收货地址
     * @param null|static $user
     * @return int
     */
    public function setDefault($user)
    {
        // 设为默认地址
        return $user->save(['address_id' => $this['address_id']]);
    }

    /**
     * 删除收货地址
     * @param null|static $user
     * @return int
     */
    public function remove($user)
    {
        // 查询当前是否为默认地址
        $user['address_id'] == $this['address_id'] && $user->save(['address_id' => 0]);
        return $this->delete();
    }

    /**
     * 收货地址详情
     * @param $user_id
     * @param $address_id
     * @return null|static
     * @throws \think\exception\DbException
     */
    public static function detail($user_id, $address_id)
    {
        return self::get(compact('user_id', 'address_id'));
    }

}
