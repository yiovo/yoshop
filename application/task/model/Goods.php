<?php

namespace app\task\model;

use app\common\model\Goods as GoodsModel;

/**
 * 商品模型
 * Class Goods
 * @package app\task\model
 */
class Goods extends GoodsModel
{

    public function updateStock($goodsData)
    {
        $this->doLogs(
           print_r(
               $goodsData->toArray(),
               true
           )
        );
    }

    /**
     * 写入日志记录
     * @param $values
     */
    private function doLogs($values)
    {
        if (is_array($values))
            $values = print_r($values, true);

        // 日志内容
        $content = '[' . date('Y-m-d H:i:s') . ']' . PHP_EOL . $values . PHP_EOL . PHP_EOL;

        // 日志路径
        $path = __DIR__ . '/logs/' . date('Ymd') . '.log';
        file_put_contents($path, $content, FILE_APPEND);
    }

}
