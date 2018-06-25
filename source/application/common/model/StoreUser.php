<?php

namespace app\common\model;

/**
 * 商家用户模型
 * Class StoreUser
 * @package app\common\model
 */
class StoreUser extends BaseModel
{
    protected $name = 'store_user';

    /**
     * 新增默认商家用户信息
     * @param $wxapp_id
     * @return false|int
     */
    public function insertDefault($wxapp_id)
    {
        return $this->save([
            'user_name' => 'yoshop_' . $wxapp_id,
            'password' => md5(uniqid()),
            'wxapp_id' => $wxapp_id,
        ]);
    }

}
