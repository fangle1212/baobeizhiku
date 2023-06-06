<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */

/**
 * 字符串或数组值添加反斜杠及html过滤
 *
 * @param string|array $data
 * @return string|array 返回字符串或数组
 */
function strFilter($data){
	!defined('MAGIC_QUOTES_GPC') && define('MAGIC_QUOTES_GPC', function_exists('get_magic_quotes_gpc')?get_magic_quotes_gpc():false);
	$func = function($s, $param){
		if(!MAGIC_QUOTES_GPC){
			$s = addslashes($s);
		}
		$s = htmlspecialchars($s, ENT_NOQUOTES);
		return $s;
	};
	$data = arrRoundHandle($data, $func);
	return $data;
}

/**
 * 字符串或数组值删除反斜杠及html过滤
 *
 * @param string|array $data
 * @return string|array 返回字符串或数组
 */
function delFilter($data){
	$func = function($s, $param){
		return stripslashes(htmlspecialchars_decode($s, ENT_NOQUOTES));
	};
	$data = arrRoundHandle($data, $func);
	return $data;
}

/**
 * 字符串或数组值添加反斜杠
 *
 * @param string|array $data
 * @param boolean $coerce 是否强制进行添加反斜杠操作
 * @return string|array 返回字符串或数组
 */
function strSlashes($data, $coerce=false){
	!defined('MAGIC_QUOTES_GPC') && define('MAGIC_QUOTES_GPC', function_exists('get_magic_quotes_gpc')?get_magic_quotes_gpc():false);
	if(!MAGIC_QUOTES_GPC || $coerce){
		$func = function($s, $param){
			return addslashes($s);
		};
		$data = arrRoundHandle($data, $func);
	}
	return $data;
}

/**
 * 字符串或数组值删除反斜杠
 *
 * @param string|array $data
 * @return string|array 返回字符串或数组
 */
function delSlashes($data){
	$func = function($s, $param){
		return stripslashes($s);
	};
	$data = arrRoundHandle($data, $func);
	return $data;
}

/**
 * 字符串或数组值添加html过滤
 *
 * @param string|array $data
 * @return string|array 返回字符串或数组
 */
function strHtmlspecial($data){
	$func = function($s, $param){
		return htmlspecialchars($s, ENT_NOQUOTES);
	};
	$data = arrRoundHandle($data, $func);
	return $data;
}

/**
 * 字符串或数组值删除html过滤
 *
 * @param string|array $data
 * @return string|array 返回字符串或数组
 */
function delHtmlspecial($data){
	$func = function($s, $param){
		return htmlspecialchars_decode($s, ENT_NOQUOTES);
	};
	$data = arrRoundHandle($data, $func);
	return $data;
}


/**
 * 数组值循环执行方法
 *
 * @param array $arr
 * @param function $func 要对数组值执行的方法
 * @param data $param 要对数组值执行方法的参数
 * @return array
 */
function arrRoundHandle($arr, $func, $param=array()){
	if(is_array($arr)){
		foreach($arr as $k => $v){
			$arr[$k] = arrRoundHandle($v, $func, $param);
		}
	}else{
		$arr = $func($arr, $param);
	}
	return $arr;
}


/**
 * 字符串编码转换（默认针对中文乱码问题进行转换）
 *
 * @param strong $str 字符串
 * @param strong $charset 字符串初始编码
 * @param strong $charsets 字符串转换编码
 * @return strong 返回字符串
 */
function strIconv($str, $charset='UTF-8', $charsets='GB2312//IGNORE'){
	return iconv($charset, $charsets, $str);
}


/**
 * 检查字符串编码并转换为utf8
 *
 * @param strong $str 字符串
 * @return strong 返回字符串
 */
function strUTF8($str){
	if(is_string($str)){
		$charset = mb_detect_encoding($str,array('ASCII','UTF-8','GB2312','GBK','BIG5','LATIN1'));  
		if($charset != 'UTF-8'){
			$str = mb_convert_encoding($str,'UTF-8',$charset);  
		}
	}
	return $str;   
}

/**
 * 自动判断系统并编码转换 
 * B o s s C m s
 * @param $mixed 
 * @return array|false|string 
 */ 
function strFilenameIconv($str){
	if(strtoupper(substr(PHP_OS,0,3)) == 'WIN'){
		$charset = mb_detect_encoding($str,array('ASCII','UTF-8','GB2312','GBK','BIG5','LATIN1'));
		if($charset == 'UTF-8'){
			$str = iconv('UTF-8','GBK//ignore',$str);
		}
	}else{
		$charset = mb_detect_encoding($str,array('ASCII','UTF-8','GB2312','GBK','BIG5','LATIN1')); 
		if($charset == 'EUC-CN'){
			$str = iconv('GBK','UTF-8//ignore',$str);
		}
	}
	return $str; 
}

/**
 * 字符串按次数替换文本或数组
 * B o s s C m s
 * @param string|array $data
 * @param strong $replace 替换为字符串
 * @param strong $str 原字符串
 * @param strong $limit 替换次数
 * @return string 返回字符串
 */
function strReplace($data, $replace, $str, $limit=-1) {
    if (is_array($data)) {
        foreach ($data as $k=>$v) {
            $data[$k] = '`'.preg_quote($data[$k],'`').'`';
        }
    }
    else {
        $data = '`'.preg_quote($data,'`').'`';
    }
    return preg_replace($data, $replace, $str, $limit);
}

/**
 * 按循环数组的键位和值对应替换字符串
 *
 * @param array $arr 键值对应的字符串
 * @param strong $str 原字符串
 * @return string 返回字符串
 */
function arrReplace($arr, $str) {
	foreach($arr as $k=>$v){
		$str = str_replace($k, $v, $str);
	}
	return $str;
}

/**
 * JS提示跳转
 *
 * @param strong $str 弹窗口提示信息并返回来源页面
 * @param strong $type 设置类型 null=不执行 ，close = 关闭 ，reload=提示重载，url提示并跳转url
 * @param strong $color 设置弹出提示背景色 ，可选颜色有 red|green|blue|yellow|gold
 * @param strong $json 输出json类型字符串
 * @return strong
 */
function alert($str, $type=null, $color=null){
	global $G;
	if(arrExist($G,'get|jsonmsg')){
		$js = json::encode(array('state'=>$type?$type:'success','msg'=>$str));
	}else{
		if($type=='close'){
			$js .= "<script>alert('{$str}');window.close();</script>";
		}else if($type=='reload'){
			$js .= "<script>alert('{$str}');parent.location.reload();</script>";
		}else if($type==null){
			location($_SERVER['HTTP_REFERER'].'#_alert='.urlencode($str).','.($color?$color:'red'));
		}else{
			location($type.'#_alert='.urlencode($str).','.($color?$color:'green'));
		}
	}
    die($js);
}

/**
 * 跳转页面
 *
 * @param int $url 跳转地址
 * @param int $type 跳转类型
 */
function location($url, $type=null){
	if($type==301){
		header('HTTP/1.1 301 Moved Permanently');
	}
	header("Location:{$url}");	
	die();
}

/**
 * 页面浏览数添加前台js执行对应标签
 *
 * @param int $type 栏目类型
 * @param int $id 页面id
 * @param int $num 浏览数
 */
function notice($type, $id, $num){
	return "<notice type=\"{$type}\" id=\"{$id}\">{$num}</notice>";
}

/**
 * 获取访客真实ip
 * BOSS C m s
 * @return strong
 */
function getIP(){
	if(isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
		$ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
	}else if(isset($_SERVER["HTTP_CLIENT_IP"])){
		$ip = $_SERVER["HTTP_CLIENT_IP"];
	}else{
		$ip = $_SERVER["REMOTE_ADDR"];
	}
    return preg_match('/^[\d\.]+$/',$ip)?$ip:'';
}

/**
 * 获取服务器的服务平台
 *
 * @return strong
 */
function getServer(){
	$software = strtolower($_SERVER['SERVER_SOFTWARE']);
	if (strpos($software, 'apache') !== false) {
		$server = 'apache';
	} elseif (strpos($software, 'microsoft-iis') !== false) {
		$server = 'iis';
	} elseif (strpos($software, 'nginx') !== false) {
		$server = 'nginx';
	} else {
		$server = false;
	}
	return $server;
}

/**
  * 移动端判断
 *
 * @return boolren
  */
function isMobile(){
	global $G;
	if($G['config']['domain_mobile'] && $G['path']['host']==parse_url($G['config']['domain_mobile'],PHP_URL_HOST)){
		return true;
	}
    if(isset($_SERVER['HTTP_X_WAP_PROFILE'])){
        return true;
    }
	if(isset($_SERVER['HTTP_VIA']) && stristr($_SERVER['HTTP_VIA'], "wap")){
        return true;
    } 
    if(isset($_SERVER['HTTP_USER_AGENT'])){
        $clientkeywords = array(
			'nokia','sony','ericsson','mot','samsung','htc','sgh','lg','sharp','sie-',
			'philips','panasonic','alcatel','lenovo','iphone','ipod','blackberry','meizu',
			'android','netfront','symbian','ucweb','windowsce','palm','operamini','operamobi',
			'openwave','nexusone','cldc','midp','wap','mobile');
        if(preg_match("/(".implode('|',$clientkeywords).")/i",strtolower($_SERVER['HTTP_USER_AGENT']))){
            return true;
        }
    }
    if(isset($_SERVER['HTTP_ACCEPT'])){
        if((strpos($_SERVER['HTTP_ACCEPT'],'vnd.wap.wml')!==false)&&
		(strpos($_SERVER['HTTP_ACCEPT'],'text/html')===false||(strpos($_SERVER['HTTP_ACCEPT'],'vnd.wap.wml')<strpos($_SERVER['HTTP_ACCEPT'],'text/html')))){
            return true;
        } 
    }
    return false;
}

/**
 * 获取字符串中的域名
 *
 * @param string $str  需要查询的字符串
 */
function getDomain($str){
	preg_match_all('/([\w\-]+\.)+(?:com|cn|top|xyz|net|ltd|vip|shop|cc|store|online|fun|tech|art|site|co|icu|club|work|xin|wang|space|group|ink|pub|info|ren|live|link|cloud|website|pro|life|asia|biz|cool|mobi|fit|plus|press|wiki|love|red|design|video|run|show|zone|kim|city|gold|today|host|team|chat|fund|beer|center|company|email|yoga|luxe|world|fans|guru|law|social)(\W|$)/',$str,$match);
	if($match[0]){
		return $match[0];
	}
}

/**
 * 提取根域名
 *
 * @param string $host  域名地址
 */
function rootDomain($host){
	preg_match('/([^\.]+\.)+[a-zA-Z]{2,8}/',$host,$match);
	if($match[0]){
		preg_match('/[^\.]+\.[a-zA-Z]{3}\.[a-zA-Z]{2}$/',$match[0],$even);
		if($even[0]){
			return $even[0];
		}
		preg_match('/[^\.]+\.[a-zA-Z]+$/',$match[0],$odd);
		if($odd[0]){
			return $odd[0];
		}
	}
	preg_match("/\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}/",$str,$ip);
	if($ip[0]){
		return $ip[0];
	}
	return $host;
}


/**
 * 生成随机字符串
 *
 * @param int $num  字符串个数
 */
function strRand($num) {
	$str = '0123456789abcdefghijklmnopqrstuvwxyz';
	$len = strlen($str)-1;
	$res = '';
	for($i=0; $i<$num; $i++){
		$res .= substr($str, mt_rand(0,$len), 1);
	}
	return $res;
}

/**
 * 数组的key键设为对应的value值
 *
 * @return array
 */
function arrSetKey($arr){
	return array_combine(array_values($arr), $arr);
}

/**
 * 将数组中的两个值转化生成为新数组的key和值
 *
 * @param strong $arr 需转化的数组
 * @param strong $key 生成新数组的key
 * @param strong $val 生成新数组的值
 * @return array
 */
function arrOption($arr, $key='name', $val='value'){
	$data = array();
	if($arr){
		foreach($arr as $v){
			$data[$v[$key]] = $v[$val];
		}
	}
	return $data;
}

/**
 * 把双引号替换为html转义符
 *
 * @param strong $str 含有双引号的字符串 
 * @return strong
 */
function quotesFilter($str){
	return str_replace('"', '&quot;', $str);
}

/**
 * 以某字符为开始截取指定位置的字符串
 *
 * @param strong $str 需截取的字符串
 * @param strong $needle 指定位置的字符
 * @param strong $start 开始或结束的位置（正数为正向截取、负数为方向截取）
 * @return strong
 */
function strSubPos($str, $needle, $start=0){
	$boss_cms = true;
	$pos = mb_strpos($str, $needle);
	if($pos === false){
		if($start>=0){
			return $str;
		}
	}else{
		if($start<0){
			return mb_substr($str, $pos+1, mb_strlen($str,'UTF-8')-$pos+1+$start, 'UTF-8');
		}else{
			return mb_substr($str, $start, $pos, 'UTF-8');
		}
	}
}

/**
 * 替换空格和换行为html转义符
 *
 * @param strong $str 需替换的字符串
 * @return strong
 */
function strLineSpace($str){
	return str_replace(' ','&nbsp;',str_replace("\n",'<br/>',$str));
}

/**
 * 给正值表达式中特殊字符加反斜杆
 *
 * @param strong $str 需替换的字符串
 * @param strong $out 无需替换的字符
 * @return strong
 */
function regFilter($str, $out=''){
	$reg = '\(\)\[\]\{\}\^\$\+\-\*\?\.\"\'\|\\\\\/';
	if($out){
		$out=str_split($out);
		foreach($out as $v){
			$reg = str_replace('\\'.$v,'',$reg);
		}
	}
	return preg_replace('/['.$reg.']/','\\\$0',$str);
}

/**
 * 按指定位置截取中文字符串
 *
 * @param strong $str 中文字符串
 * @param int $from 开始位置
 * @param int $len 结束位置
 * @return strong
 */
function strSub($str, $from, $len){
	return preg_replace('#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$from.'}'.'((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$len.'}).*#s','$1',$str);

}

/**
 * 内容前几行的首个字插入字符
 *
 * @return strong 返回插入后的内容
 */
function RepHtmlStr($str, $in, $num=3, $preg='[\x7f-\xff]'){
	preg_match_all('/<img.+?>/', $str, $imgs);
	foreach($imgs[0] as $k=>$v){
		$str=str_replace($v, P.$k, $str);
	}
	preg_match_all('/<(\w+)[\s>].+?<\/\\1>/', $str, $match);
	$i = 1;
	foreach($match[0] as $p){
		if(preg_match("/{$preg}/", $str)){
			if($i <= $num){
				$str = str_replace($p, preg_replace("/({$preg})/","{$in}\\1",$p,1), $str);
				$i++;
			}else{
				break;
			}
		}
	}
	foreach($imgs[0] as $k=>$v){
		$str=str_replace(P.$k, $v, $str);
	}
	return $str;
}

/**
 * 给文件路径添加文件最后修改时间
 * B o s s CMS
 * @param strong $path 文件路径
 * @return strong 返回文件路径加修改时间
 */
function strFileTime($path){
	if(file_exists($path)){
		$path .= '?'.filemtime($path);
	}
	return $path;
}


/**
 * 判断数组是否存在
 *
 * @param array  $arr 数组
 * @param strong $str 数组的键
 * @return strong 返回数组 不存在返回空
 */
function arrExist($arr, $str){
	$key = explode('|', $str);
	$val = $arr;
	foreach($key as $v){
		if(isset($val[$v])){
			$val = $val[$v];
		}else{
			return null;
		}
	}
	return $val;
}

/**
 * 判断公共数组是否存在
 * B o s s C m s
 * @param global $aE 配置公共数组
 * @param strong $str 数组的键
 * @return strong 返回数组 不存在返回空
 */
function aE($str){
	global $aE;
	if(isset($aE)){
		return arrExist($aE, $str);
	}else{
		return null;
	}
}
?>