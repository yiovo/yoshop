<!--编辑器: 搜索-->
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

<!--编辑器: banner-->
<script id="tpl_editor_banner" type="text/template">
    <form class="am-form tpl-form-line-form" data-itemid="{{ id }}">
        <div class="am-form-group">
            <label class="am-u-sm-3 am-form-label am-text-xs">按钮形状 </label>
            <div class="am-u-sm-9 am-u-end">
                <label class="am-radio-inline">
                    <input data-bind="style.btnShape" type="radio" name="searchStyle"
                           value="rectangle" {{ style.btnShape=== 'rectangle' ? 'checked' : '' }}> 长方形
                </label>
                <label class="am-radio-inline">
                    <input data-bind="style.btnShape" type="radio" name="searchStyle"
                           value="square" {{ style.btnShape=== 'square' ? 'checked' : '' }}> 正方形
                </label>
                <label class="am-radio-inline">
                    <input data-bind="style.btnShape" type="radio" name="searchStyle"
                           value="round" {{ style.btnShape=== 'round' ? 'checked' : '' }}> 圆形
                </label>
            </div>
        </div>
        <div class="am-form-group">
            <label class="am-u-sm-3 am-form-label am-text-xs">按钮颜色 </label>
            <div class="am-u-sm-9 am-u-end">
                <input class="" type="color" name="btnColor"
                       data-bind="style.btnColor" value="{{ style.btnColor }}">
            </div>
        </div>
        <div class="form-items">
            {{each data}}
            <div class="item" data-key="{{ $index }}">
                <div class="container">
                    <div class="item-image"><img src="{{ $value.imgUrl }}" alt=""></div>
                    <div class="item-form am-form-file">
                        <div class="input-group">
                            <input type="text" name="imgName" data-bind="data.{{ $index }}.imgName"
                                   value="{{ $value.imgName }}" placeholder="请选择图片" readonly>
                            <span class="input-group-addon">选择图片</span>
                            <input type="hidden" name="imgUrl" data-bind="data.{{ $index }}.imgUrl"
                                   value="{{ $value.imgUrl }}">
                        </div>
                        <div class="input-group" style="margin-top:10px;">
                            <input type="text" name="linkUrl" data-bind="data.{{ $index }}.linkUrl"
                                   value="{{ $value.linkUrl }}"
                                   placeholder="请输入链接地址    例：pages/index/index">
                            <!-- <span class="input-group-addon">选择链接</span> -->
                        </div>
                    </div>
                </div>
                <i class="iconfont icon-shanchu item-delete"></i>

            </div>
            {{/each}}
        </div>
        <div class="form-item-add">
            <i class="fa fa-plus"></i> 添加一个
        </div>
    </form>
</script>
