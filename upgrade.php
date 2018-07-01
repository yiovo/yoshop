<?php

$upgradeSql = <<<sql

### v1.0.3 ###

# 配送模板排序
ALTER TABLE `yoshop_delivery`
ADD COLUMN `sort` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '排序方式(数字越小越靠前)' AFTER `wxapp_id`;


sql;

pdo_run($upgradeSql);
