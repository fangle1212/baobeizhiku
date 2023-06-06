/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
$(document).ready(function(e) {
	$('a.detect').click(function(){
		$('a.all').attr('hide','hide');
		$('span.speed').removeAttr('hide');
		$('section.main aside tbody').html('');
		$.get($.mpf('detect','detect','remote'),function(data){
			if(data.list){
				$('span.speed b').html('0%');
				detect(1, Math.ceil(Object.keys(data.list).length/data.rows));
			}
		},'json');
	});
	$(document).on('click','section.main aside tbody tr.different a.update',function(){
		detect_update($(this).attr('url'), false);
	});
	$('a.all').click(function(){
		detect_update($('section.main aside tbody tr.different a.update').eq(0).attr('url'), true);
	});
});
function detect_update(url, all){
	$.get(url, function(res){
		tu = $.mpf('detect','detect','update',{path:res.path});
		td = $('tr.different em[url="'+tu+'"]').parent('td');
		if(res.msg=='success'){
			td.html('<span color="green">成功</span>');
		}else{
			td.html('<a class="btnfa blue update" url="'+tu+'"><em class="fa fa-cloud-download">重试</em></a> &nbsp; <span color="red" style="line-height:24px;">失败</span>');
		}
		if(all){
			detect_update($('section.main aside tbody tr.different a.update').eq(0).attr('url'), all);
		}
	},'json');
	$('a[url="'+url+'"]').parent('td').html('<em class="fa fa-spinner" url="'+url+'"></em>');
}
function detect($page, $pages){
	window.setTimeout(function(){
		$.get($.mpf('detect','detect','check'),{'page':$page},function(res){
			html = '';
			for(fi in res){
				html += res[fi]?
				'<tr class="same">'+
					'<td>'+fi+'</td>'+
					'<td width="128"><span color="green">相同</span></td>'+
					'<td width="128"></td>'+
				'</tr>':
				'<tr class="different">'+
					'<td>'+fi+'</td>'+
					'<td width="128"><span color="red">不相同</span></td>'+
					'<td width="128"><a class="btnfa blue update" url="'+$.mpf('detect','detect','update',{path:fi})+'"><em class="fa fa-cloud-download">更新</em></a></td>'+
				'</tr>'
			}
			$('section.main aside tbody').prepend(html);
			$(window).scroll();
			$('span.speed b').html((Math.floor($page/$pages*100))+'%');
			if($page == $pages){
				_alert('检测完成','green');
				window.setTimeout(function(){
					$('section.main aside tbody tr.same').remove();
					$('span.speed').attr('hide','hide');
					if($('section.main aside tbody tr.different').length>0){
						$('a.all').removeAttr('hide');
					}else{
						$('section.main aside tbody').prepend('<tr><td colspan="3">无需更新文件</td></tr>');
					}
					$(window).scroll();
				},500);
			}
			$page++;
			if($page <= $pages){
				detect($page, $pages);
			}
		},'json');
	},200);
}