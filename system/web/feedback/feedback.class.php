<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');

into::basic_class('web');

class feedback extends web
{
	public function form()
	{
		global $G;
		if(isset($G['post'])){
			$items = arrExist($G['post'],'items');
			if(!is_numeric($items) && $items){
				die();
			}
			$data = page::config_option($items);
			$content = '';
			if($data){
				$G['config'] = array_merge($data, $G['config']);
			}
			$G['feedback']['form'] = page::form($items);
			if(arrExist($G['config'],'feedback_open')){
				if($G['config']['feedback_captcha'] && (!session::get('captcha') || arrExist($G['post'],'captcha')!=session::get('captcha'))){
					alert($G['config']['feedback_captcha_error']);
				}
				$post = array();
				foreach($G['feedback']['form'] as $v){
					$str =  arrExist($G,"post|params{$v['id']}");
					$post['params'.$v['id']] = $str;
					$content .= "<tr>
					  <td><b>{$v['title']}</b>&nbsp;</td>
					  <td><p>".(is_array($str)?implode('&emsp;',$str):$str)."</p></td>
					</tr>";
				}
				if($content){
					$content = '<table>'.$content.'</table>';
				}
				$data = array(
					'param' => json::enfilter($post),
					'parent' => $items,
					'reply' => '',
					'manager' => '0',
					'ctime' => TIME,
					'mtime' => 0,
					'ip' => getIP(),
					'display' => 0
				);
				$res = mysql::select_one('ctime','feedback',"ip='{$data['ip']}'",'ctime DESC,id DESC');
				if($data['ctime'] - $res['ctime'] > 60){
					if(mysql::insert($data, 'feedback')){
						if($G['config']['feedback_mail']){
							into::basic_class('mailto');
							if($G['email']){
								mailto::send($G['config']['feedback_recipient'],$G['config']['feedback_title'],$content);
							}
						}
						alert($G['config']['feedback_success'], $_SERVER['HTTP_REFERER']);
					}else{
						alert('提交失败！');
					}
				}else{
					alert($G['config']['feedback_quick']);
				}
			}else{
				alert('反馈表单处于关闭状态，请启用！');
			}
		}
	}
}
?>