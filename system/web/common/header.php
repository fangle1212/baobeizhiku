<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');
include(load::common('static'));
$seo_title = $G['website']['seo_title'] ? $G['website']['seo_title'] : $G["config"]["home_title"];
$seo_description = $G['website']['seo_description'] ? $G['website']['seo_description'] : $G["config"]["description"];
$config_keywordArr = json_decode($G["config"]["keywords"]);
$config_keyword = join($config_keywordArr, $G["config"]["keywords_connector"]);
$seo_keyword = $G['website']['seo_keywords'] ? $G['website']['seo_keywords'] : $config_keyword;
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="renderer" content="webkit"/>
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
<title><?php echo $seo_title; ?></title>
<meta name="keywords" content="<?php echo $seo_keyword; ?>" />
<meta name="description" content="<?php echo $seo_description; ?>" /><?php echo $G['website']['font_css']; ?>
<?php echo $G['website']['box_css']; ?>
<?php echo $G['website']['global_css']; ?>
<?php echo $G['website']['tname_css']; ?>
<?php echo $G['website']['link_icon']; ?>
<?php echo $G['website']['head_code']; ?>
</head>
<body>