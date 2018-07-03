<?php

namespace app\store\model;

use app\common\model\SpecValue as SpecValueModel;

/**
 * 规格/属性(值)模型
 * Class SpecValue
 * @package app\store\model
 */
class SpecValue extends SpecValueModel
{

    /**
     * 根据规格组名称查询规格id
     * @param $spec_id
     * @param $spec_value
     * @return mixed
     */
    public function getSpecValueIdByName($spec_id, $spec_value)
    {
        return self::where(compact('spec_id', 'spec_value'))->value('spec_value_id');
    }

    /**
     * 新增规格值
     * @param $spec_id
     * @param $spec_value
     * @return false|int
     */
    public function add($spec_id, $spec_value)
    {
        $wxapp_id = self::$wxapp_id;
        return $this->save(compact('spec_value', 'spec_id', 'wxapp_id'));
    }

}
