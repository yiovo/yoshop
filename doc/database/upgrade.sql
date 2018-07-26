### 1.0.7 ###

# 新增短信设置
INSERT INTO `yoshop_setting` VALUES ('sms', '短信设置', '{"default":"aliyun","engine":{"aliyun":{"AccessKeyId":"","AccessKeySecret":"","sign":"","order_pay":{"is_enable":"0","template_code":"","accept_phone":""}}}}', 10001, 1530265122);


### v1.0.8 ###

# 订单商品记录表：库存计算方式
ALTER TABLE `yoshop_order_goods`
ADD COLUMN `deduct_stock_type` tinyint(3) UNSIGNED NOT NULL DEFAULT '20' AFTER `image_id`;


### v1.0.9 ###

# 商品分类表：分类排序
ALTER TABLE `yoshop_category`
ADD COLUMN `sort` int(11) UNSIGNED NOT NULL DEFAULT 0 AFTER `image_id`;


### v1.0.10 ###

# 文件库记录表：分类排序
ALTER TABLE `yoshop_upload_file`
ADD COLUMN `group_id` int(11) UNSIGNED NOT NULL DEFAULT 0 AFTER `file_id`,
ADD COLUMN `is_delete` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 AFTER `extension`,
MODIFY COLUMN `storage` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER `file_id`,
MODIFY COLUMN `file_size` int(11) UNSIGNED NOT NULL DEFAULT 0 AFTER `file_name`,
MODIFY COLUMN `file_type` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' AFTER `file_size`,
MODIFY COLUMN `create_time` int(11) UNSIGNED NOT NULL DEFAULT 0 AFTER `wxapp_id`;

# 文件库分组记录表
CREATE TABLE `yoshop_upload_group` (
  `group_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `group_type` varchar(10) NOT NULL DEFAULT '',
  `group_name` varchar(30) NOT NULL DEFAULT '',
  `sort` int(11) unsigned NOT NULL DEFAULT '0',
  `wxapp_id` int(11) unsigned NOT NULL DEFAULT '0',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`group_id`),
  KEY `type_index` (`group_type`)
) ENGINE=InnoDB AUTO_INCREMENT=10001 DEFAULT CHARSET=utf8;


