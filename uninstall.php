<?php

$unInstallSql = <<<sql


SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `ss_active`;
DROP TABLE IF EXISTS `ss_active_enroll`;
DROP TABLE IF EXISTS `ss_cover`;
DROP TABLE IF EXISTS `ss_cover_class`;
DROP TABLE IF EXISTS `ss_feedback`;
DROP TABLE IF EXISTS `ss_user`;
DROP TABLE IF EXISTS `ss_wxapp`;


sql;

pdo_run($unInstallSql);
