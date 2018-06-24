<?php
/**
 * 后台菜单配置
 *    'home' => [
 *       'name' => '首页',                // 菜单名称
 *       'icon' => 'icon-home',          // 图标 (class)
 *       'url' => 'index/index',         // 链接
 *     ],
 */
return [
    'index' => [
        'name' => '首页',
        'icon' => 'icon-home',
        'url' => 'index/index',
    ],
    'goods' => [
        'name' => '商品管理',
        'icon' => 'icon-goods',
        'url' => 'goods/index',
        'submenu' => [
            [
                'name' => '商品列表',
                'handle' => [
                    'goods/index',
                    'goods/add',
                    'goods/edit'
                ],
            ],
            [
                'name' => '商品分类',
                'url' => 'category/index',
                'handle' => [
                    'goods.category/index',
                    'goods.category/add',
                    'goods.category/edit',
                ],
            ],
        ],
    ],
    'order' => [
        'name' => '订单管理',
        'icon' => 'icon-order',
        'url' => 'order/delivery_list',
        'submenu' => [
            [
                'name' => '待发货',
                'handle' => [
                    'order/delivery_list',
                ],
            ],
            [
                'name' => '待收货',
                'handle' => [
                    'order/receipt_list',
                ],
            ],
            [
                'name' => '待付款',
                'handle' => [
                    'order/pay_list',
                ],
            ],
            [
                'name' => '已完成',
                'handle' => [
                    'order/complete_list',
                ],
            ],
            [
                'name' => '已取消',
                'handle' => [
                    'order/cancel_list',
                ],
            ],
            [
                'name' => '全部订单',
                'handle' => [
                    'order/all_list',
                ],
            ],
        ]
    ],
    'user' => [
        'name' => '用户管理',
        'icon' => 'icon-user',
        'url' => 'user/index',
        'submenu' => [],
    ],
//    'marketing' => [
//        'name' => '营销管理',
//        'icon' => 'icon-marketing',
//        'url' => 'marketing/index',
//        'submenu' => [],
//    ],
    'wxapp' => [
        'name' => '小程序',
        'icon' => 'icon-wxapp',
        'color' => '#36b313',
        'url' => 'wxapp/setting',
        'submenu' => [
            [
                'name' => '小程序设置',
                'handle' => [
                    'wxapp/setting'
                ],
            ],
            [
                'name' => '首页设计',
                'handle' => [
                    'wxapp/page'
                ],
            ],
            [
                'name' => '导航设置',
                'handle' => [
                    'wxapp/tabbar'
                ],
            ],
            [
                'name' => '帮助中心',
                'handle' => [
                    'wxapp.help/index'
                ],
            ],
        ],
    ],
    'plugins' => [
        'name' => '应用中心',
        'icon' => 'icon-application',
        'is_svg' => true,   // 多色图标
//        'url' => 'plugins/index',
    ],
    'setting' => [
        'name' => '设置',
        'icon' => 'icon-setting',
        'url' => 'setting/store',
        'submenu' => [
            [
                'name' => '商城设置',
                'handle' => [
                    'setting/store'
                ],
            ],
            [
                'name' => '交易设置',
                'handle' => [
                    'setting/trade'
                ],
            ],
            [
                'name' => '配送设置',
                'handle' => [
                    'setting.delivery/index',
                    'setting.delivery/add',
                    'setting.delivery/edit',
                ],
            ],
            [
                'name' => '上传设置',
                'handle' => [
                    'setting/upload'
                ],
            ],
        ],
    ],

];
