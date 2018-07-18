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



