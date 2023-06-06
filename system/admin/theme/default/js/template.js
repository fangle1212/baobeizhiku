/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
$(document).ready(function(e) {
	if($G['func']=='init' && $G['part']!='params'){
		$.get($.mpf('software','software','identity'),function(res){
			if(res){
				$('body').prepend(sethtml.identity(res));
			}
		},'json');
	}
	$('input[name="pi"][type="radio"]').change(function(){
		$('label.price i').html( $(this).attr('price') );
		$('label.price input').val( $(this).attr('price') );
	});
	$('input[name="pay"][type="radio"]').change(function(){
		if($(this).val()=='balance'){
			$('dl.password').removeAttr('hide');
			$(window).scrollTop(999);
		}else{
			$('dl.password').attr('hide','hide');
		}
	});
	$('form#buy').submit(function(){
		if(!$('input[name="protocol"][type="checkbox"]').is(':checked')){
			_alert('请阅读协议并点击确认');
			return false;
		}
		if($('input[name="pay"][type="radio"]:checked').val()=='balance' && $('dl.password input[name="password"]').val()==''){
			_alert('请填写官方账号密码');
			$('dl.password input[name="password"]').focus();
			return false;
		}
	});
	if($('.order a.install').length>0){
		$('.order a.install').attr('href', $('.order a.install').attr('href').replace('referer=[url]','referer='+encodeURIComponent(window.parent.window.location.href)));
	}
	$('a[url][install]').click(function(){
		iname = $(this).attr('install');
		if($(this).attr('groups')==0){
			window.location.href = $(this).attr('url');
		}else{
			if($('section.easy.install').length==0){
				$('body').append('<section class="easy install">'+
				  '<div class="window">'+
					'<div class="icon">'+
					  '<span class="close "><em class="fa fa-times"></em></span>'+
					'</div>'+
					'<div class="move">授权域名</div>'+
					'<iframe></iframe>'+
				  '</div>'+
				'</section>');
			}
			$('section.easy.install div.window')
			  .css({'width':680,'height':440,'left':$('section.easy.install').width()/2-340,'top':$('section.easy.install').height()/2-220,})
			  .find('iframe').attr('src',$.mpf('template','market','inst',{name:iname}));
		}
	});
	if($('section.main.bind').length>0){
		$('section.easy.install',window.parent.document).addClass('active');
		$('section.main.bind a.auth[url]').click(function(){
			if(confirm('请确认该软件产品安装到本站')){
				window.location.href = $(this).attr('url');
			}
		});
	}
});