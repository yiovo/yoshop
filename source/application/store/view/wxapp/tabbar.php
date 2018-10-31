<div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div class="widget am-cf">
                <form id="my-form" class="am-form tpl-form-line-form" enctype="multipart/form-data" method="post">
                    <div class="widget-body">
                        <fieldset>
                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl">顶部导航设置</div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label form-require"> 小程序标题 </label>
                                <div class="am-u-sm-9">
                                    <input type="text" class="tpl-form-input" name="tabbar[wxapp_title]"
                                           value="<?= $model['wxapp_title'] ?>">
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label form-require">顶部导航文字颜色 </label>
                                <div class="am-u-sm-9">
                                    <label class="am-radio-inline">
                                        <input type="radio" name="tabbar[top_text_color]" value="10" data-am-ucheck
                                            <?= $model['top_text_color']['value'] == 10 ? 'checked' : '' ?>> 黑色
                                    </label>
                                    <label class="am-radio-inline">
                                        <input type="radio" name="tabbar[top_text_color]" value="20" data-am-ucheck
                                            <?= $model['top_text_color']['value'] == 20 ? 'checked' : '' ?>> 白色
                                    </label>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label form-require">顶部导航背景色 </label>
                                <div class="am-u-sm-9 am-padding-top-xs">
                                    <input type="color" class="tpl-form-input" name="tabbar[top_background_color]"
                                           value="<?= $model['top_background_color'] ?>" required>
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
<script>
    $(function () {

        /**
         * 表单验证提交
         * @type {*}
         */
        $('#my-form').superForm();

    });
</script>
