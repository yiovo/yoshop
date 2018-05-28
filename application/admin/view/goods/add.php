<link href="assets/admin/plugins/umeditor/themes/default/css/umeditor.css" type="text/css" rel="stylesheet">
<div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div class="widget am-cf">
                <form id="my-form" class="am-form tpl-form-line-form" enctype="multipart/form-data" method="post">
                    <div class="widget-body">
                        <fieldset>
                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl">基本设置</div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">商品名称 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <input type="text" class="tpl-form-input" name="goods[goods_name]"
                                           value="" required>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">商品分类 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <select name="goods[category_id]" data-am-selected="{searchBox: 1}" required>
                                        <option value="">请选择商品分类</option>
                                    </select>
                                    <small class="am-margin-left-xs">
                                        <a href="">去添加</a>
                                    </small>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">商品图片 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <div class="am-form-file">
                                        <div id="file-phone" class="upload-button">
                                            <i class="am-icon-cloud-upload"></i> 上传图片
                                        </div>
                                        <div id="file-list" class="uploader-list am-cf">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl">规格/库存</div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">商品规格 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <label class="am-radio-inline">
                                        <input type="radio" name="goods[spec_type]" value="10" data-am-ucheck checked>
                                        单规格
                                    </label>
                                    <label class="am-radio-inline">
                                        <input type="radio" name="goods[spec_type]" value="20" data-am-ucheck>
                                        多规格
                                    </label>
                                </div>
                                <div class="am-u-sm-9 am-u-end">
                                    <div class="goods-spec">
                                        <div class="spec-group-item">
                                            <h4 class="spec-group-name">颜色</h4>
                                            <div class="spec-list am-cf">
                                                <div class="spec-item am-fl"><span>红色</span></div>
                                                <div class="spec-item am-fl"><span>红色</span></div>
                                                <div class="spec-item am-fl"><span>红色</span></div>
                                                <div class="spec-item-add am-cf am-fl">
                                                    <input type="text" class="am-form-field am-fl">
                                                    <button type="button" class="am-btn am-fl">添加</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="spec-group-item">
                                            <h4 class="spec-group-name">颜色</h4>
                                            <div class="spec-list am-cf">
                                                <div class="spec-item am-fl"><span>红色</span></div>
                                                <div class="spec-item am-fl"><span>红色</span></div>
                                                <div class="spec-item am-fl"><span>红色</span></div>
                                                <div class="spec-item-add am-cf am-fl">
                                                    <input type="text" class="am-form-field am-fl">
                                                    <button type="button" class="am-btn am-fl">添加</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="spec-group-item">
                                            <h4 class="spec-group-name">颜色</h4>
                                            <div class="spec-list am-cf">
                                                <div class="spec-item am-fl"><span>红色</span></div>
                                                <div class="spec-item am-fl"><span>红色</span></div>
                                                <div class="spec-item am-fl"><span>红色</span></div>
                                                <div class="spec-item-add am-cf am-fl">
                                                    <input type="text" class="am-form-field am-fl">
                                                    <button type="button" class="am-btn am-fl">添加</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="spec-group-add">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">库存计算方式 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <label class="am-radio-inline">
                                        <input type="radio" name="goods[deduct_stock_type]" value="10" data-am-ucheck>
                                        下单减库存
                                    </label>
                                    <label class="am-radio-inline">
                                        <input type="radio" name="goods[deduct_stock_type]" value="20" data-am-ucheck
                                               checked>
                                        付款减库存
                                    </label>
                                </div>
                            </div>

                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl">商品详情</div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label">商品详情 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <!-- 加载编辑器的容器 -->
                                    <script id="container" name="goods[content]" type="text/plain"></script>
                                </div>
                            </div>
                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl">其他</div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">运费模板 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <select name="goods[category_id]" data-am-selected="{searchBox: 1}" required>
                                        <option value=""></option>
                                    </select>
                                    <small class="am-margin-left-xs">
                                        <a href="">去添加</a>
                                    </small>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">商品状态 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <label class="am-radio-inline">
                                        <input type="radio" name="goods[goods_status]" value="10" data-am-ucheck>
                                        上架
                                    </label>
                                    <label class="am-radio-inline">
                                        <input type="radio" name="goods[goods_status]" value="20" data-am-ucheck
                                               checked>
                                        下架
                                    </label>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label">初始销量</label>
                                <div class="am-u-sm-9 am-u-end">
                                    <input type="number" class="tpl-form-input" name="goods[sales_initial]"
                                           value="0">
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label">商品排序</label>
                                <div class="am-u-sm-9 am-u-end">
                                    <input type="number" class="tpl-form-input" name="goods[goods_sort]"
                                           value="100" required>
                                    <small>数字越小越靠前</small>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <div class="am-u-sm-9 am-u-sm-push-3 am-margin-top-lg">
                                    <button type="submit" class="j-submit am-btn am-btn-secondary">提交
                                    </button>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="assets/admin/js/jquery.dad.js"></script>
<script src="assets/admin/plugins/umeditor/umeditor.config.js"></script>
<script src="assets/admin/plugins/umeditor/umeditor.js"></script>
<script>
    $(function () {

        let um = UM.getEditor('container');

        /**
         * 表单验证提交
         * @type {*}
         */
        $('#my-form').superForm();

        // 上传商品图片
        $.uploadImages({
            pick: '#file-phone',
            list: {
                id: '#file-list',
                inputName: 'goods[image][]',
            }
        });

        // 文件列表可拖动
        $('#file-list').dad();


    });
</script>
