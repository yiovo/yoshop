<?php

namespace app\common\model;

use think\Request;

/**
 * 商品模型
 * Class Goods
 * @package app\common\model
 */
class Goods extends BaseModel
{
    protected $name = 'goods';

    /**
     * 关联商品分类表
     * @return \think\model\relation\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo('Category');
    }

    /**
     * 关联商品规格表
     * @return \think\model\relation\HasMany
     */
    public function spec()
    {
        return $this->hasMany('GoodsSpec');
    }

    /**
     * 关联商品图片表
     * @return \think\model\relation\HasMany
     */
    public function image()
    {
        return $this->hasMany('GoodsImage')->order(['id' => 'asc']);
    }

    /**
     * 计费方式
     * @param $value
     * @return mixed
     */
    public function getGoodsStatusAttr($value)
    {
        $status = [10 => '上架', 20 => '下架'];
        return ['text' => $status[$value], 'value' => $value];
    }

    /**
     * 获取商品列表
     * @param string $sortType
     * @param bool $sortPrice
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function getList($sortType = 'all', $sortPrice = false)
    {
        // 排序规则
        $sort = [];
        if ($sortType === 'all') {
            $sort = ['goods_sort', 'goods_id'];
        } elseif ($sortType === 'sales') {
            $sort = ['goods_sales' => 'desc'];
        } elseif ($sortType === 'price') {
            $sort = $sortPrice ? ['goods_max_price' => 'desc'] : ['goods_min_price'];
        }

        // 商品表名称
        $tableName = $this->getTable();

        // 多规格商品 最高价与最低价
        $GoodsSpec = new GoodsSpec;
        $minPriceSql = $GoodsSpec->field(['MIN(goods_price)'])
            ->where('goods_id', 'EXP', "= `$tableName`.`goods_id`")->buildSql();
        $maxPriceSql = $GoodsSpec->field(['MAX(goods_price)'])
            ->where('goods_id', 'EXP', "= `$tableName`.`goods_id`")->buildSql();

        // 执行查询
        $list = $this->field(['*', '(sales_initial + sales_actual) as goods_sales',
            "$minPriceSql AS goods_min_price",
            "$maxPriceSql AS goods_max_price"
        ])->with(['category', 'image.file', 'spec'])
            ->where('is_delete', '=', 0)
            ->where('goods_status', '=', 10)
            ->order($sort)
            ->paginate(10, false, [
                'query' => Request::instance()->request()
            ]);
        return $list;
    }

    /**
     * 获取商品详情
     * @param $goods_id
     * @return array|false|\PDOStatement|string|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getDetail($goods_id)
    {
//
        return $this->field(['*', '(sales_initial + sales_actual) as goods_sales'])
            ->with(['category', 'image.file', 'spec'])
            ->where('goods_id','=', $goods_id)->find();

//        return self::get($goods_id, ['category', 'image.file', 'spec']);
    }

    /**
     * 猜您喜欢 (临时方法以后作废)
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getBestList()
    {
        return $this->with(['spec', 'category', 'image.file'])
            ->where('is_delete', '=', 0)
            ->where('goods_status', '=', 10)
            ->order(['sales_initial' => 'desc', 'goods_sort' => 'asc'])
            ->limit(10)
            ->select();
    }

    /**
     * 新品推荐 (临时方法以后作废)
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getNewList()
    {
        return $this->with(['spec', 'category', 'image.file'])
            ->where('is_delete', '=', 0)
            ->where('goods_status', '=', 10)
            ->order(['goods_id' => 'desc', 'goods_sort' => 'asc'])
            ->select();
    }


}
