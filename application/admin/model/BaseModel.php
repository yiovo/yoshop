<?php
/**
 * Created by PhpStorm.
 * User: xany
 * Date: 2018/5/16
 * Time: 下午10:49
 */

namespace app\admin\model;

use app\common\model\BaseModel as CommonBaseModel;
use think\Session;

class BaseModel extends CommonBaseModel
{

    // 定义全局的查询范围
    protected function base($query)
    {
        $query->where('status', 1);
    }
}
