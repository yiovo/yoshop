<div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div class="widget am-cf">
                <form id="my-form" class="am-form tpl-form-line-form" enctype="multipart/form-data" method="post">
                    <div class="widget-body">
                        <fieldset>
                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl">订单流程设置</div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label form-require">未支付订单 </label>
                                <div class="am-u-sm-9 am-input-group">
                                    <div class="am-u-sm-7">
                                        <input type="number" class="am-form-field" name="trade[order][close_days]"
                                               value="<?= $values['order']['close_days'] ?>"
                                               pattern="^(0|\+?[1-9][0-9]*)$" required>
                                    </div>
                                    <label class="am-u-sm-5 am-form-label am-text-left">天后自动关闭</label>
                                    <div class="help-block am-u-sm-12">
                                        <small>订单下单未付款，n天后自动关闭，设置0天不自动关闭</small>
                                    </div>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label form-require">已发货订单 </label>
                                <div class="am-u-sm-9 am-input-group">
                                    <div class="am-u-sm-7">
                                        <input type="number" class="am-form-field" name="trade[order][receive_days]"
                                               value="<?= $values['order']['receive_days'] ?>"
                                               pattern="^(0|\+?[1-9][0-9]*)$" required>
                                    </div>
                                    <label class="am-u-sm-5 am-form-label am-text-left">天后自动确认收货</label>
                                    <div class="help-block am-u-sm-12">
                                        <small>如果在期间未确认收货，系统自动完成收货，设置0天不自动收货</small>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl">运费设置</div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label">运费组合策略 </label>
                                <div class="am-u-sm-9">
                                    <div class="am-u-sm-12">
                                        <label class="am-radio">
                                            <input type="radio" name="trade[freight_rule]" value="10" data-am-ucheck
                                                <?= $values['freight_rule'] === '10' ? 'checked' : '' ?> required> 叠加
                                        </label>
                                        <div class="help-block">
                                            <small>订单中的商品有多个运费模板时，将每个商品的运费之和订为订单总运费</small>
                                        </div>
                                    </div>
                                    <div class="am-u-sm-12 am-margin-top-sm">
                                        <label class="am-radio">
                                            <input type="radio" name="trade[freight_rule]" value="20" data-am-ucheck
                                                <?= $values['freight_rule'] === '20' ? 'checked' : '' ?> required>
                                            以最低运费结算
                                        </label>
                                        <div class="help-block">
                                            <small>订单中的商品有多个运费模板时，取订单中运费最少的商品的运费计为订单总运费</small>
                                        </div>
                                    </div>
                                    <div class="am-u-sm-12 am-margin-top-sm">
                                        <label class="am-radio">
                                            <input type="radio" name="trade[freight_rule]" value="30" data-am-ucheck
                                                <?= $values['freight_rule'] === '30' ? 'checked' : '' ?> required>
                                            以最高运费结算
                                        </label>
                                        <div class="help-block">
                                            <small>订单中的商品有多个运费模板时，取订单中运费最多的商品的运费计为订单总运费</small>
                                        </div>
                                    </div>
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
