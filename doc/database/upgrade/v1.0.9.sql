### v1.0.9 ###

# 商品分类表：分类排序
ALTER TABLE `yoshop_category`
ADD COLUMN `sort` int(11) UNSIGNED NOT NULL DEFAULT 0 AFTER `image_id`;
