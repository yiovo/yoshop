### v1.0.8 ###

# 订单商品记录表：库存计算方式
ALTER TABLE `yoshop_order_goods`
ADD COLUMN `deduct_stock_type` tinyint(3) UNSIGNED NOT NULL DEFAULT '20' AFTER `image_id`;
