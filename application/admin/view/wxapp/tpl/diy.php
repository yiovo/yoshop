<!-- diy元素: 搜索栏 -->
<script id="tpl_diy_search" type="text/template">
    <div class="drag" id="diy_{{ id }}" data-itemid="{{ id }}">
        <div class="diy-search" style="background: {{ style.background }}; padding-top:{{ style.paddingTop  }}px; ">
            <div class="inner left {{ style.searchStyle }}" style="background: {{ style.inputBackground }};">
                <div class="search-icon" style="color: {{ style.iconColor }};"><i class="iconfont icon-ss-search"></i></div>
                <div class="search-input" style="text-align: {{ style.textAlign }}; color: {{ style.inputColor }};">
                    <span>{{ params.placeholder }}</span>
                </div>
            </div>
        </div>
    </div>
</script>

<!-- diy元素: banner -->
<script id="tpl_diy_banner" type="text/template">
    <div class="drag" id="diy_{{ id }}" data-itemid="{{ id }}">
        <div class="diy-banner">
            {{each data}}
                <img src="{{ $value.imgUrl }}">
            {{/each}}
            <div class="dots center {{ style.btnShape }}">
                {{each data}}
                    <span style="background: {{ style.btnColor }};"></span>
                {{/each}}
            </div>
        </div>
    </div>
</script>
