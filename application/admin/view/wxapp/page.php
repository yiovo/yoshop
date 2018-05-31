<link rel="stylesheet" href="assets/admin/css/diy.css">
<link rel="stylesheet" href="iconfont.css">
<div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div class="widget am-cf">
                <div class="widget-body">
                    <!--手机diy容器-->
                    <div class="diy-phone">
                        <!-- 手机顶部标题 -->
                        <div class="phone-top"></div>
                        <!-- 小程序内容区域 -->
                        <div id="phone-main" class="phone-main"></div>
                    </div>
                    <!-- 编辑器容器 -->
                    <div class="diy-editor form-horizontal" id="diy-editor">
                        <div class="editor-arrow"></div>
                        <div class="inner"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--diy元素-->
{{include file="wxapp/tpl/diy" /}}

<!--编辑器: 搜索栏-->
{{include file="wxapp/tpl/editor" /}}

<script src="assets/admin/js/ddsort.js"></script>
<script src="assets/admin/js/art-template.js"></script>
<script src="assets/admin/js/diy.js"></script>
<script>
    $(function () {

        // 可编辑diy数据元素
        let diyDataSave = {
            items: {
                101: {
                    "id": "101",
                    "type": "search",
                    "params": {"placeholder": "请输入关键字进行搜索"},
                    "style": {
                        "background": "#f1f1f2",
                        "iconColor": "#b4b4b4",
                        "inputBackground": "#ffffff",
                        "inputColor": "#999999",
                        "textAlign": "left",
                        "paddingTop": "10",
                        "paddingLeft": "10",
                        "searchStyle": '',
                    },
                },
            }
        };

        // 渲染diy页面
        new diyPhone(diyDataSave);

    });
</script>
