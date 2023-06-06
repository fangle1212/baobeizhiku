/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
$(document).ready(function(e) {	
	if($G['func']=='init'){
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
			$('section.category li.plugin',window.top.document).addClass(iname);
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
			  .find('iframe').attr('src',$.mpf('plugin','market','inst',{name:iname}));
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
	$('div.order a.install').click(function(){
		$('section.category li.plugin',window.top.document).addClass($(this).attr('install'));
	});
	$('a.btnfa.red.uninstall').click(function(){
		if(confirm('是否卸载该应用？')){
			vb = $(this).parents('tr').find('div.vimg>span>b');
			vname = vb.attr('name');
			$('section.category>.nav>ul>li>ul>li.plugin',window.top.document).removeClass(vb.attr('name'));
			$('section.category>.nav>ul[nav="66"]>li>ul>li.'+vname,window.top.document).remove();
			window.location.href = $(this).attr('url');
		}
	});
	$('td[width="98"] textarea[name="must"]').change(function(){
		(function(the){
			obj = {
				'id': the.attr('id'),
				'must': the.val()
			}
			$.post($.mpf('plugin','plugin','modify',{type:'must',jsonmsg:1}),obj,function(res){
				if(res.msg==0){
					mustfunc(the,res.msg);
					_alert('关闭成功','green');
				}else if(res.msg==1){
					mustfunc(the,res.msg);
					_alert('启用成功','green');
				}else{
					_alert(res.msg);
				}
			},'json');
		})($(this));
	});
	$('td[width="98"] textarea[name="display"]').change(function(){
		(function(the){
			obj = {
				'id': the.attr('id'),
				'display': the.val()
			}
			$.post($.mpf('plugin','plugin','modify',{type:'display',jsonmsg:1}),obj,function(res){
				if(res.msg==0){
					vb = the.parents('tr').find('div.vimg>span>b');
					vname = vb.attr('name');
					$('section.category>.nav>ul>li>ul>li.plugin',window.top.document).removeClass(vb.attr('name'));
					$('section.category>.nav>ul[nav="66"]>li>ul>li.'+vname,window.top.document).remove();
					if($('section.category>.nav>ul[nav="66"]>li>ul>li',window.top.document).length==0){
						$('header.topnav>.column>ul>li.nav66',window.top.document).addClass('hide');
					}
					_alert('关闭成功','green');
				}else if(res.msg==1){
					_alert('启用成功','green');
					mustfunc(the, $('td[width="98"] textarea[name="must"][id="'+the.attr('id')+'"]').val());
				}else{
					_alert(res.msg);
				}
			},'json');
		})($(this));
	});
	function mustfunc(the, st){
		vb = the.parents('tr').find('div.vimg>span>b');
		vname = vb.attr('name');
		if(st==0){
			$('section.category>.nav>ul>li>ul>li.plugin',window.top.document).addClass(vname);
			$('section.category>.nav>ul[nav="66"]>li>ul>li.'+vname,window.top.document).remove();
		}else if(st==1){
			$('section.category>.nav>ul>li>ul>li.plugin',window.top.document).removeClass(vb.attr('name'));
			if($('section.category>.nav>ul[nav="66"]>li>ul>li.'+vname,window.top.document).length==0){
				$('section.category>.nav>ul[nav="66"]>li>ul',window.top.document).append('<li class="'+vname+'"><a href="'+$.mpf(vname,vname,'init')+'" target="iframe">'+vb.text()+'</a></li>');
			}
		}
		if($('section.category>.nav>ul[nav="66"]>li>ul>li',window.top.document).length>0){
			$('header.topnav>.column>ul>li.nav66',window.top.document).removeClass('hide');
		}else{
			$('header.topnav>.column>ul>li.nav66',window.top.document).addClass('hide');
		}
	}
});