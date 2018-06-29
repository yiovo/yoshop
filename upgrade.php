<?php

$upgradeSql = <<<sql


SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for yoshop_category
-- ----------------------------
DROP TABLE IF EXISTS `yoshop_category`;
CREATE TABLE `yoshop_category` (
  `category_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品分类id',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '分类名称',
  `parent_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '上级分类id',
  `image_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '分类图片id',
  `wxapp_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '小程序id',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10001 DEFAULT CHARSET=utf8 COMMENT='商品分类表';

-- ----------------------------
-- Table structure for yoshop_delivery
-- ----------------------------
DROP TABLE IF EXISTS `yoshop_delivery`;
CREATE TABLE `yoshop_delivery` (
  `delivery_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '模板id',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '模板名称',
  `method` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '计费方式(10按件数 20按重量)',
  `wxapp_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '小程序d',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`delivery_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10001 DEFAULT CHARSET=utf8 COMMENT='配送模板主表';

-- ----------------------------
-- Table structure for yoshop_delivery_rule
-- ----------------------------
DROP TABLE IF EXISTS `yoshop_delivery_rule`;
CREATE TABLE `yoshop_delivery_rule` (
  `rule_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '规则id',
  `delivery_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '配送模板id',
  `region` text NOT NULL COMMENT '可配送区域(城市id集)',
  `first` double unsigned NOT NULL DEFAULT '0' COMMENT '首件(个)/首重(Kg)',
  `first_fee` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '运费(元)',
  `additional` double unsigned NOT NULL DEFAULT '0' COMMENT '续件/续重',
  `additional_fee` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '续费(元)',
  `wxapp_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '小程序id',
  `create_time` int(11) unsigned NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`rule_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10001 DEFAULT CHARSET=utf8 COMMENT='配送模板区域及运费表';

-- ----------------------------
-- Table structure for yoshop_dictionary
-- ----------------------------
DROP TABLE IF EXISTS `yoshop_dictionary`;
CREATE TABLE `yoshop_dictionary` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `type` varchar(30) NOT NULL DEFAULT '' COMMENT '字段类型',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '字段名称',
  `value` varchar(255) NOT NULL COMMENT '字段记录',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10001 DEFAULT CHARSET=utf8 COMMENT='系统字典表';

-- ----------------------------
-- Table structure for yoshop_goods
-- ----------------------------
DROP TABLE IF EXISTS `yoshop_goods`;
CREATE TABLE `yoshop_goods` (
  `goods_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品id',
  `goods_name` varchar(255) NOT NULL DEFAULT '' COMMENT '商品名称',
  `category_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '商品分类id',
  `spec_type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '商品规格(10单规格 20多规格)',
  `deduct_stock_type` tinyint(3) unsigned NOT NULL DEFAULT '20' COMMENT '库存计算方式(10下单减库存 20付款减库存)',
  `content` longtext NOT NULL COMMENT '商品详情',
  `sales_initial` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '初始销量',
  `sales_actual` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '实际销量',
  `goods_sort` int(11) unsigned NOT NULL DEFAULT '100' COMMENT '商品排序(数字越小越靠前)',
  `delivery_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '配送模板id',
  `goods_status` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '商品状态(10上架 20下架)',
  `is_delete` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否删除',
  `wxapp_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '小程序id',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`goods_id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10001 DEFAULT CHARSET=utf8 COMMENT='商品表';

-- ----------------------------
-- Table structure for yoshop_goods_image
-- ----------------------------
DROP TABLE IF EXISTS `yoshop_goods_image`;
CREATE TABLE `yoshop_goods_image` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `goods_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '商品id',
  `image_id` int(11) NOT NULL COMMENT '图片id(关联文件记录表)',
  `wxapp_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '小程序id',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `goods_image` (`goods_id`,`image_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10001 DEFAULT CHARSET=utf8 COMMENT='商品图片记录表';

-- ----------------------------
-- Table structure for yoshop_goods_spec
-- ----------------------------
DROP TABLE IF EXISTS `yoshop_goods_spec`;
CREATE TABLE `yoshop_goods_spec` (
  `goods_spec_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品规格id',
  `goods_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '商品id',
  `goods_no` varchar(100) NOT NULL DEFAULT '' COMMENT '商品编码',
  `goods_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '商品价格',
  `line_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '商品划线价',
  `stock_num` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '当前库存数量',
  `goods_sales` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '商品销量',
  `goods_weight` double unsigned NOT NULL DEFAULT '0' COMMENT '商品重量(Kg)',
  `wxapp_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '小程序id',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`goods_spec_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10001 DEFAULT CHARSET=utf8 COMMENT='商品规格表';

-- ----------------------------
-- Table structure for yoshop_order
-- ----------------------------
DROP TABLE IF EXISTS `yoshop_order`;
CREATE TABLE `yoshop_order` (
  `order_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单id',
  `order_no` varchar(20) NOT NULL DEFAULT '' COMMENT '订单号',
  `total_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '订单金额(不含运费)',
  `pay_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '实际付款金额(包含运费)',
  `pay_status` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '付款状态(10未付款 20已付款)',
  `pay_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '付款时间',
  `express_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '运费金额',
  `express_company` varchar(50) NOT NULL DEFAULT '' COMMENT '物流公司',
  `express_no` varchar(50) NOT NULL DEFAULT '' COMMENT '物流单号',
  `delivery_status` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '发货状态(10未发货 20已发货)',
  `delivery_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '发货时间',
  `receipt_status` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '收货状态(10未收货 20已收货)',
  `receipt_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '收货时间',
  `order_status` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '订单状态(10进行中 20取消 30已完成)',
  `transaction_id` varchar(30) NOT NULL DEFAULT '' COMMENT '微信支付交易号',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `wxapp_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '小程序id',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`order_id`),
  UNIQUE KEY `order_no` (`order_no`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10001 DEFAULT CHARSET=utf8 COMMENT='订单记录表';

-- ----------------------------
-- Table structure for yoshop_order_address
-- ----------------------------
DROP TABLE IF EXISTS `yoshop_order_address`;
CREATE TABLE `yoshop_order_address` (
  `order_address_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '地址id',
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '收货人姓名',
  `phone` varchar(20) NOT NULL DEFAULT '' COMMENT '联系电话',
  `province_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '所在省份id',
  `city_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '所在城市id',
  `region_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '所在区id',
  `detail` varchar(255) NOT NULL DEFAULT '' COMMENT '详细地址',
  `order_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '订单id',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `wxapp_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '小程序id',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`order_address_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10001 DEFAULT CHARSET=utf8 COMMENT='订单收货地址记录表';

-- ----------------------------
-- Table structure for yoshop_order_goods
-- ----------------------------
DROP TABLE IF EXISTS `yoshop_order_goods`;
CREATE TABLE `yoshop_order_goods` (
  `order_goods_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `goods_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '商品id',
  `goods_name` varchar(255) NOT NULL DEFAULT '' COMMENT '商品名称',
  `image_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '商品封面图id',
  `spec_type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '规格类型(10单规格 20多规格)',
  `goods_spec_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '商品规格id',
  `content` longtext NOT NULL COMMENT '商品详情',
  `goods_no` varchar(100) NOT NULL DEFAULT '' COMMENT '商品编码',
  `goods_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '商品价格',
  `line_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '商品划线价',
  `goods_weight` double unsigned NOT NULL DEFAULT '0' COMMENT '商品重量(Kg)',
  `total_num` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '购买数量',
  `total_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '商品总价',
  `order_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '订单id',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `wxapp_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '小程序id',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`order_goods_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10001 DEFAULT CHARSET=utf8 COMMENT='订单商品记录表';

-- ----------------------------
-- Table structure for yoshop_setting
-- ----------------------------
DROP TABLE IF EXISTS `yoshop_setting`;
CREATE TABLE `yoshop_setting` (
  `key` varchar(30) NOT NULL COMMENT '设置项标示',
  `describe` varchar(255) NOT NULL DEFAULT '' COMMENT '设置项描述',
  `values` mediumtext NOT NULL COMMENT '设置内容（json格式）',
  `wxapp_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '小程序id',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  KEY `key_idx` (`key`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商城设置记录表';

-- ----------------------------
-- Table structure for yoshop_store_user
-- ----------------------------
DROP TABLE IF EXISTS `yoshop_store_user`;
CREATE TABLE `yoshop_store_user` (
  `store_user_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `user_name` varchar(255) NOT NULL DEFAULT '' COMMENT '用户名',
  `password` varchar(255) NOT NULL DEFAULT '' COMMENT '登录密码',
  `wxapp_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '小程序id',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`store_user_id`),
  UNIQUE KEY `user_name` (`user_name`)
) ENGINE=InnoDB AUTO_INCREMENT=10001 DEFAULT CHARSET=utf8 COMMENT='商家用户记录表';

-- ----------------------------
-- Table structure for yoshop_upload_file
-- ----------------------------
DROP TABLE IF EXISTS `yoshop_upload_file`;
CREATE TABLE `yoshop_upload_file` (
  `file_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '文件id',
  `storage` varchar(20) NOT NULL COMMENT '存储方式',
  `file_url` varchar(255) NOT NULL DEFAULT '' COMMENT '存储域名',
  `file_name` varchar(255) NOT NULL DEFAULT '' COMMENT '文件路径',
  `file_size` int(11) unsigned NOT NULL COMMENT '文件大小(字节)',
  `file_type` varchar(20) NOT NULL COMMENT '文件类型',
  `extension` varchar(20) NOT NULL DEFAULT '' COMMENT '文件扩展名',
  `wxapp_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '小程序id',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`file_id`),
  UNIQUE KEY `path_idx` (`file_name`)
) ENGINE=InnoDB AUTO_INCREMENT=10001 DEFAULT CHARSET=utf8 COMMENT='文件库记录表';

-- ----------------------------
-- Table structure for yoshop_upload_file_used
-- ----------------------------
DROP TABLE IF EXISTS `yoshop_upload_file_used`;
CREATE TABLE `yoshop_upload_file_used` (
  `used_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `file_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '文件id',
  `from_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '使用方id',
  `from_type` varchar(20) NOT NULL DEFAULT '' COMMENT '使用方类型',
  `wxapp_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '小程序id',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`used_id`),
  KEY `type_idx` (`from_type`)
) ENGINE=InnoDB AUTO_INCREMENT=10001 DEFAULT CHARSET=utf8 COMMENT='已上传文件使用记录表';

-- ----------------------------
-- Table structure for yoshop_user
-- ----------------------------
DROP TABLE IF EXISTS `yoshop_user`;
CREATE TABLE `yoshop_user` (
  `user_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `open_id` varchar(255) NOT NULL DEFAULT '' COMMENT '微信openid(唯一标示)',
  `nickName` varchar(255) NOT NULL DEFAULT '' COMMENT '微信昵称',
  `avatarUrl` varchar(255) NOT NULL DEFAULT '' COMMENT '微信头像',
  `gender` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '性别',
  `country` varchar(50) NOT NULL DEFAULT '' COMMENT '国家',
  `province` varchar(50) NOT NULL DEFAULT '' COMMENT '省份',
  `city` varchar(50) NOT NULL DEFAULT '' COMMENT '城市',
  `address_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '默认收货地址',
  `wxapp_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '小程序id',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`user_id`),
  KEY `openid` (`open_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10001 DEFAULT CHARSET=utf8 COMMENT='用户记录表';

-- ----------------------------
-- Table structure for yoshop_user_address
-- ----------------------------
DROP TABLE IF EXISTS `yoshop_user_address`;
CREATE TABLE `yoshop_user_address` (
  `address_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '收货人姓名',
  `phone` varchar(20) NOT NULL DEFAULT '' COMMENT '联系电话',
  `province_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '所在省份id',
  `city_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '所在城市id',
  `region_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '所在区id',
  `detail` varchar(255) NOT NULL DEFAULT '' COMMENT '详细地址',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `wxapp_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '小程序id',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`address_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10001 DEFAULT CHARSET=utf8 COMMENT='用户收货地址表';

-- ----------------------------
-- Table structure for yoshop_wxapp
-- ----------------------------
DROP TABLE IF EXISTS `yoshop_wxapp`;
CREATE TABLE `yoshop_wxapp` (
  `wxapp_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '小程序id',
  `app_name` varchar(50) NOT NULL DEFAULT '' COMMENT '小程序名称',
  `app_id` varchar(50) NOT NULL DEFAULT '' COMMENT '小程序AppID',
  `app_secret` varchar(50) NOT NULL DEFAULT '' COMMENT '小程序AppSecret',
  `is_service` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '客服按钮(0不显示 1显示)',
  `service_image_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '客服图标(关联文件记录表id)',
  `is_phone` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '电话客服按钮(0不显示 1显示)',
  `phone_no` varchar(20) NOT NULL DEFAULT '' COMMENT '电话号码',
  `phone_image_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '电话图标',
  `mchid` varchar(50) NOT NULL DEFAULT '' COMMENT '微信商户号id',
  `apikey` varchar(255) NOT NULL DEFAULT '' COMMENT '微信支付密钥',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`wxapp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='微信小程序记录表';

-- ----------------------------
-- Table structure for yoshop_wxapp_help
-- ----------------------------
DROP TABLE IF EXISTS `yoshop_wxapp_help`;
CREATE TABLE `yoshop_wxapp_help` (
  `help_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '帮助标题',
  `content` text NOT NULL COMMENT '帮助内容',
  `sort` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '排序(数字越小越靠前)',
  `wxapp_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '小程序id',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`help_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10001 DEFAULT CHARSET=utf8 COMMENT='微信小程序帮助';

-- ----------------------------
-- Table structure for yoshop_wxapp_navbar
-- ----------------------------
DROP TABLE IF EXISTS `yoshop_wxapp_navbar`;
CREATE TABLE `yoshop_wxapp_navbar` (
  `wxapp_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '主键id',
  `wxapp_title` varchar(100) NOT NULL DEFAULT '' COMMENT '小程序标题',
  `top_text_color` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '顶部导航文字颜色(10黑色 20白色)',
  `top_background_color` varchar(10) NOT NULL DEFAULT '' COMMENT '顶部导航背景色',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`wxapp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='微信小程序导航栏设置';

-- ----------------------------
-- Table structure for yoshop_wxapp_page
-- ----------------------------
DROP TABLE IF EXISTS `yoshop_wxapp_page`;
CREATE TABLE `yoshop_wxapp_page` (
  `page_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '页面id',
  `page_type` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '页面类型(10首页)',
  `page_data` longtext NOT NULL COMMENT '页面数据',
  `wxapp_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '微信小程序id',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`page_id`),
  KEY `wxapp_id` (`wxapp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10001 DEFAULT CHARSET=utf8 COMMENT='微信小程序diy页面表';

SET FOREIGN_KEY_CHECKS = 1;


sql;

pdo_run($upgradeSql);
