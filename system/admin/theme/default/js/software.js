/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
$(document).ready(function(e){
	$.get($.params($.mpf('software','software','field'),'divide',$.request('divide')),function(res){
		html = '';
		for(k in res.list){
			html += '<li class="'+res.list[k].on+'"><a href="'+res.list[k].url+'">'+res.list[k].name+'</a></li>';
		}
		$('.market>.cut>ul').html(html);
		$('.market>.filter>aside').html(res.content);
	},'json');
	li = $('.market>.list tbody').html().replace('display:none;','');
	$.get(
		$.params(
			$.params(
				$.params(
						$.mpf('software','software','data'),
						'pages',
						$.request('pages')
					),
					'divide',
					$.request('divide')
				),
			'search',		
			$.request('search')
		),
		function(res){
		html = '';
		for(k in res.list){
			il = li;
			for(p in res.list[k]){
				il = il.replace(new RegExp('\\['+p+'\\]','g'),res.list[k][p]);
				if(p=='remark' && !res.list[k][p]){
					il = il.replace(/<a remark.+?<\/a>/,'');
				}
			}
			il = il.replace('imgsrc=','img src=');
			html += il;
		}
		$('.market>.list tbody').html(html);
		$('.market>.pages>ol').html( sethtml.pages(res.pages) );
	},'json');
	$.get($.mpf('software','software','identity'),function(res){
		if(res){
			$('body').prepend(sethtml.identity(res));
		}
	},'json');
});