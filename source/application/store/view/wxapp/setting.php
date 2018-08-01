<div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div class="widget am-cf">
                <form id="my-form" class="am-form tpl-form-line-form" enctype="multipart/form-data" method="post">
                    <div class="widget-body">
                        <fieldset>
                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl">小程序设置</div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label form-require">
                                    AppID <span class="tpl-form-line-small-title">小程序ID</span>
                                </label>
                                <div class="am-u-sm-9">
                                    <input type="text" class="tpl-form-input" name="wxapp[app_id]"
                                           value="<?= $wxapp['app_id'] ?>" required>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label form-require">
                                    AppSecret <span class="tpl-form-line-small-title">小程序密钥</span>
                                </label>
                                <div class="am-u-sm-9">
                                    <input type="text" class="tpl-form-input" name="wxapp[app_secret]"
                                           value="<?= $wxapp['app_secret'] ?>" required>
                                </div>
                            </div>
                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl">微信支付设置</div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label">
                                    微信支付商户号 <span class="tpl-form-line-small-title">MCHID</span>
                                </label>
                                <div class="am-u-sm-9">
                                    <input type="text" class="tpl-form-input" name="wxapp[mchid]"
                                           value="<?= $wxapp['mchid'] ?>">
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label">
                                    微信支付密钥 <span class="tpl-form-line-small-title">APIKEY</span>
                                </label>
                                <div class="am-u-sm-9">
                                    <input type="text" class="tpl-form-input" name="wxapp[apikey]"
                                           value="<?= $wxapp['apikey'] ?>">
                                </div>
                            </div>

                            <!--
                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl">在线客服</div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label">
                                    在线客服
                                </label>
                                <div class="am-u-sm-9">
                                    <label class="am-radio-inline">
                                        <input type="radio" name="wxapp[is_service]" value="1" data-am-ucheck
                                            <?= $wxapp['is_service'] ? 'checked' : '' ?>> 开启
                                    </label>
                                    <label class="am-radio-inline">
                                        <input type="radio" name="wxapp[is_service]" value="0" data-am-ucheck
                                            <?= $wxapp['is_service'] ? '' : 'checked' ?>> 关闭
                                    </label>
                                    <div class="help-block">
                                        <small>客服图标显示位置：首页、商品详情页、用户中心页、订单详情页
                                            <a href="https://mpkf.weixin.qq.com/" target="_blank">客服登录地址</a>
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label">
                                    客服图标
                                </label>
                                <div class="am-u-sm-9">
                                    <div class="am-form-file">
                                        <div class="upload-file" data-name="wxapp[service_image]">
                                            <i class="am-icon-cloud-upload"></i> 上传图片
                                        </div>
                                        <div class="uploader-list am-cf">
                                            <?php if ($wxapp['service_image']): ?>
                                                <div class="file-item thumbnail">
                                                    <img src="<?= $wxapp['service_image']['file_path'] ?>">
                                                    <input type="hidden" name="wxapp[service_image]"
                                                           value="<?= $wxapp['service_image']['file_name'] ?>">
                                                    <i class="iconfont icon-shanchu file-item-delete"></i>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl">电话客服</div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label">电话客服</label>
                                <div class="am-u-sm-9">
                                    <label class="am-radio-inline">
                                        <input type="radio" name="wxapp[is_phone]" value="1" data-am-ucheck
                                            <?= $wxapp['is_phone'] ? 'checked' : '' ?>> 开启
                                    </label>
                                    <label class="am-radio-inline">
                                        <input type="radio" name="wxapp[is_phone]" value="0" data-am-ucheck
                                            <?= $wxapp['is_phone'] ? '' : 'checked' ?>> 关闭
                                    </label>
                                    <div class="help-block">
                                        <small>客服图标显示位置：首页、商品详情页、用户中心页、订单详情页</small>
                                    </div>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label">
                                    客服图标
                                </label>
                                <div class="am-u-sm-9">
                                    <div class="am-form-file">
                                        <div class="upload-file" data-name="wxapp[phone_image]">
                                            <i class="am-icon-cloud-upload"></i> 上传图片
                                        </div>
                                        <div class="uploader-list am-cf">
                                            <?php if ($wxapp['phone_image']): ?>
                                                <div class="file-item thumbnail">
                                                    <img src="<?= $wxapp['phone_image']['file_path'] ?>">
                                                    <input type="hidden" name="wxapp[phone_image]"
                                                           value="<?= $wxapp['phone_image']['file_name'] ?>">
                                                    <i class="iconfont icon-shanchu file-item-delete"></i>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label">
                                    电话号码
                                </label>
                                <div class="am-u-sm-9">
                                    <input type="text" class="tpl-form-input" name="wxapp[phone_no]"
                                           value="<?= $wxapp['phone_no'] ?>">
                                    <small>请填写正确的座机号码或手机号码</small>
                                </div>
                            </div>
                          -->

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
