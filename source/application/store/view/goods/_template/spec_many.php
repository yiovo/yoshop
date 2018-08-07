
<!-- 商品规格属性模板 -->
<script id="tpl_spec_attr" type="text/template">
    {{ each spec_attr }}
    <div class="spec-group-item" data-index="{{ $index }}" data-group-id="{{ $value.group_id }}">
        <div class="spec-group-name">
            <span>{{ $value.group_name }}</span>
            <i class="spec-group-delete iconfont icon-shanchu1" title="点击删除"></i>
        </div>
        <div class="spec-list am-cf">
            {{ each $value.spec_items item key }}
            <div class="spec-item am-fl" data-item-index="{{ key }}">
                <span>{{ item.spec_value }}</span>
                <i class="spec-item-delete iconfont icon-shanchu1" title="点击删除"></i>
            </div>
            {{ /each }}
            <div class="spec-item-add am-cf am-fl">
                <input type="text" class="ipt-specItem am-fl am-field-valid">
                <button type="button" class="btn-addSpecItem am-btn am-fl">添加</button>
            </div>
        </div>
    </div>
    {{ /each }}
</script>

<!-- 商品规格table模板 -->
<script id="tpl_spec_table" type="text/template">
    <tbody>
    <tr>
        {{ each spec_attr }}
        <th>{{ $value.group_name }}</th>
        {{ /each }}
        <th>商家编码</th>
        <th>销售价</th>
        <th>划线价</th>
        <th>库存</th>
        <th>重量(kg)</th>
    </tr>
    {{ each spec_list item }}
    <tr data-index="{{ $index }}" data-sku-id="{{ item.spec_sku_id }}">
        {{ each item.rows td itemKey }}
        <td class="td-spec-value am-text-middle" rowspan="{{ td.rowspan }}">
            {{ td.spec_value }}
        </td>
        {{ /each }}
        <td>
            <input type="text" name="goods_no" value="{{ item.form.goods_no }}" class="ipt-goods-no am-field-valid">
        </td>
        <td>
            <input type="number" name="goods_price" value="{{ item.form.goods_price }}" class="am-field-valid ipt-w80"
                   required>
        </td>
        <td>
            <input type="number" name="line_price" value="{{ item.form.line_price }}" class="am-field-valid ipt-w80">
        </td>
        <td>
            <input type="number" name="stock_num" value="{{ item.form.stock_num }}" class="am-field-valid ipt-w80"
                   required>
        </td>
        <td>
            <input type="number" name="goods_weight" value="{{ item.form.goods_weight }}" class="am-field-valid ipt-w80"
                   required>
        </td>
    </tr>
    {{ /each }}
    </tbody>
</script>
