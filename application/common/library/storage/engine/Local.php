<?php

namespace app\common\library\storage\engine;

/**
 * 本地文件驱动
 * Class Local
 * @package app\common\library\storage\drivers
 */
class Local extends Server
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 上传图片文件
     * @return array|bool
     */
    public function upload()
    {
        // 上传目录
        $uplodDir = ROOT_PATH . 'web' . DS.'uploads' ;
        // 验证文件并上传
        $info = $this->file->validate(['size' => 4 * 1024 * 1024, 'ext' => 'jpg,jpeg,png,gif'])
            ->move($uplodDir, $this->filePath);
        if (empty($info)) {
            $this->error = $this->file->getError();
            return false;
        }
        return true;
    }

}
