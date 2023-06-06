<?php
/*
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 */
defined('IS_OK') or exit('Access Forbidden');

class html{

	public static function link($href, $rel='stylesheet', $attribute=array())
	{
		if($href){
			global $G;
			$html = "\n<link ";
			$href = url::upload($href);
			$attr = '';
			if(strpos($href,'http')!==0 || preg_match('#^'.preg_quote(url::$domain).'#',$href)){
				if(url::$domain){
					if(arrExist(parse_url(url::$domain),'host') != $G['path']['host']){
						$path = $href = preg_replace('#^'.preg_quote(url::$domain).'#',$G['path']['relative'],$href);
					}else{
						$path = preg_replace('#^'.preg_quote(url::$domain).'#','',$href);
					}
				}else{
					$path = $href;
				}
				$path = ROOT_PATH.preg_replace('/^(\.\.\/)+/','',strSubPos($path,'?'));
				if(is_file($path)){
					$href = url::replace(url::param($href,substr(filemtime($path),5,5),''));
					foreach($attribute as $key=>$val){
						if(is_string($key)){
							$attr .= "{$key}=\"{$val}\" ";
						}else{
							$attr .= "{$val} ";
						}
					}
				}else{
					return false;
				}
			}
			$html .= " href=\"{$href}\" rel=\"{$rel}\" {$attr}/>";
			return $html;
		}
	}

	public static function script($src, $attribute=array())
	{
		if($src){
			global $G;
			$html = "\n<script";
			$src = url::upload($src);
			$attr = '';
			if(strpos($src,'http')!==0 || preg_match('#^'.preg_quote(url::$domain).'#',$src)){
				if(url::$domain){
					if(arrExist(parse_url(url::$domain),'host') != $G['path']['host']){
						$path = $src = preg_replace('#^'.preg_quote(url::$domain).'#',$G['path']['relative'],$src);
					}else{
						$path = preg_replace('#^'.preg_quote(url::$domain).'#','',$src);
					}
				}else{
					$path = $src;
				}
				$path = ROOT_PATH.preg_replace('/^(\.\.\/)+/','',strSubPos($path,'?'));
				if(is_file($path)){
					$src = url::replace(url::param($src,substr(filemtime($path),5,5),''));
					foreach($attribute as $key=>$val){
						if(is_string($key)){
							$attr .= "{$key}=\"{$val}\" ";
						}else{
							$attr .= "{$val} ";
						}
					}
				}else{
					return false;
				}
			}
			$html .= " src=\"{$src}\" {$attr}></script>";
			return $html;
		}
	}
	
	public static function pages($set, $display=false, $target=false)
	{
		global $G;
		$html = '';
		if($set['display'] || $display){
			$target = $target?'target="_blank"':'';
			$html = "
			<dir>
			  <ol>
			    <li><a href=\"{$set['first']['url']}\" title=\"{$G['config']['page_first']}\" ".($set['first']['current']?'class="no"':'')." {$target} {$G['config']['_page_first']}>{$G['config']['page_first']}</a></li>
			    <li><a href=\"{$set['prev']['url']}\" title=\"{$G['config']['page_prev']}\" ".($set['prev']['current']?'class="no"':'')." {$target} {$G['config']['_page_prev']}>{$G['config']['page_prev']}</a></li>";
			foreach($set['list'] as $v){
				$number = $G['config']['page_number']?str_replace('[n]',$v['number'],$G['config']['page_number']):$v['number'];
				$html .= "
				<li><a href=\"{$v['url']}\" title=\"{$number}\" ".($v['current']?'class="on"':'')." {$target}>{$v['number']}</a></li>";
			}
			$boss_c_m_s;
			$html .= "
			    <li><a href=\"{$set['next']['url']}\" title=\"{$G['config']['page_next']}\" ".($set['next']['current']?'class="no"':'')." {$target} {$G['config']['_page_next']}>{$G['config']['page_next']}</a></li>
			    <li><a href=\"{$set['last']['url']}\" title=\"{$G['config']['page_last']}\" ".($set['last']['current']?'class="no"':'')." {$target} {$G['config']['_page_last']}>{$G['config']['page_last']}</a></li>
			  </ol>
			</dir>
			";
		}
		return $html;
	}
	
	public static function both($id, $items, $type=null)
	{
		global $G;
		$html = '';
		$result = page::group_both($id, $items, $type);
		if($result['prev'] || $result['next']){
			$html .= "
			<dir>
			  <dl class=\"prev ".($result['prev']?'':'no')."\">
				<dt><b {$G['config']['_page_before']}>{$G['config']['page_before']}</b></dt>";
			if($result['prev'] && $prev = $result['prev'][0]){
				$html .= "
				<dd><a href=\"{$prev['url']}\" title=\"{$prev['name']}\" {$prev['_name']} {$prev['target']}>{$prev['name']}</a></dd>";
			}else{
				$html .= "
				<dd><i {$G['config']['_page_none']}>{$G['config']['page_none']}</i></dd>";
			}
			$html .= "
			  </dl>
			  <dl class=\"next ".($result['next']?'':'no')."\">
				<dt><b {$G['config']['_page_after']}>{$G['config']['page_after']}</b></dt>";
			if($result['next'] && $next = $result['next'][0]){
				$html .= "
				<dd><a href=\"{$next['url']}\" title=\"{$next['name']}\" {$next['_name']} {$next['target']}>{$next['name']}</a></dd>";
			}else{
				$html .= "
				<dd><i {$G['config']['_page_none']}>{$G['config']['page_none']}</i></dd>";
			}
			$html .= "
			  </dl>
			</dir>";
		}
		return $html;
	}
	
	public static function param($items)
	{
		global $G;
		$html = '';
		$result = page::search_param($items);
		if($result){
			foreach($result as $val){
				$html .= "
				<dl".($val['rgb']?' class="rgb"':'').">
					<dt><h3 {$val['_title']}>{$val['title']}</h3></dt>";
				foreach($val['list'] as $v){
					$html .= "
					<dd class=\"".($v['active']?'on':'').($v['all']?' all':'')."\">
						<a".($val['rgb']?' class="rgb"':'')." href=\"{$v['url']}\" ".(!$v['rgb']||$v['all']?"title=\"{$v['title']}\"":'')." {$v['_title']}>{$v['title']}</a>
					</dd>";
				}
				$html .= '
				</dl>
				';
			}
		}
		return $html;
	}
	
	public static function search($items, $get=true)
	{
		global $G;
		$html = '';
		if($items){
			$config = page::config_option($items);
			$keyword = arrExist($config, 'search_keyword');
			$res = page::items_one($items);
			/* B-O-S-S CMS */
			$html .= '
			<form method="get" action="'.url::relative().$res['folder'].'/" '.$config['_search_placeholder'].'>
				'.form::input('view',$G['view'],null,'hidden',null,false).'
				'.form::input('lang',$G['language']['defaults']?null:$G['language']['id'],null,'hidden',null,false).'
				'.form::input($keyword,($get?quotesFilter(stripslashes(arrExist($G,"get|{$keyword}"))):''),'','text',array('placeholder'=>$config['search_placeholder']),false).'
				<button><i class="fa fa-search"></i></button>
			</form>
			';
		}
		return $html;
	}
	
	public static function feedback($items)
	{
		global $G;
	    $config = page::config_option($items);
		$html = '
		<form method="post" enctype="multipart/form-data" action="'.url::relative().'api/feedback/">
			'.form::input('items',$items,null,'hidden',null,false);
		$form = page::form($items);
		foreach($form as $v){
			$html .= "
			<dl class=\"form{$v['style']}\">
				".($v['title']?("<dt><h4{$v['_title']}>{$v['title']}</h4>".($v['must']?'<i>*</i>':'').'</dt>'):'')."
				<dd><span{$v['_prompt']}>{$v['form']}</span>".($v['description']?"<p{$v['_description']}>{$v['description']}</p>":'').'</dd>
			</dl>';
		}
		if($config['feedback_captcha']){
			$html .= "
			<dl class=\"form888\">
				".($config['feedback_captcha_title']?("<dt><h4{$config['_feedback_captcha_title']}>{$config['feedback_captcha_title']}</h4><i>*</i></dt>"):'')."
				<dd>
				    <span class=\"captcha\"{$config['_feedback_captcha_placeholder']}>
					    ".form::input('captcha',null,null,'text',array('required'=>'required','placeholder'=>$config['feedback_captcha_placeholder']),false)."
					    <i><img captcha src=\"{$G['path']['relative']}api/captcha/\" onclick=\"this.src+='?';\"></i>
					</span>
				</dd>
			</dl>";
		}
        $html .= "
			<button type=\"submit\"{$config['_feedback_submit']}>{$config['feedback_submit']}</button>
		</form>
		";
		/* B O S S C M S */
		return array('html'=>$html, 'input'=>($form?true:false));
	}
	
	public static function login()
	{
		global $G;
		$html = "
		<form method=\"post\" action=\"".url::member('api/member','login')."\" login>
			".form::input('view',$G['view'],null,'hidden',null,false)."
			<div class=\"username\"{$G['config']['_member_username']}>
				".form::input('username',null,null,'text',array('required','placeholder'=>$G['config']['member_username']),false)."
			</div>
			<div class=\"password\"{$G['config']['_member_password']}>
				".form::input('password',null,null,'password',array('required','placeholder'=>$G['config']['member_password']),false)."
			</div>";
		if($G['config']['member_login_captcha']){
			$html .= "
			<div class=\"captcha\">
				<span class=\"captcha\"{$G['config']['_member_code']}>
					".form::input('captcha',null,null,'text',array('required'=>'required','placeholder'=>$G['config']['member_code']),false)."
					<i><img captcha src=\"{$G['path']['relative']}api/captcha/\" onclick=\"this.src+='?';\"></i>
				</span>
			</div>";
		}
			$html .= "
			<div class=\"button\">
				<button type=\"submit\"{$G['config']['_member_login_button']}>{$G['config']['member_login_button']}</button>
			</div>
		</form>
		";
		return $html;
	}
	
	public static function register()
	{
		global $G;
		$html = "
		<form  method=\"post\" action=\"".url::member('api/member','register')."\" register>
			".form::input('view',$G['view'],null,'hidden',null,false)."
			<div class=\"username\"{$G['config']['_member_username']}>
				".form::input('username',null,null,'text',array('required','placeholder'=>$G['config']['member_username']),false)."
			</div>
			<div class=\"password\"{$G['config']['_member_password']}>
				".form::input('password',null,null,'password',array('required','placeholder'=>$G['config']['member_password']),false)."
			</div>
			<div class=\"passwords\"{$G['config']['_member_passwords']}>
				".form::input('passwords',null,null,'password',array('required','placeholder'=>$G['config']['member_passwords']),false)."
			</div>";
		if($G['config']['member_register_captcha']){
			$html .= "
			<div class=\"captcha\">
				<span class=\"captcha\"{$G['config']['_member_code']}>
					".form::input('captcha',null,null,'text',array('required'=>'required','placeholder'=>$G['config']['member_code']),false)."
					<i><img captcha src=\"{$G['path']['relative']}api/captcha/\" onclick=\"this.src+='?';\"></i>
				</span>
			</div>";
		}
		if($G['config']['member_captcha_type']==1){
			$html .= "
			<div class=\"phone\"{$G['config']['_member_phone']}>
				".form::input('phone',null,null,'tel',array('required','placeholder'=>$G['config']['member_phone']),false)."
			</div>
			<div class=\"phonecode\">
				<span class=\"captcha\">
					".form::input('phonecode',null,null,'text',array('required','placeholder'=>$G['config']['member_phone_code'],str_replace('"',"'",$G['config']['_member_phone_code'])),false)."
					<ins{$G['config']['_member_phone_retime']} resend=\"{$G['config']['member_phone_retime']}\">
						<i{$G['config']['_member_phone_button']}>{$G['config']['member_phone_button']}</i>
					</ins>
				</span>
			</div>
			";
		}else if($G['config']['member_captcha_type']==2){
			$html .= "
			<div class=\"emailcode\"{$G['config']['_member_email']}>
				".form::input('email',null,null,'email',array('required','placeholder'=>$G['config']['member_email']),false)."
			</div>";
		}
		if($G['config']['member_agreement_open']){
			$html .= "
			<div class=\"agreement\">
				<label{$G['config']['_member_agreement_yes']}>
					".form::input('agreement',1,1,'checkbox',array(),false).$G['config']['member_agreement_yes']."
				</label>
				<a href=\"{$G['config']['member_agreement_link']}\" title=\"{$G['config']['member_agreement_name']}\"{$G['config']['_member_agreement_name']} target=\"_blank\">{$G['config']['member_agreement_name']}</a>
			</div>";
		}
		$html .= "
			<div class=\"button\">
				<button type=\"submit\"{$G['config']['_member_register_button']}>{$G['config']['member_register_button']}</button>
			</div>
		</form>
		";
		return $html;
	}
}
?>