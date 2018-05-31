<!-- diy元素: 搜索栏 -->
<script id="tpl_diy_search" type="text/template">
    <div class="drag" id="diy_{{ id }}" data-itemid="{{ id }}">
        <div class="diy-search" style="background: {{ style.background }}; padding-top:{{ style.paddingTop  }}px; ">
            <div class="inner left {{ style.searchStyle }}" style="background: {{ style.inputBackground }};">
                <div class="search-icon" style="color: {{ style.iconColor }};"><i class="icon icon-search"></i></div>
                <div class="search-input" style="text-align: {{ style.textAlign }}; color: {{ style.inputColor }};">
                    <span>{{ params.placeholder }}</span>
                </div>
            </div>
            <!--<div class="btn-edit-del">-->
            <!--    <div class="btn-edit">编辑</div>-->
            <!--    <div class="btn-del">删除</div>-->
            <!--</div>-->
        </div>
    </div>
</script>
