<?php

namespace app\common\library\sms\engine;


abstract class Server
{
    protected $error;

    /**
     * 返回错误信息
     * @return mixed
     */
    public function getError()
    {
        return $this->error;
    }

}
