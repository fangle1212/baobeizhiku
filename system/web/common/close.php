<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');
?>
<html>
<head>
<title><?php echo $G['config']['state_title']; ?></title>
<?php
echo html::link(
	cache::setfunc(
		'global.'.substr(md5($G['config']['web_theme'].$G['language']['id']),0,8).'.css',
		function(){
			return url::upload(
				load::page(
					'css/global.css',
					value::get('global',0,0),
					true
				),'sub','../../'
			);
		},
		'css'
	)
);
?>
</head>
<body>
<?php echo $G['config']['state_content']; ?>
</body>
</html>