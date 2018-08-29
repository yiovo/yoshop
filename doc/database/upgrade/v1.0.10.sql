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
