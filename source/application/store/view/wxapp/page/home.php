<link rel="stylesheet" href="assets/store/css/diy.css">
<div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div class="widget am-cf">
                <div class="widget-body am-cf">
                    <div class="widget-head am-cf">
                        <div class="widget-title am-fl">首页设计</div>
                    </div>
                    <!--手机diy容器-->
                    <div class="diy-phone">
                        <!-- 手机顶部标题 -->
                        <div class="phone-top"></div>
                        <!-- 小程序内容区域 -->
                        <div id="phone-main" class="phone-main"></div>
                    </div>
                    <!-- 编辑器容器 -->
                    <div id="diy-editor" class="diy-editor form-horizontal">
                        <div class="editor-arrow"></div>
                        <div class="inner"></div>
                    </div>
                    <!-- 工具栏 -->
                    <div id="diy-menu" class="diy-menu">
                        <div class="navs">
                            <div id="">
                                <div class="title">组件</div>
                                <div id="components">
                                    <nav class="special" data-type="search"> 搜索框</nav>
                                    <nav class="special" data-type="banner"> 图片轮播</nav>
                                </div>
                            </div>
                        </div>
                        <div class="action">
                            <a id="back-top" class="am-fl am-btn am-btn-xs am-btn-default" href="javascript:;">
                                <span class="am-icon-angle-double-up"></span> 返回顶部
                            </a>
                            <button id="submit" type="button" class="am-btn am-btn-xs am-btn-secondary">
                                保存页面
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 文件库弹窗 -->
{{include file="layouts/_template/file_library" /}}

<!--diy元素-->
{{include file="wxapp/page/tpl/diy" /}}

<!--编辑器: 搜索栏-->
{{include file="wxapp/page/tpl/editor" /}}

<script src="assets/store/js/ddsort.js"></script>
<script src="assets/store/js/diy.js"></script>
<script>
    $(function () {

        // 渲染diy页面
        new diyPhone(<?= $jsonData ?: '{}' ?>);

    });
</script>
