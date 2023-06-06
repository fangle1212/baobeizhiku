<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

class form
{
	/**
	 * 返回选中所需字符
	 * 
	 * @param string $judge 筛选项的值
	 * @param string|array $value 选中项的值
	 * @param string|array $default 默认选中项的值
	 * @param string $export 选中输出的内容
	 */
	public static function choose($judge, $value, $default=null, $export='selected'){
		if(isset($value)){
			if(!is_array($value)){
				$val = json::decode($value);
				$value = $val?$val:array($value);
			}
			foreach($value as $val){
				if($val == $judge){
					return " {$export}";
				}
			}
		}else if(isset($default)){
			if(!is_array($default)){
				$def = json::decode($default);
				$default = $def?$def:array($default);
			}
			foreach($default as $def){
				if($def == $judge){
					return " {$export}";
				}
			}
		}else{
			return '';
		}
	}

	/**
	 * 返回值
	 * 
	 * @param string $value 输出值
	 * @param string $default 默认值
	 */
	public static function value($value, $default=null){
		$result = null;
		if(isset($value)){
			$result = $value;
		}else if(isset($default)){
			$result = $default;
		}
		return is_array($result)?json::encode($result):$result;
	}
	
	/**
	 * input文本框控件设置
	 * 
	 * @param string $name
	 * @param string $value     文本框的值
	 * @param string $default   文本框的默认值
	 * @param string  $type     文本框类型
	 * @param string $attribute 控件的各种属性数组（其中‘必填’的required属性为开启）
	 */
	public static function input($name, $value, $default=null, $type='text', $attribute=array('required'), $code=true){
		$html = '';
		if($code){
			$html .= "<code class=\"input\">";
		}
		$html .= "<input";
		if($name){
			$html .= " name=\"{$name}\"";
		}
		if(isset($attribute)){
			foreach($attribute as $key=>$val){
				$val = quotesFilter($val);
				if(is_string($key)){
					$html .= " {$key}=\"{$val}\"";
				}else{
					$html .= " {$val}";
				}
			}
		}
		if($type){
			$html .= " type=\"{$type}\"";
		}
		$value = self::value($value, $default);
		if(isset($value)){
			$value = quotesFilter($value);
			$html .= " value=\"{$value}\"";
		}
		$html .= "/>";
		if($code){
			$html .= "</code>";
		}
		if($type=='hidden' && !isset($value)){
			$html = '';
		}
		return $html;
	}
	
	/**
	 * file文件上传控件设置
	 * 
	 * @param string $name
	 * @param string $value     文本框的值
	 * @param string $default   文本框的默认值
	 * @param string $attribute 控件的各种属性数组（其中‘必填’的required，multiple属性为开启）
	 */
	public static function files($name, $value, $default=null, $attribute=array('required','multiple'), $code=true){
		$html = '';
		$bosscms = '';
		if($code){
			$html .= "<code class=\"file\">";
		}
		$html .= self::input($name, $value, $default, 'file', $attribute, false);
		if($code){
			$html .= "</code>";
		}
		return $html;
	}

	/**
	 * radio单选项控件设置
	 * 
	 * @param string $name
	 * @param string $value     选中该选项的值
	 * @param string $default   选中该选项的默认值
	 * @param array  $param     选项控件的所属选项列表数组
	 * @param string $attribute 控件的各种属性数组（其中‘必填’的required属性为开启）
	 */
	public static function radio($name, $value, $default=null, $param, $attribute=array(), $code=true){
		$html = '';
		if($code){
			$html .= "<code class=\"radio\">";
		}
		$i = 0;
		$required = '';
		if(isset($attribute['required'])){
			unset($attribute['required']);
			$required = 'required';
		}
		if($param){
			foreach($param as $key=>$val){
				$attribute[99999] = self::choose($key, $value, $default, 'checked');
				$html .= "<label class=\"radio {$required} {$attribute[99999]}\">";
				$html .= self::input($name, $key, null, 'radio', $attribute, false);
				if(isset($val)){
					$html .= "<ins>{$val}</ins>";
				}
				$html .= "</label>\n";
				$i++;
			}
		}
		if($code){
			$html .= "</code>";
		}
		return $html;
	}

	/**
	 * checkbox多选项控件设置
	 * 
	 * @param string $name
	 * @param string $value     选中该选项的值
	 * @param string $default   选中该选项的默认值
	 * @param array  $param     选项控件的所属选项列表数组
	 * @param string $attribute 控件的各种属性数组（其中‘必填’的required属性为开启）
	 * boss-cms
	 */
	public static function checkbox($name, $value, $default=null, $param, $attribute=array(), $code=true){
		$html = '';
		if($code){
			$html .= "<code class=\"checkbox\">";
		}
		if(isset($attribute['default'])){
			unset($attribute['default']);
			$html .= self::input($name, '' , null, 'hidden', null, false);
		}
		$i = 0;
		$required = '';
		if(isset($attribute['required'])){
			unset($attribute['required']);
			$required = 'required';
		}
		if($param){
			foreach($param as $key=>$val){
				$attribute[99999] = self::choose($key, $value, $default, 'checked');
				$html .= "<label class=\"checkbox {$required} {$attribute[99999]}\">";
				$html .= self::input(($name?$name.'[]':''), $key, null, 'checkbox', $attribute, false);
				if(isset($val)){
					$html .= "<ins>{$val}</ins>";
				}
				$html .= "</label>\n";
				$i++;
			}
		}
		if($code){
			$html .= "</code>";
		}
		return $html;
	}
	
	/**
	 * select选项控件设置
	 * 
	 * @param string $name
	 * @param string|array $value 选中该选项的值
	 * @param string|array $default 选中该选项的默认值
	 * @param array $param 选项控件的所属选项列表数组
	 * @param array $attribute 控件的各种属性数组（其中‘必填’的required属性为开启）
	 */
	public static function select($name, $value, $default=null, $param, $attribute=array('required'), $code=true){
		$html = '';
		if($code){
			$html .= "<code class=\"select\">";
		}
		$html .= "<select ";
		if($name){
			$html .= " name=\"{$name}\"";
		}
		if(isset($attribute)){
			foreach($attribute as $key=>$val){
				$val = quotesFilter($val);
				if(is_string($key)){
					$html .= " {$key}=\"{$val}\"";
				}else{
					$html .= " {$val}";
				}
			}
		}
		$html .= ">";
		if(isset($param)){
			foreach($param as $key=>$val){
				$html .= "<option value=\"".quotesFilter($key)."\" ".self::choose($key, $value, $default).">{$val}</option>\n";
			}
		}
		$html .= "</select>";
		if($code){
			$html .= "</code>";
		}
		return $html;
	}
	
	/**
	 * textarea多行文本框控件设置
	 * 
	 * @param string $name
	 * @param string|array $value 选中该选项的值
	 * @param string|array $default 选中该选项的默认值
	 * @param array $attribute 控件的各种属性数组（其中‘必填’的required属性为开启）
	 * BOOSCMS
	 */
	public static function textarea($name, $value, $default=null, $attribute=array('required'), $code=true){
		$html = '';
		if($code){
			$html .= "<code class=\"textarea\">";
		}
		$html .= "<textarea ";
		if($name){
			$html .= " name=\"{$name}\"";
		}
		if(isset($attribute)){
			foreach($attribute as $key=>$val){
				$val = quotesFilter($val);
				if(is_string($key)){
					$html .= " {$key}=\"{$val}\"";
				}else{
					$html .= " {$val}";
				}
			}
		}
		$html .= " >";
		$value = self::value($value, $default);
		if(isset($value)){
			$html .= preg_replace("/<\/(\s*)textarea/is",'&lt;/\\1textarea',$value);
		}
		$html .= "</textarea>";
		if($code){
			$html .= "</code>";
		}
		return $html;
	}
}
?>