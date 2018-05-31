<script id="tpl_editor_search" type="text/template">
    <form class="am-form tpl-form-line-form" data-itemid="{{ id }}">
        <div class="am-form-group">
            <label class="am-u-sm-3 am-form-label am-text-xs">提示文字 </label>
            <div class="am-u-sm-9 am-u-end">
                <input class="tpl-form-input" type="text" name="searchStyle"
                       data-bind="params.placeholder" value="{{ params.placeholder }}">
            </div>
        </div>
        <div class="am-form-group">
            <label class="am-u-sm-3 am-form-label am-text-xs">搜索框样式 </label>
            <div class="am-u-sm-9 am-u-end">
                <label class="am-radio-inline">
                    <input data-bind="style.searchStyle" type="radio" name="searchStyle"
                           value="" {{ style.searchStyle=== '' ? 'checked' : '' }}> 方形
                </label>
                <label class="am-radio-inline">
                    <input data-bind="style.searchStyle" type="radio" name="searchStyle"
                           value="radius" {{ style.searchStyle=== 'radius' ? 'checked' : '' }}> 圆角
                </label>
                <label class="am-radio-inline">
                    <input data-bind="style.searchStyle" type="radio" name="searchStyle"
                           value="round" {{ style.searchStyle=== 'round' ? 'checked' : '' }}> 圆弧
                </label>
            </div>
        </div>
        <div class="am-form-group">
            <label class="am-u-sm-3 am-form-label am-text-xs">文字对齐 </label>
            <div class="am-u-sm-9 am-u-end">
                <label class="am-radio-inline">
                    <input data-bind="style.textAlign" type="radio" name="textAlign"
                           value="left" {{ style.textAlign=== 'left' ? 'checked' : '' }}>
                    居左
                </label>
                <label class="am-radio-inline">
                    <input data-bind="style.textAlign" type="radio" name="textAlign"
                           value="center" {{ style.textAlign=== 'center' ? 'checked' : '' }}>
                    居中
                </label>
                <label class="am-radio-inline">
                    <input data-bind="style.textAlign" type="radio" name="textAlign"
                           value="right" {{ style.textAlign=== 'right' ? 'checked' : '' }}>
                    居右
                </label>
            </div>
        </div>
    </form>
</script>
