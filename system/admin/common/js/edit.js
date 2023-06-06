/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
jQuery.extend({
	mpf: function(mold, part, func, obj){
		url = '?mold='+mold+'&part='+part+'&func='+func;
		if(typeof(obj)!='undefined'){
			for(i in obj){
				url += '&'+i+'='+obj[i];
			}
		}
		return url+'&lang='+$G['lang'];
	},
	setCookie: function(name, value, expires, path){
		var date = new Date();
		date.setDate(date.getDate() + (expires?expires:28888));                   
		document.cookie = name+"="+escape(value)+"; expires="+date.toGMTString()+"; path="+(path?paht:'/');
	},
	getCookie: function(name){
		if(document.cookie.length>0){
			var start = document.cookie.indexOf(name+"=");       
			if (start != -1){ 
				start = start+name.length+1 
				end = document.cookie.indexOf(";",start);
				if(end == -1){
					end = document.cookie.length;
				}
				return unescape(document.cookie.substring(start,end));
			}
		}
		return null;
	}
});

var CTok = true,
	PTwin = $("section.fixed",window.parent.document.body);
function CTmenu(e){
	if(CTok && $(e.target).parents('.contextmenu').length==0){
		CTok = false;
		window.setTimeout(function(){
			CTok = true;
		},10);
		CTmove();
		$('body').append('<div class="contextmenu"><ul></ul></div>');
	}
}
function CTmove(){
	$(".contextmenu").remove();
}
function CThref(url,width,height){
	box = PTwin.children('div.box');
	box.width(width?width:'');
	box.height(height?height:'');
	box.css('left', ($(window.parent).width()-box.outerWidth())/2);
	box.css('top', ($(window.parent).height()+50-box.outerHeight())/2);
	PTwin.addClass('active');
	PTwin.find('iframe').attr('src',url).load(function(){
		Csubmit($(this));
	});
}
Csubmit($('iframe[name=edit]',window.parent.document));
function Csubmit(the){
	the.contents().find('form').submit(function(){
		the.load(function(){
			$('#page',window.parent.document)[0].contentWindow.location.reload(true);
		});
	});
}
function Cstyle(type){
	if(type<=1 || type==14){
		text = '文本修改';
	}else if(type==2){
		text = '编辑内容';
	}else if(type==3 && type==4 && type==5){
		text = '内容选择';
	}else if(type==6){
		text = '图片替换';
	}else if(type==7){
		text = '多图替换';
	}else if(type==8){
		text = '视频替换';
	}else if(type==9){
		text = '附件替换';
	}else if(type==10 && type==11){
		text = '参数修改';
	}else if(type==12){
		text = '颜色选择';
	}else if(type==13){
		text = '图标选择';
	}else if(type>=20 && type<30){
		text = '栏目选择';
	}else if(type==30){
		text = '复合框配置';
	}
	return text;
}
function Citems(){
	if($G['items']==88888){
		obj = {
			'navs':1
		};
		CThref($.mpf('seo','seo','init',obj));
	}else{
		obj = {
			'id':$G['items'],
			'navs':1
		};
		CThref($.mpf('items','items','edit',obj));
	}
}


if(viewScroll=$.getCookie('viewScroll')){
	iSo = viewScroll.split('~~~');
	if(iSo[1] == window.location.search){
		if(iSo[0].match(/^\d+$/)){
			$(window).scrollTop(iSo[0]);
		}
	}else{
		$.setCookie('viewScroll','')
	}
}
$(window).scroll(function(){
	$.setCookie('viewScroll', $(this).scrollTop()+'~~~'+window.location.search);
});


$(document).ready(function(e) {

if(PTwin.length>0){	

	$('body').append('<div class="divide"><span class="core"></span><span class="only"></span></div>');

	var ctime = etime = '';
	$(document)
	.on('mouseover',"*[eid][tname],*[did][dtable]",function(){
		clearTimeout(etime);		
		$('.divide>span.core')
		.removeClass('out')
		.css('left',$(this).offset().left)
		.css('top',$(this).offset().top)
		.css('width',$(this).outerWidth())
		.css('height',$(this).outerHeight());
	})
	.on('mouseout',"*[eid][tname],*[did][dtable]",function(){
		etime = window.setTimeout(function(){
			$('.divide>span.core').addClass('out');
		},100);
	})
	.on('mouseover',"*[bosscms]",function(){
		clearTimeout(ctime);
		$('.divide>span.only')
		.removeClass('out')
		.css('left',$(this).offset().left)
		.css('top',$(this).offset().top)
		.css('width',$(this).outerWidth())
		.css('height',$(this).outerHeight());
	})
	.on('mouseout',"*[bosscms]",function(){
		ctime = window.setTimeout(function(){
			$('.divide>span.only').addClass('out');
		},100);
	})
	.on('mouseover',".contextmenu,.divide>span",function(){
		clearTimeout(etime);
		clearTimeout(ctime);
	});
	
	
	
	$("*[eid][tname]").contextmenu(function(e){
		CTmenu(e);
		core = $(this).parents('*[core]');
		text = '文本修改';
		if(etype = $(this).attr('etype')){
			text = Cstyle(etype);
		}
		obj = {
			'core':$(this).attr('core'),
			'eid':$(this).attr('eid'),
			'tname':$(this).attr('tname'),
			'etype':$(this).attr('etype'),
			'parent':$(this).attr('parent')
		};
		url = $.mpf('view','view','edit',obj);
		$('.contextmenu ul').append('<li><a onclick="CThref(\''+url+'\');">'+text+'</a></li>');
	})
	
	$("*[did][dtable]").contextmenu(function(e){
		CTmenu(e);
		dstyle = '1';
		text = '文本修改';
		if($(this).attr('dstyle')){
			dstyle = $(this).attr('dstyle');
			text = Cstyle(dstyle);
		}
		else if($(this).prop("tagName")=='IMG'){
			dstyle = '6';
			text = '图片替换';
		}
		else if($(this).prop("tagName")=='ASIDE'){
			dstyle = '2';
			text = '编辑内容';
		}
		obj = {
			'did':$(this).attr('did'),
			'dtable':$(this).attr('dtable'),
			'dname':$(this).attr('dname'),
			'dstyle':dstyle,
			'dparam':$(this).attr('dparam')
		};
		if($(this).attr('djson')){
			obj['djson'] = $(this).attr('djson');
		}
		url = $.mpf('view','view','table_edit',obj);
		$('.contextmenu ul').append('<li><a onclick="CThref(\''+url+'\',980,580);">'+text+'</a></li>');
	});
	$("*[bosscms]").contextmenu(function(e){
		CTmenu(e);
		if($(this).attr('bosscms')!=''){
			obj = {
				'core':$(this).attr('bosscms'),
				'eid':0
			};
			url = $.mpf('view','view','edit',obj);
			$('.contextmenu ul').append('<li><a onclick="CThref(\''+url+'\');">配置版块</a></li>');
		}
		if($(this)[0].hasAttribute('groups')){
			groups = $(this).attr('groups');
			obj = {
				'items':groups?groups:$G['items'],
				'type':$G['type'],
				'column': 1
			};
			url = $.mpf('group','group','init',obj);
			$('.contextmenu ul').append('<li><a onclick="CThref(\''+url+'\');">内容列表</a></li>');
		}
		if($(this)[0].hasAttribute('feedback')){
			feedback = $(this).attr('feedback');
			obj = {
				'items':feedback?feedback:$G['items'],
				'navs0':1
			};
			url = $.mpf('feedback','feedback','init',obj);
			$('.contextmenu ul').append('<li><a onclick="CThref(\''+url+'\',1200);">反馈管理</a></li>');
		}
		if($(this).attr('group')==''){
			obj = {
				'items':$G['items'],
				'type':$G['type'],
				'id':$G['id']
			};
			url = $.mpf('group','group','edit',obj);
			$('.contextmenu ul').append('<li><a onclick="CThref(\''+url+'\');">详情内容</a></li>');
		}
		if($(this).attr('consult')==''){
			obj = {
				'navs':1
			};
			url = $.mpf('consult','consult','init',obj);
			$('.contextmenu ul').append('<li><a onclick="CThref(\''+url+'\');">咨询列表</a></li>');
		}
		if($(this).attr('menu')==''){
			obj = {
				'navs':1
			};
			url = $.mpf('menu','menu','init',obj);
			$('.contextmenu ul').append('<li><a class="menu" onclick="CThref(\''+url+'\');">菜单列表</a></li>');
		}
		if($(this).attr('link')==''){
			obj = {
				'navs':1
			};
			url = $.mpf('link','link','init',obj);
			$('.contextmenu ul').append('<li><a onclick="CThref(\''+url+'\');">友链列表</a></li>');
		}
		if($(this).attr('banner')==''){
			obj = {
				'navs':1
			};
			url = $.mpf('banner','banner','init',obj);
			$('.contextmenu ul').append('<li><a onclick="CThref(\''+url+'\',1200);">轮播列表</a></li>');
		}
		if($(this).attr('area')==''){
			obj = {
				'navs':1
			};
			url = $.mpf('area','config','init',obj);
			$('.contextmenu ul').append('<li><a onclick="CThref(\''+url+'\',1200);">分站配置</a></li>');
		}	
		if($(this).attr('content')==''){
			obj = {
					'id': $G['items'],
					'column': 1
				};
			url = $.mpf('items','content','edit',obj);
			$('.contextmenu ul').append('<li><a onclick="CThref(\''+url+'\',1300);">内容配置</a></li>');
		}
		if($(this).attr('items')==''){
			url = $.mpf('items','items','init');
			$('.contextmenu ul').append('<li><a onclick="CThref(\''+url+'\',1300);">栏目管理</a></li>');
		}
		if($(this)[0].hasAttribute('layers')){
			layers = $(this).attr('layers');
			core = $(this).attr('bosscms');
			obj = {
					'core': layers?layers:core
				};
			url = $.mpf('layers','layers','init',obj);
			if(layers || core){
				$('.contextmenu ul').append('<li><a onclick="CThref(\''+url+'\');">内容列表</a></li>');
			}
		}
		if($(this).attr('complex')==''){
			obj = {
					'items': $G['items'],
					'extent': $G['type'],
					'name': 'params'
				};
			url = $.mpf('complex','complex','init',obj);
			$('.contextmenu ul').append('<li><a onclick="CThref(\''+url+'\');">配置项目</a></li>');
		}
	});
	$(document).contextmenu(function(e){
		CTmenu(e);
		
		var contextmenu = $(".contextmenu"),
			docW = $(window).width(),
			docH = $(window).height(),
			mouseX = e.pageX,
			mouseY = e.pageY,
			menuW = contextmenu.width(),
			menuH = contextmenu.height();
		if(mouseX+menuW>=docW && mouseY+menuH>=docH){
			menuLeft = mouseX-menuW;
			menuTop = mouseY-menuH;
		}else if(mouseX+menuW >= docW){
			menuLeft = mouseX-menuW;
			menuTop = mouseY ;
		}else if(mouseY+menuH >= docH){
			menuLeft = mouseX;
			menuTop = mouseY-menuH;
		}else{
			menuLeft = mouseX;
			menuTop = mouseY;
		}
		contextmenu.css({
			"left": menuLeft,
			"top": menuTop
		}).addClass('active');
		return false;
	}).click(function(){
		CTmove();
	}).scroll(function(){
		CTmove();
	});
}
});