<div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div class="widget am-cf">
                <form id="my-form" class="am-form tpl-form-line-form" enctype="multipart/form-data" method="post">
                    <div class="widget-body">
                        <fieldset>
                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl">服务器信息</div>
                            </div>
                            <div class="am-form-group">
                                <div class="am-scrollable-horizontal">
                                    <table class="am-table am-table-centered">
                                        <tbody>
                                        <tr>
                                            <th width="30%">参数</th>
                                            <th>值</th>
                                            <th></th>
                                        </tr>
                                        <?php if (isset($server)): foreach ($server as $item): ?>
                                            <tr class="<?= isset($statusClass) ? $statusClass[$item['status']] : '' ?>">
                                                <td><?= $item['name'] ?></td>
                                                <td><?= $item['value'] ?> </td>
                                                <td><?= $item['status'] !== 'normal' ? $item['remark'] : '' ?> </td>
                                            </tr>
                                        <?php endforeach; endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl">PHP环境要求</div>
                            </div>
                            <div class="am-form-group">
                                <div class="am-scrollable-horizontal">
                                    <table class="am-table am-table-centered">
                                        <tbody>
                                        <tr>
                                            <th width="30%">选项</th>
                                            <th>要求</th>
                                            <th>状态</th>
                                            <th></th>
                                        </tr>
                                        <?php if (isset($phpinfo)): foreach ($phpinfo as $item): ?>
                                            <tr class="<?= isset($statusClass) ? $statusClass[$item['status']] : '' ?>">
                                                <td><?= $item['name'] ?></td>
                                                <td><?= $item['value'] ?> </td>
                                                <td>
                                                    <?php if ($item['status'] !== 'danger'): ?>
                                                        <i class="am-icon-check x-color-green"></i>
                                                    <?php else: ?>
                                                        <i class="am-icon-times x-color-red"></i>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?= $item['status'] !== 'normal' ? $item['remark'] : '' ?> </td>
                                            </tr>
                                        <?php endforeach; endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl">目录权限监测</div>
                            </div>
                            <div class="am-form-group">
                                <div class="am-scrollable-horizontal">
                                    <table class="am-table am-table-centered">
                                        <tbody>
                                        <tr>
                                            <th width="30%">名称</th>
                                            <th class="am-text-left">路径</th>
                                            <th>状态</th>
                                            <th></th>
                                        </tr>
                                        <?php if (isset($writeable)): foreach ($writeable as $item): ?>
                                            <tr class="<?= isset($statusClass) ? $statusClass[$item['status']] : '' ?>">
                                                <td><?= $item['name'] ?></td>
                                                <td class="am-text-left"><?= $item['value'] ?> </td>
                                                <td>
                                                    <?php if ($item['status'] !== 'danger'): ?>
                                                        <i class="am-icon-check x-color-green"></i>
                                                    <?php else: ?>
                                                        <i class="am-icon-times x-color-red"></i>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?= $item['status'] !== 'normal' ? $item['remark'] : '' ?> </td>
                                            </tr>
                                        <?php endforeach; endif; ?>
                                        </tbody>
                                    </table>
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
