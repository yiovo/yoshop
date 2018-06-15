<div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div class="widget am-cf">
                <div class="widget-body">
                    <div class="am-u-sm-12">
                        <ul class="order-detail-progress progress-3">
                            <li>下单时间
                                <div class="tip">2018-06-15 10:54:26</div>
                            </li>
                            <li>付款
                                <div class="tip">付款于 2018-06-15 10:54:36</div>
                            </li>
                            <li>发货
                                <div class="tip"></div>
                            </li>
                            <li>收货
                                <div class="tip"></div>
                            </li>
                            <li>完成
                                <div class="tip"></div>
                            </li>
                        </ul>
                    </div>

                    <div class="widget-head am-cf">
                        <div class="widget-title am-fl">基本信息</div>
                    </div>
                    <div class="am-scrollable-horizontal">
                        <table class="regional-table am-table am-table-bordered
                                         am-table-centered am-margin-bottom-xs">
                            <tbody>
                            <tr>
                                <th>订单号</th>
                                <th>实付款</th>
                                <th>买家</th>
                                <th>交易状态</th>
                            </tr>
                            <tr>
                                <td><?= $detail['order_no'] ?></td>
                                <td>
                                    <p>￥<?= $detail['pay_price'] ?></p>
                                    <p class="am-link-muted">(含运费：￥<?= $detail['express_price'] ?>)</p>
                                </td>
                                <td>
                                    <p><?= $detail['user']['nickName'] ?></p>
                                    <p class="am-link-muted">(用户id：<?= $detail['user']['user_id'] ?>)</p>
                                </td>
                                <td>
                                    <p>付款状态：
                                        <span class="am-badge
                                        <?= $detail['pay_status']['value'] === 20 ? 'am-badge-success' : '' ?>">
                                                <?= $detail['pay_status']['text'] ?></span>
                                    </p>
                                    <p>发货状态：
                                        <span class="am-badge
                                        <?= $detail['delivery_status']['value'] === 20 ? 'am-badge-success' : '' ?>">
                                                <?= $detail['delivery_status']['text'] ?></span>
                                    </p>
                                    <p>收货状态：
                                        <span class="am-badge
                                        <?= $detail['receipt_status']['value'] === 20 ? 'am-badge-success' : '' ?>">
                                                <?= $detail['receipt_status']['text'] ?></span>
                                    </p>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>


                    <div class="widget-head am-cf">
                        <div class="widget-title am-fl">商品信息</div>
                    </div>
                    <div class="am-scrollable-horizontal">
                        <table class="regional-table am-table am-table-bordered
                                         am-table-centered am-margin-bottom-xs">
                            <tbody>
                            <tr>
                                <th>商品名称</th>
                                <th>商品编码</th>
                                <th>重量(Kg)</th>
                                <th>单价</th>
                                <th>购买数量</th>
                                <th>商品总价</th>
                            </tr>
                            <?php foreach ($detail['goods'] as $goods): ?>
                                <tr>
                                    <td class="goods-detail am-text-middle">
                                        <div class="goods-image">
                                            <img src="<?= $goods['image']['file_path'] ?>" alt="">
                                        </div>
                                        <div class="goods-info">
                                            <p class="goods-title"><?= $goods['goods_name'] ?></p>
                                            <?php if ($goods['spec_type'] === 20): ?>
                                                <p class="goods-spec am-link-muted">
                                                    颜色：918款黑色（加绒加厚款）尺码：33 套餐: 至尊
                                                </p>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td><?= $goods['goods_no'] ?: '--' ?></td>
                                    <td><?= $goods['goods_weight'] ?: '--' ?></td>
                                    <td>￥<?= $goods['goods_price'] ?></td>
                                    <td>×<?= $goods['total_num'] ?></td>
                                    <td>￥<?= $goods['total_price'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                            <tr>
                                <td colspan="6" class="am-text-right">总计金额：￥<?= $detail['total_price'] ?></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>


                    <div class="widget-head am-cf">
                        <div class="widget-title am-fl">收货信息</div>
                    </div>
                    <div class="am-scrollable-horizontal">
                        <table class="regional-table am-table am-table-bordered
                                         am-table-centered am-margin-bottom-xs">
                            <tbody>
                            <tr>
                                <th>收货人</th>
                                <th>收货电话</th>
                                <th>收货地址</th>
                            </tr>
                            <tr>
                                <td><?= $detail['address']['name'] ?></td>
                                <td><?= $detail['address']['phone'] ?></td>
                                <td>
                                    <?= $detail['address']['region']['province'] ?>
                                    <?= $detail['address']['region']['city'] ?>
                                    <?= $detail['address']['region']['region'] ?>
                                    <?= $detail['address']['detail'] ?>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>


                    <div class="widget-head am-cf">
                        <div class="widget-title am-fl">付款信息</div>
                    </div>
                    <div class="am-scrollable-horizontal">
                        <table class="regional-table am-table am-table-bordered
                                         am-table-centered am-margin-bottom-xs">
                            <tbody>
                            <tr>
                                <th>应付款金额</th>
                                <th>支付方式</th>
                                <th>支付流水号</th>
                                <th>付款状态</th>
                                <th>付款时间</th>
                            </tr>
                            <tr>
                                <td>￥<?= $detail['pay_price'] ?></td>
                                <td>微信支付</td>
                                <td><?= $detail['transaction_id'] ?: '--' ?></td>
                                <td>
                                  <span class="am-badge
                                        <?= $detail['pay_status']['value'] === 20 ? 'am-badge-success' : '' ?>">
                                                <?= $detail['pay_status']['text'] ?></span>
                                </td>
                                <td>
                                    <?= $detail['pay_time'] ? date('Y-m-d H:i:s', $detail['pay_time']) : '--' ?>
                                </td>
                            </tr>
                            </tbody>
                        </table>
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
