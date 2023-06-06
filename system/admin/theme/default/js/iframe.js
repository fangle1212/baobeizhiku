/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
$(document).ready(function(e) {
		
	if(hs = window.parent.location.hash.match(/#mpf=\w+(\/(?:\w|%2C)+(,[^#]*){0,1})*/)){
		hs = hs[0].replace('#mpf=','');
		var pm = hs.split('/');
		pm0 = pm[0]&&pm[0].indexOf(',')<0?pm[0]:null;
		pm1 = pm[1]&&pm[1].indexOf(',')<0?pm[1]:null;
		pm2 = pm[2]&&pm[2].indexOf(',')<0?pm[2]:null;
		para = {};
		for(i=1;i<pm.length;i++){
			if(pm[i].indexOf(',')>0){
				p = pm[i].split(',');
				para[p[0].replace(/%2C/g,',')] = p[1];
			}
		}
		$('section.content iframe').attr('src',	$.mpf(pm0, pm1?pm1:pm0, pm2?pm2:'init', para));
	}else{
		$('section.content iframe').attr('src',	$.mpf('home', 'home', 'init'));
	}
	
	$('header.topnav>.column>ul>li').click(function(){
		$('header.topnav>.column>ul>li').removeClass('on');
		$(this).addClass('on');
		$('section.category>.nav>ul').removeClass('on');
		nav = $(this).attr('class').match(/nav(\d+)/)[1];
		$('section.category>.nav>ul[nav='+nav+']').addClass('on');
		$('section.content iframe').attr('src',	$('section.category>.nav>ul[nav='+nav+']>li:eq(0)>ul>li:eq(0)>a').attr('href'));
	});
	
	$('header.topnav>.wrap>ul>li.cache a').click(function(){
		$.get($(this).attr('url'),function(data){
			if(data.state=='success'){
				_alert(data.msg,'green');
			}else{
				_alert('操作失败','red');
			}
		},'json');
	});
	
	$('section.category div.nav li').mouseover(function(){
		if($('section.category.bosscms, header.topnav, section.content').hasClass('icon')){
			$(this).find('ul').css('top', $(this).offset().top);
		}
	});
	
	$('section.category>.nav>ul>li>a').click(function(){
		li = $(this).parent('li');
		if(li.hasClass('on')){
			li.removeClass('on');
		}else{
			$('section.category>.nav>ul>li').removeClass('on');
			li.addClass('on');
		}
	});

	$('section.category>.btn>button').click(function(){
		if($('section.category.bosscms, header.topnav, section.content').hasClass('icon')){
			$('section.category.bosscms, header.topnav, section.content').removeClass('icon');
			$.setCookie('IframeIconOpen',0);
		}else{
			$('section.category.bosscms, header.topnav, section.content').addClass('icon');
			$.setCookie('IframeIconOpen',1);
		}
	});
	
	$('a.setbgcolor').click(function(){
		$.get($.mpf('iframe','iframe','bgcolor',{jsonmsg:1}),function(data){
			if(data.state=='success'){
				_alert(data.msg,'green');
				window.setTimeout(function(){
					window.location.reload();
				},500);
			}else{
				_alert('切换失败','red');
			}
		},'json');
	});
	
    $.get($.mpf('iframe','iframe','update'),function(data){		
		if(data.version > $G['version']){
			$('section.category>.nav>ul>li>ul').find('li.update>a, li[update]>a').append('<u data="新"></u>');
		}
	});
});