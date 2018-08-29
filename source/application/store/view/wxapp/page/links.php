<div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div class="widget am-cf">
                <div class="widget-body">
                    <div class="widget-head am-cf">
                        <div class="widget-title am-fl">页面链接</div>
                    </div>
                    <div class="link-list">
                        <ul class="">
                            <li class="link-item">
                                <div class="row page-name">商城首页</div>
                                <div class="row am-cf">
                                    <div class="am-fl">地址：</div>
                                    <div class="am-fl">
                                        <span class="x-color-green">pages/index/index</span>
                                    </div>
                                </div>
                            </li>
                            <li class="link-item">
                                <div class="row page-name">分类页面</div>
                                <div class="row am-cf">
                                    <div class="am-fl">地址：</div>
                                    <div class="am-fl">
                                        <span class="x-color-green">pages/category/index</span>
                                    </div>
                                </div>
                            </li>
                            <li class="link-item">
                                <div class="row page-name">商品列表</div>
                                <div class="row am-cf">
                                    <div class="am-fl">地址：</div>
                                    <div class="am-fl">
                                        <span class="x-color-green">pages/category/list</span>
                                    </div>
                                </div>
                                <div class="row am-cf">
                                    <div class="am-fl">参数：</div>
                                    <div class="am-fl">
                                        <p class="param">
                                            <span class="x-color-green">category_id</span>
                                            <span>商品分类ID</span>
                                            <span class="">　--选填</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="row am-cf">
                                    <div class="am-fl">例如：</div>
                                    <div class="am-fl">
                                        <span class="x-color-c-gray-5f">pages/category/list?category_id=10001</span>
                                    </div>
                                </div>
                            </li>
                            <li class="link-item">
                                <div class="row page-name">商品详情</div>
                                <div class="row am-cf">
                                    <div class="am-fl">地址：</div>
                                    <div class="am-fl">
                                        <span class="x-color-green">pages/goods/index</span>
                                    </div>
                                </div>
                                <div class="row am-cf">
                                    <div class="am-fl">参数：</div>
                                    <div class="am-fl">
                                        <p class="param">
                                            <span class="x-color-green">goods_id</span>
                                            <span>商品ID</span>
                                            <span class="x-color-red">　--必填</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="row am-cf">
                                    <div class="am-fl">例如：</div>
                                    <div class="am-fl">
                                        <span class="x-color-c-gray-5f">pages/goods/index?goods_id=10001</span>
                                    </div>
                                </div>
                            </li>
                            <li class="link-item">
                                <div class="row page-name">搜索页</div>
                                <div class="row am-cf">
                                    <div class="am-fl">地址：</div>
                                    <div class="am-fl">
                                        <span class="x-color-green">pages/search/index</span>
                                    </div>
                                </div>
                            </li>
                            <li class="link-item">
                                <div class="row page-name">购物车页面</div>
                                <div class="row am-cf">
                                    <div class="am-fl">地址：</div>
                                    <div class="am-fl">
                                        <span class="x-color-green">pages/flow/index</span>
                                    </div>
                                </div>
                            </li>
                            <li class="link-item">
                                <div class="row page-name">个人中心</div>
                                <div class="row am-cf">
                                    <div class="am-fl">地址：</div>
                                    <div class="am-fl">
                                        <span class="x-color-green">pages/user/index</span>
                                    </div>
                                </div>
                            </li>
                            <li class="link-item">
                                <div class="row page-name">订单列表</div>
                                <div class="row am-cf">
                                    <div class="am-fl">地址：</div>
                                    <div class="am-fl">
                                        <span class="x-color-green">pages/order/index</span>
                                    </div>
                                </div>
                                <div class="row am-cf">
                                    <div class="am-fl">参数：</div>
                                    <div class="am-fl">
                                        <p class="param">
                                            <span class="x-color-green">dataType</span>
                                            <span>订单类型 ( </span>
                                            <span class="x-color-green">all</span>
                                            <span>全部，</span>
                                            <span class="x-color-green">payment</span>
                                            <span>已付款，</span>
                                            <span class="x-color-green">delivery</span>
                                            <span>待发货，</span>
                                            <span class="x-color-green">received</span>
                                            <span>待收货</span>
                                            <span>)</span>
                                            <span class="">　--选填</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="row am-cf">
                                    <div class="am-fl">例如：</div>
                                    <div class="am-fl">
                                        <span class="x-color-c-gray-5f">pages/order/index?dataType=all</span>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {

        /**
         * 表单验证提交
         * @type {*}
         */
        $('#my-form').superForm();

    });
</script>
