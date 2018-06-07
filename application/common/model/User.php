<?php

namespace app\common\model;

use think\Request;

/**
 * 用户模型类
 * Class User
 * @package app\common\model
 */
class User extends BaseModel
{
    protected $name = 'user';

    // 性别
    private $gender = ['未知', '男', '女'];

    /**
     * 关联收货地址表
     * @return \think\model\relation\HasOne
     */
    public function addressDefault() {
        return $this->hasOne('UserAddress');
    }

    /**
     * 显示性别
     * @param $value
     * @return mixed
     */
    public function getGenderAttr($value) {
        return $this->gender[$value];
    }

    /**
     * 获取用户列表
     * @param $wxapp_id
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function getList($wxapp_id)
    {
        $request = Request::instance();
        $filter = ['wxapp_id' => $wxapp_id];
        return $this->where($filter)
            ->order(['create_time' => 'desc', 'user_id' => 'desc'])
            ->paginate(15, false, ['query' => $request->request()]);
    }

    /**
     * 获取用户信息
     * @param $where
     * @return null|static
     * @throws \think\exception\DbException
     */
    public static function detail($where) {
        return self::get($where, ['addressDefault']);
    }

}
