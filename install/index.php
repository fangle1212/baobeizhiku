<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
if(is_file('../system/install.lock')) die('系统已经安装！如需重新安装请删除/system/目录下的install.lock文件');
$version = 'V2.1.0';
$page = isset($_GET['page'])&&preg_match('/^\w+$/',$_GET['page'])?$_GET['page']:'';
if(!(isset($_POST) && $_POST)){
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0,minimal-ui">
<title>BOSSCMS 网站后台管理系统</title>
<link href="../system/web/common/font/font-awesome.css" rel="stylesheet" />
<link href="../system/admin/common/css/bosscms.css?<?php echo mt_rand(); ?>" rel="stylesheet" />
<link href="css/install.css?<?php echo mt_rand(); ?>" rel="stylesheet" />
<script src="../system/extend/ueditor/third-party/jquery-1.10.2.min.js?16183" ></script>
<script src="js/install.js?<?php echo mt_rand(); ?>" ></script>
<link href="../favicon.ico" rel="shortcut icon" type="image/x-icon" />
</head>
<body>
<?php if(!$page){ ?>
<header class="head">
  <section class="content">
    <div class="logo">
      <img src="../system/admin/common/img/logo.png?<?php echo mt_rand(); ?>" />
    </div>
    <div class="text">程序安装</div>
    <div class="wrap">
      <span>
        <a href="https://www.bosscms.net/" target="_blank">官网首页</a>
        <b>|</b>
        <a href="https://www.bosscms.net/help/" target="_blank">帮助中心</a>
      </span>
      <p>当前安装版本：<b><?php echo $version; ?></b></p>
    </div>
  </section>
</header>
<main class="install">
  <section class="step">
    <ul>
      <li>
        <span>1.阅读安装协议</span>
        <em class="fa fa-chevron-down"></em>
      </li>
      <li>
        <span>2.检测安装环境</span>
        <em class="fa fa-chevron-down"></em>
      </li>
      <li>
        <span>3.配置数据库</span>
        <em class="fa fa-chevron-down"></em>
      </li>
      <li>
        <span>4.创建管理员</span>
        <em class="fa fa-chevron-down"></em>
      </li>
      <li>
        <span>5.完成安装</span>
        <em class="fa fa-check"></em>
      </li>
    </ul>
  </section>
  <section class="iframes">
    <iframe src="?page=license"></iframe>
  </section>
<main>
<?php
}else{
	include('html/'.$page.'.html');
}
?>
</body>
</html>
<?php
}else{
	require '../system/basic/func/global.func.php';
	if($page == 'form'){
        foreach ($_POST as $k => $v) {
            $post[$k] = str_replace(PHP_EOL,'',$v);
        }
		if(!preg_match('/^\d+$/',$post['port'])){
			alert('端口必须为数字');
		}
		if(!preg_match('/^\w+$/',$post['prefix'])){
			alert('数据表前缀必须为英文、数字、下划线的组合！');
		}
		$link = @mysqli_connect($post['host'].':'.$post['port'], $post['user'], $post['password']);
		if($link){
			mysqli_set_charset($link, 'UTF8');
			if(!mysqli_select_db($link, $post['database'])){
				mysqli_query($link,'CREATE DATABASE '.$post['database']);
				if(!mysqli_select_db($link, $post['database'])){
					alert('创建数据库失败');
				}
			}
			$file = '../system/basic/json/database.json';
			if(is_file($file)){
				$database = json_decode(preg_replace("/\/\*[\s\S]+?\*\//",'',file_get_contents($file)),true);
				foreach($database as $table=>$arr){
					mysqli_query($link, "DROP TABLE IF EXISTS `{$post['prefix']}{$table}`;");
					$sql = "CREATE TABLE IF NOT EXISTS `{$post['prefix']}{$table}` (";
					foreach($arr as $column=>$attr){
						$sql .= "`{$column}` {$attr},";
					}
					$sql .= "PRIMARY KEY (`id`) ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
					mysqli_query($link, $sql);
				}
				/* 必须添加一个语言 */
				mysqli_query($link, "INSERT INTO `{$post['prefix']}language` (`id`, `name`, `sign`, `image`, `description`, `defaults`, `display`, `target`, `sort`) VALUE ('1', '中文', 'zh', '..//upload/photo/image/zh-cn.png', '', '1', '1', '0', '0') ;");
				/* 添加版本号 */
				mysqli_query($link, "INSERT INTO `{$post['prefix']}config` (`id`, `name`, `value`, `parent`, `type`, `lang`) VALUE (null, 'version', '{$version}', '0', '1', '0') ;");
				/* 添加必要的后台config参数 */
				$config = json_decode(preg_replace("/\/\*[\s\S]+?\*\//",'',file_get_contents('../system/basic/json/config.json')),true);
				foreach($config as $v){
					mysqli_query($link, "INSERT INTO `{$post['prefix']}config` (`id`, `name`, `value`, `parent`, `type`, `lang`) VALUE (null, '{$v['name']}', '{$v['value']}', '{$v['parent']}', '{$v['type']}', '0') ;");
				}				
				/* 添加必要的前台config参数 */
				$must = json_decode(preg_replace("/\/\*[\s\S]+?\*\//",'',file_get_contents('../system/basic/json/must.json')),true);
				foreach($must as $v){
					mysqli_query($link, "INSERT INTO `{$post['prefix']}config` (`id`, `name`, `value`, `parent`, `type`, `lang`) VALUE (null, '{$v['name']}', '{$v['value']}', '{$v['parent']}', '{$v['type']}', '1') ;");
				}
				file_put_contents('../system/basic/ini/mysql.ini.php','<?php
/**
 * MYSQL数据库连接设置
 */
return <<<INI

host      = "'.$post['host'].'" ; /* 数据库地址 */
port      = "'.$post['port'].'" ; /* 数据库端口 */
user      = "'.$post['user'].'" ; /* 数据库用户 */
password  = "'.$post['password'].'" ; /* 数据库密码 */
database  = "'.$post['database'].'" ; /* 数据库名称 */
prefix    = "'.$post['prefix'].'" ; /* 数据表前缀 */

INI;
?>');
				header('Location:./?page=manager');
				die();
			}else{
				alert('没有可导入数据库文件');	
			}
		}else{
			$error = iconv('gbk','utf-8',mysqli_connect_error());
			if(strstr($error,'using password: YES')){
				$error = '数据库密码错误';
			}
			alert($error);
		}
	}else if($page == 'admin'){
		foreach ($_POST as $k => $v) {
			$post[$k] = strFilter($v);
		}
		if(!$post['username']){
			alert('管理员账户不能为空！');
		}
		if($post['password'] !== $post['passwords']){
			alert('密码输入不一致，请重新输入！');
		}
		define('ROOT_PATH', substr(dirname(__FILE__),0,-7));
		define('P', 'BOSSCMS@DEL0T_T');
		function replace($path){
			$path = str_replace('://',':'.P,$path);
			$path = str_replace('//','/',str_replace('///','/',str_replace('\\','/',$path)));
			$path = str_replace(':'.P,'://',$path);
			return $path;
		}
		$root  = replace(ROOT_PATH.'/');
		$aisle = isset($_SERVER['DOCUMENT_ROOT'])?str_ireplace(replace($_SERVER['DOCUMENT_ROOT'].'/'),'/',$root):'';
		$host  = (isset($_SERVER['HTTP_HOST'])?$_SERVER['HTTP_HOST']:$_SERVER['SERVER_NAME']).((isset($_SERVER['SERVER_PORT'])&&$_SERVER['SERVER_PORT']!=80&&$_SERVER['SERVER_PORT']!=443)?':'.$_SERVER['SERVER_PORT']:'');
		$http  = (isset($_SERVER['HTTP_X_CLIENT_SCHEME'])?$_SERVER['HTTP_X_CLIENT_SCHEME']:(isset($_SERVER['REQUEST_SCHEME'])?$_SERVER['REQUEST_SCHEME']:'http')).'://';
		$domain  = $http.replace($host.$aisle);
		$mysql = parse_ini_file('../system/basic/ini/mysql.ini.php');
		$link = @mysqli_connect($mysql['host'], $mysql['user'], $mysql['password'], $mysql['database'], $mysql['port']);
		if($link){
			mysqli_set_charset($link, 'UTF8');
			$result = mysqli_query($link, "SELECT VERSION() AS ver");
			if($result && mysqli_num_rows($result)>0){
				$rows = mysqli_fetch_array($result, MYSQLI_ASSOC);
				$ver = $rows['ver'];
				mysqli_free_result($result);
			}
			$result = mysqli_query($link, "SELECT id FROM {$mysql['prefix']}manager WHERE username='{$post['username']}'");
			if($result && mysqli_num_rows($result)>0){
				mysqli_query($link, "UPDATE {$mysql['prefix']}manager SET password=MD5('{$post['password']}') WHERE username='{$post['username']}'");
			}else{
				$time = time();
				$IP = getIP();
				mysqli_query($link, "DELETE FROM {$mysql['prefix']}manager WHERE level='1'");
				mysqli_query($link, "INSERT INTO {$mysql['prefix']}manager (`username`, `password`, `level`, `department`, `ip`, `frequency`, `permit`, `ctime`, `ltime`, `image`, `alias`, `email`, `phone`, `open`) VALUE ('{$post['username']}', MD5('{$post['password']}'), '1', '', '{$IP}', '0', '', '{$time}', '{$time}', '', '', '', '', '1')");
				mysqli_query($link, "UPDATE {$mysql['prefix']}config SET value='{$domain}' WHERE name='domain' AND type='0'");
				$file = 'sql/data.sql';
				if(isset($post['import']) && $post['import'] && is_file($file)){
					$text = str_replace('\\\') ;', 'sql_bosscms__import', file_get_contents($file));
					$text = str_replace('INSERT INTO `bosscms_', 'INSERT INTO `'.$mysql['prefix'], $text);
					preg_match_all("/INSERT INTO `[^`]+` \(`[^\)]+`\) VALUE \(\'[\S\s]+?\'\) ;/", $text, $sql);
					if($sql[0]){
						foreach($sql[0] as $v){
							$v = str_replace('sql_bosscms__import', '\\\') ;', $v);
							mysqli_query($link, $v);
						}
						mysqli_query($link, "UPDATE {$mysql['prefix']}config SET value='..//upload/photo/202112/080901482.png' WHERE name='logo' AND type='0'");
						mysqli_query($link, "UPDATE {$mysql['prefix']}config SET value='..//upload/photo/202112/080901482.png' WHERE name='logo_mobile' AND type='0'");
						mysqli_query($link, "UPDATE {$mysql['prefix']}config SET value='..//upload/photo/202112/011123136.jpg' WHERE name='image' AND type='0'");
						mysqli_query($link, "UPDATE {$mysql['prefix']}config SET value='..//upload/photo/image/favicon.ico' WHERE name='icon' AND type='0'");
						mysqli_query($link, "UPDATE {$mysql['prefix']}config SET value='BOSSCMS 网站管理系统' WHERE name='title' AND type='0'");
						mysqli_query($link, "UPDATE {$mysql['prefix']}config SET value='某某演示站' WHERE name='home_title' AND type='0'");
						mysqli_query($link, "UPDATE {$mysql['prefix']}config SET value='[\"cms系统\",\"建站系统\",\"建站cms\",\"自助建站\",\"快速建站\",\"云建站\",\"建站模板\",\"saas建站\"]' WHERE name='keywords' AND type='0'");
						mysqli_query($link, "UPDATE {$mysql['prefix']}config SET value='BOSSCMS是一款开源、轻量、简单好用的网站内容管理系统。' WHERE name='description' AND type='0'");
						mysqli_query($link, "UPDATE {$mysql['prefix']}config SET value='<a href=\"https://beian.miit.gov.cn/\" title=\"网站备案号\" rel=\"nofollow\" target=\"_blank\">浙ICP备2021037909号-2</a>' WHERE name='miit_beian' AND type='0'");
						mysqli_query($link, "UPDATE {$mysql['prefix']}config SET value='<a href=\"http://www.beian.gov.cn/portal/registerSystemInfo?recordcode=\" title=\"联网备案号\" rel=\"nofollow\" target=\"_blank\"><img src=\"../upload/photo/image/beian.png\" alt=\"联网备案号\" />浙公网安备 33038202004462号</a>' WHERE name='beian' AND type='0'");
						mysqli_query($link, "UPDATE {$mysql['prefix']}config SET value='<p>BOSSCMS是一款基于自主研发PHP框架+MySQL架构的内容管理系统，系统开源、安全、稳定、简洁、易开发、专注为中小型企业及政企单位、个人站长、广大开发者、建站公司提供一套简单好用的网站内容管理系统解决方案。严禁使用BOSSCMS建站系统从事任何的非法活动。</p>' WHERE name='foot' AND type='0'");
						
						$content = "<?php\n/*\n * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.\n * BOSSCMS Content Management System (https://www.bosscms.net/)\n */\nrequire '../index.php';\n?>";
						$result = mysqli_query($link, "SELECT folder FROM {$mysql['prefix']}items WHERE type!='9'");
						if($result && mysqli_num_rows($result)>0){
							while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
								if(preg_match('/^\w+$/',$row['folder'])){
									$dir = '../'.$row['folder'].'/';
									if(!is_dir($dir)){
										mkdir($dir);
									}
									$file = $dir.'index.php';
									if(!is_file($file)){
										touch($file);
										file_put_contents($file, $content);
									}
								}
							}
							mysqli_free_result($result);
						}
					}
				}
			}
			
			$info = array(
				'host' => $domain,
				'php' => PHP_VERSION,
				'mysql' => isset($ver)?$ver:''
			);
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, 'https://api.bosscms.net/rest/safeguard/');
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_NOBODY, true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($ch, CURLOPT_TIMEOUT, 30);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $info);
			$res = curl_exec($ch);
			curl_close($ch);
			
			header('Location:./?page=success');
			die();
		}else{
			alert('数据库链接失败！');	
		}
	}
}
?>