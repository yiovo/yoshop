<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <title><?= $setting['store']['values']['name'] ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="renderer" content="webkit"/>
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <link rel="icon" type="image/png" href="assets/store/i/favicon.ico"/>
    <meta name="apple-mobile-web-app-title" content="<?= $setting['store']['values']['name'] ?>"/>
    <link rel="stylesheet" href="assets/store/css/amazeui.min.css"/>
    <link rel="stylesheet" href="assets/store/css/app.css"/>
    <link rel="stylesheet" href="//at.alicdn.com/t/font_664399_8kvutk31par79zfr.css">
    <script src="assets/store/js/jquery.min.js"></script>
    <script src="//at.alicdn.com/t/font_664399_xhxia8ezfa3ba9k9.js"></script>
    <script>
        const BASE_URL = '<?= url('/store') ?>';
    </script>
</head>

<body data-type="">
<div class="am-g tpl-g">
    <!-- 头部 -->
    <header class="tpl-header">
        <!-- 右侧内容 -->
        <div class="tpl-header-fluid">
            <!-- 侧边切换 -->
            <div class="am-fl tpl-header-button switch-button">
                <i class="iconfont">&#xe6a8;</i>
            </div>
            <!-- 刷新页面 -->
            <div class="am-fl tpl-header-button refresh-button">
                <i class="iconfont">&#xe638;</i>
            </div>
            <!-- 其它功能-->
            <div class="am-fr tpl-header-navbar">
                <ul>
                    <!-- 新提示 -->
                    <li class="am-dropdown" data-am-dropdown="">
                        <a href="javascript:;" class="am-dropdown-toggle" data-am-dropdown-toggle="">
                            <i class="iconfont">&#xe69c;</i>
                            <span class="am-badge am-badge-warning am-round item-feed-badge">5</span>
                        </a>
                        <!-- 弹出列表 -->
                        <ul class="am-dropdown-content tpl-dropdown-content">
                            <li class="tpl-dropdown-menu-notifications">
                                <a href="javascript:;" class="tpl-dropdown-menu-notifications-item am-cf">
                                    <div class="tpl-dropdown-menu-notifications-title">
                                        <i class="am-icon-line-chart"></i>
                                        <span>有6笔新的销售订单</span></div>
                                    <div class="tpl-dropdown-menu-notifications-time">12分钟前</div>
                                </a>
                            </li>
                            <li class="tpl-dropdown-menu-notifications">
                                <a href="javascript:;" class="tpl-dropdown-menu-notifications-item am-cf">
                                    <div class="tpl-dropdown-menu-notifications-title">
                                        <i class="am-icon-star"></i>
                                        <span>有3个来自人事部的消息</span></div>
                                    <div class="tpl-dropdown-menu-notifications-time">30分钟前</div>
                                </a>
                            </li>
                            <li class="tpl-dropdown-menu-notifications">
                                <a href="javascript:;" class="tpl-dropdown-menu-notifications-item am-cf">
                                    <div class="tpl-dropdown-menu-notifications-title">
                                        <i class="am-icon-folder-o"></i>
                                        <span>上午开会记录存档</span></div>
                                    <div class="tpl-dropdown-menu-notifications-time">1天前</div>
                                </a>
                            </li>
                            <li class="tpl-dropdown-menu-notifications">
                                <a href="javascript:;" class="tpl-dropdown-menu-notifications-item am-cf">
                                    <i class="am-icon-bell"></i> 进入列表…</a>
                            </li>
                        </ul>
                    </li>
                    <!-- 退出 -->
                    <li class="am-text-sm">
                        <a href="javascript:;">
                            <i class="iconfont">&#xe60b;</i> 退出
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </header>
    <!-- 侧边导航栏 -->
    <div class="left-sidebar">
        <?php $menus = $menus ?: []; ?>
        <?php $group = $group ?: ''; ?>
        <?php $controller = $controller ?: ''; ?>
        <?php $action = $action ?: ''; ?>
        <?php $url = $controller . DS . $action; ?>
        <?php
        //        echo $url; die;
        ?>
        <!-- 一级菜单 -->
        <ul class="sidebar-nav">
            <li class="sidebar-nav-heading"><?= $setting['store']['values']['name'] ?></li>
            <?php foreach ($menus as $key => $item): ?>
                <?php $first_active = $key === $group ? 'active' : '' ?>
                <li class="sidebar-nav-link">
                    <a href="<?= isset($item['url']) ? url($item['url']) : 'javascript:void(0);' ?>"
                       class="<?= $first_active ?>">
                        <?php if (isset($item['is_svg']) && $item['is_svg'] === true): ?>
                            <svg class="icon sidebar-nav-link-logo" aria-hidden="true">
                                <use xlink:href="#<?= $item['icon'] ?>"></use>
                            </svg>
                        <?php else: ?>
                            <i class="iconfont sidebar-nav-link-logo <?= $item['icon'] ?>"
                               style="<?= isset($item['color']) ? "color:{$item['color']};" : '' ?>"></i>
                        <?php endif; ?>
                        <?= $item['name'] ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
        <!-- 二级菜单-->
        <?php $second = isset($menus[$group]['submenu']) ? $menus[$group]['submenu'] : []; ?>
        <?php if (!empty($second)) : ?>
            <ul class="left-sidebar-second">
                <li class="sidebar-second-title"><?= $menus[$group]['name'] ?></li>
                <li class="sidebar-second-item">
                    <?php foreach ($second as $item) : ?>
                        <?php $two_active = in_array($url, $item['handle']) ? 'active' : '' ?>
                        <a href="<?= url(current($item['handle'])); ?>" class="sidebar-second-link <?= $two_active ?>">
                            <?= $item['name']; ?>
                        </a>
                    <?php endforeach; ?>
                    <!-- 三级菜单-->
                    <div style="display: none">
                        <a href="javascript:void(0);" class="sidebar-nav-sub-title">
                            <i class="iconfont icon-caret">&#xe653;</i>
                            基本功能
                        </a>
                        <ul class="sidebar-second-nav-sub">
                            <li><a href="">满额立减</a></li>
                            <li><a href="">满额包邮</a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        <?php endif; ?>
    </div>

    <!-- 内容区域 start -->
    <div class="tpl-content-wrapper <?= empty($second) ? 'no-sidebar-second' : '' ?>">
        {__CONTENT__}
    </div>
    <!-- 内容区域 end -->

</div>
<script src="assets/layer/layer.js"></script>
<script src="assets/store/js/jquery.form.min.js"></script>
<script src="assets/store/js/amazeui.min.js"></script>
<script src="assets/store/js/app.js"></script>
<script src="assets/store/js/webuploader.html5only.js"></script>
</body>

</html>
