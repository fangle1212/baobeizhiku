<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
date_default_timezone_set('Asia/Shanghai');
header('Content-Type:text/html; charset=utf-8');
header('X-UA-Compatible:IE=edge,chrome=1');
error_reporting(E_ERROR|E_PARSE|E_CORE_ERROR|E_COMPILE_ERROR|E_USER_ERROR);
@set_time_limit(0);

define('IS_OK', true);
/* 根目录地址 */
define('ROOT_PATH', substr(dirname(__FILE__),0,-6));
/* 系统文件夹 */
define('SYSTEM_PATH', ROOT_PATH."system/");
/* 占位符 P */
define('P', 'BOSSCMS@DEL0T_T');
/* 服务器时间 */
define('TIME', time());

require_once SYSTEM_PATH.'basic/class/into.class.php';
into::load();
?>