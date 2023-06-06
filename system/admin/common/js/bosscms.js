/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
var at = window.location.hash.match(/#_alert=(.+?),(red|green|blue|yellow|gold)/);
if(at){
	_alert(decodeURI(at[1]),at[2]);
	window.location.hash = window.location.hash.replace(at[0],$G['mold']?'_':'');
}

/* 公共函数 */
jQuery.extend({
	postForm: function(url, param){
		form=$('<form hidden method="post" enctype="multipart/form-data"></form>');
		form.attr('action',url);
		for(var k in param){
			form.prepend('<input type="hidden" name="'+k+'" value="'+this.quotesFilter(param[k])+'" />');
		}
		$(document.body).append(form);
		form.submit();
	},
	srcRand: function(src){
		if(src!=''){
			rand = Math.ceil((Math.random()*100000))
			if(src.indexOf('?')>0){
				src+='&'+rand;
			}else{
				src+='?'+rand;
			}
		}
		return src;
	},
	quotesFilter: function(str){
		return String(str).replace(/"/g,'&quot;');
	},
	mpf: function(mold, part, func, obj){
		url = '?mold='+mold+'&part='+part+'&func='+func;
		if(typeof(obj)!='undefined'){
			for(i in obj){
				url += '&'+i+'='+obj[i];
			}
		}
		return url+($G['defaults']?'':'&lang='+$G['lang']);
	},
	request: function(str){
		quest = encodeURI(window.location.search.substr(1));
		reg = new RegExp("(^|&)"+str.replace(/([\(\)\[\]\{\}\^\$\+\-\*\?\.\"\'\|\/\\])/g,"\\$1")+"=([^&]*)(&|$)");
		res = quest.match(reg);
		if(res != null){
			return decodeURI(unescape(res[2]));
		}else{
			return null;
		}
	},
	params: function(url, name, value){
		reg = new RegExp("(^|&|\\?)"+name.replace(/([\(\)\[\]\{\}\^\$\+\-\*\?\.\"\'\|\/\\])/g,"\\$1")+"=[^&]*");
		url = url.replace(reg,'')+(value===null?'':('&'+name+'='+value));
		return url;
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


function textarea_func(obj){
	var textarea = obj.getElementsByTagName('textarea');
	for(var t=0;t<textarea.length;t++){
		var codeclass='', codeattr='';
		if(textarea[t].hasAttribute('ueditor')) {
			codeclass = 'ueditor';
		}else if(textarea[t].hasAttribute('param')) {
			codeclass = 'param';
			codeattr = 'odd';
		}else if(textarea[t].hasAttribute('params')) {
			codeclass = 'param';
			codeattr = 'even';
		}else if(textarea[t].hasAttribute('image')) {
			codeclass = 'upfile';
			codeattr = 'image';
		}else if(textarea[t].hasAttribute('images')) {
			codeclass = 'upfile';
			codeattr = 'images';
		}else if(textarea[t].hasAttribute('video')) {
			codeclass = 'upfile';
			codeattr = 'video';
		}else if(textarea[t].hasAttribute('file')) {
			codeclass = 'upfile';
			codeattr = 'file';
		}else if(textarea[t].hasAttribute('color')) {
			codeclass = 'color';
		}else if(textarea[t].hasAttribute('toggle')) {
			codeclass = 'toggle';
		}else if(textarea[t].hasAttribute('icon')) {
			codeclass = 'icon';
		}else if(textarea[t].hasAttribute('seekbar')) {
			codeclass = 'seekbar';
		}else if(textarea[t].hasAttribute('linkage')) {
			codeclass = 'linkage';
		}
		if(codeclass){
			textarea[t].parentNode.className = codeclass;
		}
		if(codeattr){
			textarea[t].parentNode.setAttribute(codeclass,codeattr);
		}
	}
}
textarea_func(document);
document.write(
	'<script type="text/javascript" src="'+$G['relative']+'system/extend/ueditor/ueditor.config.js"></script>'+
	'<script type="text/javascript" src="'+$G['relative']+'system/extend/ueditor/editor_api.js"></script>'
);
		

/* radio开关按钮 */
radiofunc = {
	val: function(radio){
		v = radio.find('ul li').eq(radio.find('ul').hasClass('on')?0:1).attr('value');
		radio.find('textarea').text(v).val(v).change();
	}
}
function radio_init(obj){
	obj.each(function() {
		label = $(this).find('label');
		if(label.length==2 && !label.find('input')[0].hasAttribute('no')){
			textarea = label.find('input')[0].outerHTML.replace('/>','>').replace('<input','<textarea')+'</textarea>';
			radiohtml = $('<div><ul></ul></div>'+textarea);
			label.each(function(index, element) {
				val = $(this).find('input').attr('value');
				val = val.indexOf($.P)>=0?'':' value="'+$.quotesFilter(val)+'"';
				htm = $(this).find('ins').html();
				li = '<li'+val+'>'+htm+'</li>';
				radiohtml.find('ul').append(li);
			});
			if(label.eq(0).find('input')[0].hasAttribute('checked')){
				radiohtml.find('ul').addClass('on');
			}
			$(this).addClass(label.eq(0).find('input').attr('color')).html(radiohtml);
			radiofunc.val($(this));
		}
	});
}
radio_init($('code.radio'));
$(document)
.on('click','code.radio ul',function(){
	radio = $(this).parents('code.radio');
	$(this).toggleClass('on');
	radiofunc.val(radio);
});
	
	


/* select选择器 Bosscms */
selectfunc = {
	val: function(selects){
		if(selects.find('div ins').length>0){
			jn = JSON.parse('[]');
			selects.find('div ins ul li.on:not(.hide)').each(function(i) {
				jn[i] = $(this).attr('value');
			});
			if(selects.find('div ins ul li:not(.on):not(.hide)').length==0){
				selects.find('div dfn u').addClass('on');
			}else{
				selects.find('div dfn u').removeClass('on');
			}
			v = jn.length>0?JSON.stringify(jn):'';
			selects.find('textarea').text(v).val(v);
			if(selects.hasClass('init')){
				selects.removeClass('init');
			}else{
				selects.find('textarea').change();
			}
		}else if(selects.find('dl dd').length>0){
			v = '';
			selects.find('dl dd ul li.on').each(function(){
				selects.find('dl dt input').attr('value', $(this).text());
				v = $(this).attr('value');
			});
			selects.find('textarea').text(v).val(v);
			if(selects.hasClass('init')){
				selects.removeClass('init');
			}else{
				selects.find('textarea').change();
			}
		}
	}
}
function select_init(obj){
	obj.each(function() {
		textarea = $(this).html().replace($(this).find('select').html(),'').replace(/select/g,'textarea');
		se = $(this).find('select');
		option = se.find('option');
		placeholder = se.attr('placeholder');
		width = se.attr('width');
		height = se.attr('height');
		maxheight = se.attr('maxheight');
		if(se[0].hasAttribute('readonly')){
			$(this).addClass('readonly');
		}
		if(se[0].hasAttribute('multiple')){
			selecthtml = $('<div style="'+(width?'width:'+width+(width.search('%')?'':'px')+';':'')+'">'+
							 '<dfn><u>全选</u></dfn>'+
							 '<ins><ul'+(height?' style="height:'+height+'px;"':'')+'></ul></ins>'+
						   '</div>'+textarea);
		}else{
			selecthtml = $('<dl style="'+(width?'width:'+width+(width.search('%')?'':'px')+';':'')+'">'+
							 '<dt><input disabled'+(placeholder?' placeholder="'+placeholder+'"':'')+'></dt>'+
							 '<dd><ul style="'+(height?'height:'+height+'px;':'')+(maxheight?'max-height:'+maxheight+'px;':'')+'"></ul></dd>'+
						   '</dl>'+textarea);
		}
		if(se[0].hasAttribute('first') && se.find('option[selected]').length==0){
			option.eq(0).attr('selected','selected');
		}
		option.each(function(index, element) {
			val = $(this).attr('value');
			val = val.indexOf($.P)>=0?'':' value="'+$.quotesFilter(val)+'"';
			htm = $(this).html();boss_cms=true;
			on = $(this)[0].hasAttribute('selected')?' class="on"':'';
			li = '<li'+val+on+'>'+htm+'</li>';
			selecthtml.find('ul').append(li);
		});
		$(this).html(selecthtml).addClass('init');
		selectfunc.val($(this));
	});
}
select_init($('code.select'));
$(document)
.on('click','code.select div dfn u',function(){
	selects = $(this).parents('code.select');
	if($(this).hasClass('on')){
		selects.find('div ins ul li.on:not(.hide)').removeClass('on');
	}else{
		selects.find('div ins ul li:not(.on):not(.hide)').addClass('on');
	}
	selectfunc.val(selects);
})
.on('click','code.select div ins ul li[value]',function(){
	selects = $(this).parents('code.select');
	if(selects.find('textarea[name][readonly]').length==0){
		if($(this).hasClass('on')){
			$(this).removeClass('on');
		}else{
			$(this).addClass('on');
		}
		selectfunc.val(selects);
	}
})
.on('click','code.select dl dd ul li[value]',function(){
	selects = $(this).parents('code.select');
	if(selects.find('textarea[name][readonly]').length==0){
		if(!$(this).hasClass('on')){
			$(this).siblings('li').removeClass('on');
			$(this).addClass('on');
			selectfunc.val(selects);
		}
		selects.find('dl').removeClass('on');
	}
})
.on('click','code.select dl dt',function(){
	dl = $(this).parent('dl');
	if(dl.hasClass('on')){
		dl.removeClass('on');
	}else{
		dl.addClass('on');
	}
})
.on('mouseleave','code.select dl',function(){
	$(this).removeClass('on');
});





/* 滚动条 */
var seekbar,
	seekbarWS = 0;
	seekbarWX = 1;
	seekbarWidth = seekbarX = seekbarMin = seekbarMax = 100,
	seekbarStep = seekbarStep = 1,
	seekbarBool = false;
seekbarfunc = {
	assign: function(seekbar){
		seekbarWidth = seekbar.find('dfn').width();
		skta = seekbar.find('textarea');
		seekbarMin = Number(skta.attr('min'));
		seekbarMin = seekbarMin?seekbarMin:0;
		seekbarMax = Number(skta.attr('max'));
		seekbarMax = seekbarMax?seekbarMax:100;
		seekbarStep = Number(skta.attr('step'));
		seekbarStep = seekbarStep?seekbarStep:1;
		seekbarWS = 0;
		seekbarWX = 1;
		if(String(seekbarStep).indexOf('.') != -1){
			seekbarWS = String(seekbarStep).split('.')[1].length;
			seekbarWX = Number('1000000000000'.substr(0,seekbarWS+1));
			seekbarMin *= seekbarWX;
			seekbarMax *= seekbarWX;
			seekbarStep *= seekbarWX;
		}
	},
	val: function(seekbar, val){
		seekbar.find('div>span').html(val);
		if(seekbar.find('textarea').val() != val){
			seekbar.find('textarea').text(val).val(val).change();
		}
		this.assign(seekbar);
		seekbarLeft = (val*seekbarWX - seekbarMin)/(seekbarMax - seekbarMin);
		seekbar.find('div>dfn>i').css("left",seekbarLeft*100+'%');
		seekbar.find('div>dfn>p>b').width(seekbarLeft*100+'%');
	}
}
function seekbar_init(obj){
	obj.each(function(index, element){
		seekbarhtml = $('<div>'+
						  '<dfn>'+
							'<i></i>'+
							'<p><b></b></p>'+
						  '</dfn>'+
						  '<span></span>'+
						'</div>');
		$(this).prepend(seekbarhtml);
		seekbarfunc.val($(this), $(this).find('textarea').val());
	});
}
seekbar_init($('code.seekbar'));
$(document)
.mousemove(function(e){
	if(seekbarBool){
		window.getSelection?window.getSelection().removeAllRanges():document.selection.empty();
		seekbarLeft = (e.clientX-seekbarX)/seekbarWidth;
		if(seekbarLeft<0){
			seekbarLeft = 0;
		}else if(seekbarLeft>1){
			seekbarLeft = 1;
		}
		seekbar.find('div>dfn>i').css("left",seekbarLeft*100+'%');
		seekbar.find('div>dfn>p>b').width(seekbarLeft*100+'%');
		val = (seekbarMax - seekbarMin)*seekbarLeft + seekbarMin;
		if(val!=seekbarMax && val%(seekbarStep)!=0){
			val = val-val%(seekbarStep);
		}
		val = (val/seekbarWX).toFixed(seekbarWS);
		seekbar.find('div>span').html(val);
		seekbar.find('textarea').text(val).val(val).change();
	}
}).mouseup(function(){
	if(seekbarBool){
		seekbar.removeClass('mouse');
		seekbarBool = false;
		seekbar.find('textarea').change();
	}
})
.on('mousedown','code.seekbar div dfn i',function(){
	seekbar = $(this).parents('code.seekbar');
	seekbar.addClass('mouse');
	seekbarX = event.clientX-$(this).position().left;
	seekbarfunc.assign(seekbar);
	seekbarBool = true;  
});

		




/* 颜色选择器 */
var colorfunc = {
	li: function(red, green, blue, alpha, bg){
		return '<li'+(bg?' class="'+bg+'"':'')+' style="background-color:rgba('+red+','+green+','+blue+','+alpha+');"></li>';
	},
	pehtml: [],
	plate: function(red, green, blue){
		pe = (red+'888'+green+'888'+blue)*1;
		if(!this.pehtml[pe]){
			this.pehtml[pe] = '';
			for(y=256;y>=1;y--){
				if((y-1)%5==0){
					for(x=1;x<=256;x++){
						if((x-1)%5==0){
							r = Math.ceil(y-x/256*(y-(red+1)*(y/256))-1);
							g = Math.ceil(y-x/256*(y-(green+1)*(y/256))-1);
							b = Math.ceil(y-x/256*(y-(blue+1)*(y/256))-1);
							this.pehtml[pe] += this.li(r,g,b,1,0);
						}
					}
				}
			}
		}
		return this.pehtml[pe];
	},
	rwhtml: false,
	rainbow: function(){
		if(!this.rwhtml){
			this.rwhtml = '';
			for(i=0;i<=41;i++){
				this.rwhtml += this.li(255,0,Math.ceil(255/42*i),1,0);
			}
			for(i=0;i<=40;i++){
				this.rwhtml += this.li(Math.ceil(255/41*(41-i)),0,255,1,0);
			}
			for(i=0;i<=40;i++){
				this.rwhtml += this.li(0,Math.ceil(255/41*i),255,1,0);
			}
			for(i=0;i<=41;i++){
				this.rwhtml += this.li(0,255,Math.ceil(255/42*(42-i)),1,0);
			}
			for(i=0;i<=41;i++){
				this.rwhtml += this.li(Math.ceil(255/42*i),255,0,1,0);
			}
			for(i=0;i<=41;i++){
				this.rwhtml += this.li(255,Math.ceil(255/41*(41-i)),0,1,0);
			}
		}
		return this.rwhtml;
	},
	gyhtml: [],
	grey: function(red, green, blue){
		gy = (red+'888'+green+'888'+blue)*1;
		if(!this.gyhtml[gy]){
			this.gyhtml[gy] = '';		
			for(a=100;a>=1;a--){
				this.gyhtml[gy] += this.li(red,green,blue,a/100,0);
			}
		}
		return this.gyhtml[gy];
	},
	mehtml: false,
	mejson: [
		{ start: [255,  82,  82], end: [155,  22,  22], grey: [  0,   0,   0, 0], bg: 'bgalpha' },
		{ start: [191, 105, 205], end: [ 71,  19, 131], grey: [255, 255, 255, 1], bg: false },
		{ start: [127, 147, 255], end: [ 60,  74, 154], grey: [204, 204, 204, 1], bg: false },
		{ start: [169, 230, 230], end: [  9, 150, 164], grey: [153, 153, 153, 1], bg: false },
		{ start: [155, 236, 197], end: [ 25, 139,  75], grey: [102, 102, 102, 1], bg: false },
		{ start: [240, 240,  43], end: [235, 209,   5], grey: [ 51,  51,  51, 1], bg: false },
		{ start: [255, 190, 106], end: [220, 114,  25], grey: [  0,   0,   0, 1], bg: false }
	],
	more: function(){
		if(!this.mehtml){
			this.mehtml = '';
			for(i=0;i<=6;i++){
				this.mehtml += '<ol>';
				data = this.mejson[i];
				for(j=0;j<=6;j++){
					if(j!=6){
						r = Math.ceil(data.start[0] + (data.end[0] - data.start[0])/7*j);
						g = Math.ceil(data.start[1] + (data.end[1] - data.start[1])/7*j);
						b = Math.ceil(data.start[2] + (data.end[2] - data.start[2])/7*j);
						a = 1;
						bg = '';
					}else{
						r = data.grey[0];
						g = data.grey[1];
						b = data.grey[2];
						a = data.grey[3];
						bg = data.bg;
					}
					this.mehtml += this.li(r,g,b,a,bg);
				}
				this.mehtml += '</ol>';
			}
		}
		return this.mehtml;
	},
	val: function(color, val){
		val = val.replace(/\s/g,'');
		textarea = color.find('textarea');
		if(textarea[0].hasAttribute('hexcolor') && val.match(/^rgb/) && (cs=val.match(/[\d\.]+/g))){
			ol = '#';
			ol += Number(cs[0]).toString(16).padStart(2).replace(' ',0);
			ol += Number(cs[1]).toString(16).padStart(2).replace(' ',0);
			ol += Number(cs[2]).toString(16).padStart(2).replace(' ',0);
			if(cs[3] && cs[3]!=1){
				ol += Math.round(Number(cs[3])*255).toString(16).padStart(2).replace(' ',0);
			}
			val = ol;
		}
		color.find('div p ins em').css('background-color', val);
		color.find('div p input').val(val);
		if(textarea.val().replace(/\s/g,'') != val){
			textarea.text(val).val(val).change();
		}
	},
	touch: function(color, val){
		if(!val) val='rgb(255,0,0)';
		rgb = this.rgba(val);
		boss_cms = true;
		color.find('div dl dd ul.plate').html( this.plate(rgb[0]*1,rgb[1]*1,rgb[2]*1) );
		color.find('div dl dd ul.grey').html( this.grey(rgb[0]*1,rgb[1]*1,rgb[2]*1) );
		color.find('div dl dd ul.plate li').eq(51).addClass('on');
		if(rgb[3] && rgb[3]!=1 && rgb[3]!=0){
			color.find('div dl dd ul.grey li[style*="'+rgb[3]+')"]').addClass('on');
		}
	},
	alpha: function(color, val){
		if(color.find('div dl dd ul.grey li.on').length>0){
			alpha = Math.ceil(100-color.find('div dl dd ul.grey li.on').index())/100;
			if(alpha!=1 && alpha!=0){
				rgb = this.rgba(val);
				return 'rgba('+rgb[0]+','+rgb[1]+','+rgb[2]+','+alpha+')';
			}
		}
		return val;
	},
	rgba: function(val){
		if(!val.match(/^rgb/)){
			div = $('<div></div>');
			div.css('background-color', val);
			val = div.css('background-color');
			div.remove();
		}
		return val.replace(/\s/g,'').match(/[\d\.]+/g);
	}
}
function color_init(obj){
	obj.each(function(){
		val = $(this).find('textarea').val()
		colorhtml = $('<div>'+
					   '<p>'+
						 '<ins class="bgalpha">'+
						   '<em></em>'+
						 '</ins>'+
						 '<input />'+
					   '</p>'+
					 '</div>');
		colorhtml.find('p em').attr('title','选择颜色');
		$(this).prepend(colorhtml);
		colorfunc.val($(this), $(this).find('textarea').val());
	});
}
color_init($('code.color'));
$(document)
.on('click','code.color div p ins em',function(){
	color = $(this).parents('code.color');
	if($(this).hasClass('on')){
		$(this).removeClass('on');
		color.find('div dl').remove();
	}else{
		$(this).addClass('on');
		color.find('div p').after(
		'<dl>'+
			'<dt>'+colorfunc.more()+'</dt>'+
			'<dd>'+
				'<ul class="plate"></ul>'+
				'<ul class="rainbow">'+colorfunc.rainbow()+'</ul>'+
				'<ul class="grey bgalpha"></ul>'+
			'</dd>'+
		'</dl>');
		colorfunc.touch(color, color.find('div p input').val());
	}
})
.on('change','code.color div p input',function(){
	color = $(this).parents('code.color');
	inpval = $(this).val();
	if(inpval!=''){
		div = $('<div></div>');
		div.css('background-color', inpval);
		inpval = div.css('background-color');
		div.remove();
		if(inpval!=''){
			colorfunc.val(color, inpval);
			colorfunc.touch(color, inpval);
		}else{
			_alert('不是有效CSS颜色值');
		}
	}else{
		colorfunc.val(color, '');
	}
})
.on('mouseup','code.color div dl li',function(){
	ul = $(this).parent('ul');
	ul.find('li.on').removeClass('on');
	$(this).addClass('on');
	color = $(this).parents('code.color');
	val = colorfunc.alpha(color,$(this).css('background-color'));
	colorfunc.val(color,val);
})
.on('click','code.color div dl dd ul.rainbow li',function(){
	color = $(this).parents('code.color');
	val = colorfunc.alpha(color,$(this).css('background-color'));
	colorfunc.touch(color,val);
})
.on('click','code.color div dl dt ol li',function(){
	color = $(this).parents('code.color');
	val = colorfunc.alpha(color,$(this).css('background-color'));
	colorfunc.touch(color,val);
	color.find('div dl dd ul.rainbow li').removeClass('on');
});


var linkfunc = {
	val: function(linkage, val){
		linkage.find('div>p>input').attr('value',val).val(val);
		if(val != linkage.find('textarea').val()){
			linkage.find('textarea').html(val).val(val).change();
		}
	},
	type: function(linkage, str){
		if(typeof(jsonCtrl)=='object' && !linkage.find('main>.con section.'+str).hasClass('active')){
			switch(str){
				case 'diy':
					shtml = '<article class="hint"><i class="fa fa-info-circle"></i><p>选择首页或自定义的单页后，点击该链接会跳转到对应页面</p></article><ul>';
					for(d in jsonCtrl.diypage){
						if(jsonCtrl.diypage[d].class == 'home'){
							shtml += '<li><a url="/pages/home/home">'+jsonCtrl.diypage[d].title+'</a></li>';
						}else if(jsonCtrl.diypage[d].class == 'page'){
							shtml += '<li><a url="/pages/page/page?diypage='+jsonCtrl.diypage[d].id+'">'+jsonCtrl.diypage[d].title+'</a></li>';
						}
					}
					shtml += '</ul>';
					linkage.find('main>.con section.diy').html(shtml).addClass('active');
					break;
				case 'items':
					$.get($.mpf('miniprogram','renovation','items'),function(res){
						rname = linkage.find('textarea[name]').attr('name').replace(/[^\w]+/g,'');
						shtml = '<article class="hint"><i class="fa fa-info-circle"></i><p>选择需要跳转的栏目页面，使用类型为：新闻、产品、图片、下载和搜索</p></article>';
						shtml += '<section class="tree" tree="miniprogram'+rname+'" cookie="MiniprogramTree'+rname+'"><ul>';
						for(v in res){
							shtml += '<li level="'+res[v].level+'" items="'+res[v].id+'" it="'+res[v].id+'">';
							shtml += '<span lv><b></b></span>';
							shtml += '<a '+(res[v].class?'url="/pages/'+res[v].class+'/'+res[v].class+'?items='+res[v].id+'"':'')+'>'+res[v].name+'</a>';
							shtml += '</li>';
						}
						shtml += '</ul></section>';
						linkage.find('main>.con section.items').html(shtml).addClass('active');
						tree_init($('section.tree[tree="miniprogram'+rname+'"]'));
					},'json');
					break;
			}
		}
	}
}
function linkage_init(obj){
	obj.each(function(index, element){
		$(this).prepend('<div>'+
							'<p>'+
								'<ins>'+
									'<em class="fa fa-link" title="选择链接"></em>'+
								'</ins>'+
								'<input placeholder="请输入链接地址" />'+
							'</p>'+
						'</div>');
		linkfunc.val($(this), $(this).find('textarea').val());
	});
}
linkage_init($('code.linkage'));
$(document)
.on('click','code.linkage div>p>ins>em',function(){
	linkage = $(this).parents('code.linkage');
	var o = {
		width: 960,
		height: 580,
		left: (window.innerWidth>960?(window.innerWidth/2-960/2):0),
		top: (window.innerHeight>580?(window.innerHeight/2-580/2):0)
	}
	if(linkage.find('div section.easy').length>0){
		if(!linkage.find('div section.easy').hasClass('active')){
			linkage.find('div section.easy').addClass('active').find('.window').css(o);
		}
	}else{
		linkage.find('div').append(easyhtml('<div class="contain">'+
		'<menu><a class="button blue" href="javascript:;"><em class="fa fa-check-square-o"></em><font>选择</font></a></menu>'+
		'<main>'+
		'<div class="tab"><ul><li class="on" type="diy">Diy页面</li><li type="items">栏目</li></ul></div>'+
		'<div class="con"><section class="diy on"></section><section class="items"></section></div>'+	
		'</main>'+
		'</div>','选择链接',o.width,o.height,o.left,o.top));
	}
	linkfunc.type(linkage, 'diy');
}).on('click','code.linkage main>.tab ul li',function(){
	linkage = $(this).parents('code.linkage');
	linkage.find('main>.tab ul li').removeClass('on');
	$(this).addClass('on');
	linkage.find('main>.con>section').removeClass('on');
	linktype = $(this).attr('type');
	linkage.find('main>.con>section.'+linktype).addClass('on');
	linkfunc.type(linkage, linktype);
}).on('click','code.linkage main>.con section.diy ul li',function(){
	linkage = $(this).parents('code.linkage');
	linkage.find('main>.con section li.on').removeClass('on');
	$(this).addClass('on');
}).on('click','code.linkage main>.con section.items ul li a',function(){
	linkage = $(this).parents('code.linkage');
	if($(this).attr('url')){
		linkage.find('main>.con section li.on').removeClass('on');
		$(this).parent('li').addClass('on');
	}
}).on('click','code.linkage menu>a',function(){
	linkage = $(this).parents('code.linkage');
	if(linkage.find('main>.con section li.on a[url]').length>0){
		linkfunc.val(linkage, linkage.find('main>.con section li.on a').attr('url'));
	}else{
		linkfunc.val(linkage, '');
	}
	linkage.find('section.easy span.close em.fa-times').click();
}).on('change','code.linkage div>p>input',function(){
	linkage = $(this).parents('code.linkage');
	linkfunc.val(linkage, $(this).val());
});






/* 上传控件 BOSSCMS */
var extension = JSON.parse('[]');
for(k in $ext){
	for(i in $ext[k]){
		extension[$ext[k][i]] = k;
	}
}
var upfunc = {
	li: function(path, dir, folder, on, em, rand, a){
		type = false;
		if(mat = path.match(/\.\w+(?:$|\?)/)){
			type = extension[mat[0]];
		}
		if(!type){
			if(path.indexOf('upload/')>=0 && path.indexOf('://')<0){
				type = path.match(/upload\/([^\/\.]+)/)[1];
			}else{
				accept = '';
				for(k in $ext['photo']){
					accept += (accept?',':'')+$ext['photo'][k];
				}
				et = path.match(/\.\w+$/);
				type = et&&accept.toLowerCase().indexOf(et[0])>=0?'photo':'file';
			}
		}
		return '<li class="upbox '+(on?'on':'')+' '+(dir?'dir':'')+'" path="'+$.quotesFilter(path)+'" title="'+folder+'">'+
					(a?'':'<b>&check;</b>')+
					(em?'<em>&times;</em>':'')+
					(
						dir?
						'<i>'+
							'<span class="'+(path=='../'?'folder':'dir')+'">'+
								(path=='../'?'返回<br>&#10550;':path.match(/[^\/]+$/)[0])+
							'</span>'+
						'</i>':
						(
							(
								type=='photo'?
								(a?'<a href="'+$.quotesFilter(path)+'" target="_blank">':'')+'<i><img src="'+$.quotesFilter(rand?$.srcRand(path):path)+'" /><h3 class="fa fa-file-photo-o">'+path+'</h3></i>'+(a?'</a>':''):
								'<i><span class="'+type+'"></span><h3 class="fa fa-file-text-o">'+path+'</h3></i>'
							)+
							(a?'':'<u>删除</u>')
						)
					)+
			   '</li>'
	},
	/* 赋值前操作 */
	rep: function(upfile, data){
		data = data.replace(new RegExp($G['upload'].replace(/([\(\)\[\]\{\}\^\$\+\-\*\?\.\"\'\|\/\\])/g,"\\$1"),"g"),'..//upload/');
		upfile.find('textarea').html(data).val(data).change();
	},
	/* 多图片json值 */
	val: function(upfile){
		this.vals(upfile);
	},
	vals: function(upfile){
		li = upfile.find('div ul li');
		jn = JSON.parse('[]');
		li.each(function(i,e) {
			jn[i] = $(this).attr('path');
		});
		this.rep(upfile, (jn.length>0?JSON.stringify(jn):''));
	},
	/* 文件列表ajax获取 */
	olli: function(upfile,folder,start){
		$.ajax({
			url: $G['relative']+"system/extend/ueditor/php/controller.php",
			type: 'GET',
			cache: false,
			data: "action=list"+upfile.attr('upfile').replace(/s$/,'')+"&folder="+folder+"&start="+start+"&size=28&type="+$.getCookie('upfileEasyType')+"&bosscms=true&referer="+encodeURIComponent(window.location.href),
			processData: false,
			contentType: false,
			dataType: "json",
			success: function(data){
				if(data.state == 'SUCCESS'){
					txtval = '"'+upfile.find('textarea').val()+'"';
					ol = '<dfn class="'+$.getCookie('upfileEasyType')+'">'+
					  '<a class="back button red tfa"'+((folder=='' || folder=='/')?'':' folder="'+folder.replace(/[^\/]+\/$/,'')+'"')+' href="javascript:;">'+
						'<em class="fa fa-reply"></em>'+
						'<font>返回</font>'+
					  '</a>'+
					  '<a class="upload button green tfa" href="javascript:;">'+
						'<em class="fa fa-upload"></em>'+
						'<font>上传</font>'+
					  '</a>'+
					  '<a class="type '+$.getCookie('upfileEasyType')+'" href="javascript:;">'+
						'<em class="fa fa-list" data="列表模式"></em>'+
						'<em class="fa fa-th" data="目录模式"></em>'+
					  '</a>'+
					'</dfn>';
					for(i in data.list){
						path = data.list[i].url;
						ol += upfunc.li(path, data.list[i].dir, data.list[i].folder, txtval.indexOf('"'+path.replace(new RegExp($G['upload'].replace(/([\(\)\[\]\{\}\^\$\+\-\*\?\.\"\'\|\/\\])/g,"\\$1"),"g"),'..//upload/')+'"')>=0, false, false, false);
					}
					page = Math.ceil(data.total / data.size);
					if(page>1){
						ol += '<ins><i class="fa fa-angle-left"></i>';
						for(i=1;i<=page;i++){
							st = (i-1)*data.size;
							ol += '<i start="'+st+'" class="'+(data.start==st?'on':'')+'">'+i+'</i>';
						}
						ol += '<i class="fa fa-angle-right"></i></ins>';
					}
					var o = {
						width: 960,
						height: 580,
						left: (window.innerWidth>960?(window.innerWidth/2-960/2):0),
						top: (window.innerHeight>580?(window.innerHeight/2-580/2):0)
					}
					ol += (ol.indexOf('</li>')>0?'':'<h2>文件夹为空</h2>');
					if(upfile.find('div section.easy').length>0){
						if(!upfile.find('div section.easy').hasClass('active')){
							upfile.find('div section.easy').addClass('active').find('.window').css(o);
						}
						upfile.find('div section.easy').find('.contain ol').html(ol);
					}else{
						upfile.find('div').append(easyhtml('<div class="contain">'+
						  '<menu><a class="button blue" href="javascript:;"><em class="fa fa-check-square-o"></em><font>选择</font></a></menu>'+
						  '<main>'+
						    '<ol>'+ol+'</ol>'+
						  '</main>'+
						'</div>','文件库',o.width,o.height,o.left,o.top));
					}
					upfile.find('div p ins em.fa-folder-open')
						.attr('start',start)
						.attr('folder',folder);
					upfile.find('div section.easy .contain main').scrollTop(0);
				}else{
					_alert('网络错误');
				}
			}
		});
	}
}
function upfile_init(obj){
	obj.each(function(index, element) {
		uphtml = $('<div>'+
					 '<ul></ul>'+
					 '<p>'+
					   '<ins>'+
						 '<em class="fa fa-upload" title="上传"></em>'+
						 '<em class="fa fa-folder-open" title="图库"></em>'+
						 ($(this).find('textarea')[0].hasAttribute('unlink')?'':'<em class="fa fa-link" title="外链"></em>')+
					   '</ins>'+
					   '<input placeholder="请输入图片地址" />'+
					   '<i>确定</i>'+
					 '</p>'+
				   '</div>');
		txtval = $(this).find('textarea').val().replace(/\.\.\/\/upload\//g,$G['upload']);
		ul = '';
		switch($(this).attr('upfile')){
			case 'image':
			case 'video':
			case 'file':
				if(txtval){
					uphtml.find('p input').val(txtval);
					ul = upfunc.li(txtval, false, '', true, true, true, true);
				}
			break;
			case 'images':
				txtval = JSON.parse(txtval||'[]');
				for(i in txtval){
					if(i == 0){
						uphtml.find('p input').val(txtval[i]);
					}
					ul += upfunc.li(txtval[i], false, '', i==0, true, true, true);
				}
			break;
		}
		if(ul){
			uphtml.find('ul').html(ul);
		}
		$(this).prepend(uphtml);
	});
}
upfile_init($('code.upfile'));
var mX = mY = upMove = upThe = 0;
var upFiles = upThe = upHtml = upNew = upTheHref = '';
$(document)
.mousemove(function(e){
	mX = e.pageX;
	mY = e.pageY;
	if(upMove === 1){
		upMove = 2;
		upTheHref = upThe.find('a').attr('href');
		upThe.find('a').removeAttr('href');
		upThe.addClass('move');
		uX = upThe.offset().left;
		uY = upThe.offset().top;
		upHtml = upThe[0].outerHTML;
		$('body').append('<div id="upNew">'+upHtml+'</div>');
		upNew = $('#upNew');
		upNew
		.css('left',mX)
		.css('top',mY)
		.css('margin-left',-Math.abs(mX-uX))
		.css('margin-top',-Math.abs(mY-uY))
		.width(upThe.outerWidth())
		.height(upThe.outerHeight());
	}else if(upMove === 2){
		upNew.show()
		.css('left',mX-$(window).scrollLeft())
		.css('top',mY-$(window).scrollTop());
		upFiles.find('div>ul>li').each(function(){
			the = $(this);
			l = $(this).offset().left;
			t = $(this).offset().top;
			r = l+$(this).outerWidth();
			b = t+$(this).outerHeight();
			if(mY>t && mY<b && mX>l && mX<r && !the.hasClass('move')){
				if(the.prev('li').hasClass('move')){
					upFiles.find('li.move').remove();
					the.after(upHtml);
				}else{
					upFiles.find('li.move').remove();
					the.before(upHtml);
				}
			}
		});
	}
})
.mouseup(function(){
	if(upMove === 2){
		upNew.remove();
		upfunc.vals(upFiles);
		upFiles.find('li.move').removeClass('move')
			.find('a').attr('href', upTheHref);
	}
	if(upMove){
		upMove = 0;
		return false;
	}
})
.on('mousedown','code.upfile div ul li',function(e){
	if(e.which == 1){
		upfile = $(this).parents('code.upfile');
		if(upfile.attr('upfile') == 'images'){
			upMove = 1;
			upThe = $(this);
			upFiles = upfile;
		}
	}
})
/* 展示图上删除按钮 */
.on('click','code.upfile div ul li em',function(){
	upfile = $(this).parents('code.upfile');
	switch(upfile.attr('upfile')){
		case 'image':
		case 'video':
		case 'file':
			upfile.find('div p input').val('');
			upfile.find('div ul').html('');
			upfile.find('div section.easy ol li.on').removeClass('on');
			upfile.find('textarea').text('').val('').change();
		break;
		case 'images':
			li = $(this).parent('li');
			upfile.find('div section.easy ol li[path="'+li.attr('path')+'"]').removeClass('on');
			if(li.hasClass('on')){
				upfile.find('div p input').text('').val('').change();
			}
			li.remove();
			upfunc.vals(upfile);
		break;
	}
})
/* 展示图单个按钮 */
.on('mousedown','code.upfile div ul li a i',function(){
	upfile = $(this).parents('code.upfile');
	li = $(this).parents('li');
	if(upfile.attr('upfile') == 'images'){
		if(!li.hasClass('on')){
			upfile.find('div p input').val(li.attr('path'));
			upfile.find('div ul li.on').removeClass('on');
			li.addClass('on');
		}
	}else{
		upfile.find('div p input').val(li.attr('path'));
	}
})
/* 文本框自动触发 BOSS+CMS */
.on('change','code.upfile div p input',function(){
	upfile = $(this).parents('code.upfile');
	inpval = $(this).val();
	if(inpval != ''){
		switch(upfile.attr('upfile')){
			case 'image':
			case 'video':
			case 'file':
				upfile.find('div section.easy ol li.on').removeClass('on');
				upfile.find('div ul').html( upfunc.li(inpval, false, '', true, true, true, true) );
				upfunc.rep(upfile, inpval);
			break;
			case 'images':
				upfile.find('div ul').append( upfunc.li(inpval, false, '', true, true, true, true) );
				upfunc.vals(upfile);
			break;
		}
		upfile.find('div section.easy ol li[path="'+inpval+'"]').addClass('on');
	}
})
/* 模式按钮 */
.on('mousedown','code.upfile div dfn a.type',function(){
	upfile = $(this).parents('code.upfile');
	upfile.find('div section.easy ol').html('');
	if($.getCookie('upfileEasyType')){
		$(this).removeClass('on').parent('dfn').removeClass('on');
		$.setCookie('upfileEasyType','');
	}else{
		$(this).addClass('on').parent('dfn').addClass('on');
		$.setCookie('upfileEasyType','on');
	}
	upfunc.olli(upfile, '', 0);
})
/* 确定按钮 */
.on('mousedown','code.upfile div p i',function(){
	upfile = $(this).parents('code.upfile');
	upfile.find('div p').removeClass('on');
})
/* 上传按钮 */
.on('click','code.upfile div p ins em.fa-upload',function(){
	upfile = $(this).parents('code.upfile');
	restric = false;
	if(accept = upfile.find('textarea').attr('accept')){
		restric = true;
	}else if(upfile.attr('upfile').match(/image/)){
		accept = '';
		for(k in $ext['photo']){
			accept += (accept?',':'')+$ext['photo'][k];
		}
	}else if(upfile.attr('upfile')=='video'){
		accept = '';
		for(k in $ext['movie']){
			accept += (accept?',':'')+$ext['movie'][k];
		}
	}
	input = $('<input type="file" '+(accept?'accept="'+accept+'"':'')+'>');
	if(upfile.attr('upfile').match(/s$/)){
		input.attr('multiple','multiple');
	}
	input.change(function(el){
		upfile.find('div ul li[sort]').removeAttr('sort');
		files = el.currentTarget.files;
		for(f in files){
			if(typeof(files[f])=='object'){
				if(!restric || (restric && accept.toLowerCase().indexOf(files[f].name.match(/\.\w+$/)[0])>=0)){
					formData = new FormData();
					formData.append("upfile", files[f]);
					formData.append("sort", f);
						$.ajax({
							url: $G['relative']+"system/extend/ueditor/php/controller.php?action=upload"+upfile.attr('upfile').replace(/s$/,'')+"&referer="+encodeURIComponent(window.location.href),
							type: 'POST',
							cache: false,
							data: formData,
							processData: false,
							contentType: false,
							dataType: "json",
							success: function(data) {
							if(data.state == 'SUCCESS'){
								upfile.find('div p input').val(data.url);
								switch(upfile.attr('upfile')){
									case 'image':
									case 'video':
									case 'file':
										upfile.find('div ul').html( upfunc.li(data.url, false, '', true, true, true, true) );
										upfunc.rep(upfile, data.url);
									break;
									case 'images':
										upfile.find('div ul li.on').removeClass('on');
										ul = upfile.find('div ul');
										li = upfunc.li(data.url, false, '', true, true, true, true).replace('<li ','<li sort="'+data.sort+'" ');
										so = ul.find('li[sort]');
										if(so.length==0){
											ul.append( li );
										}else{
											ok = false;
											so.each(function(){
												if($(this).attr('sort')*1>data.sort*1){
													$(this).before( li );
													ok = true;
													return false;
												}
											});
											if(!ok){
												ul.append( li );
											}
										}
										upfunc.vals(upfile);
									break;
								}
							}else{
								_alert(data.state);
							}
						}
					});
				}else{
					_alert('文件格式错误');
				}
			}
		}
		input.remove();
	}).click();
})
.on('click','code.upfile div section.easy dfn a.upload',function(){
	upfile = $(this).parents('code.upfile');
	$.get($G['relative']+"system/extend/ueditor/php/controller.php?action=config&referer="+encodeURIComponent(window.location.href),function($config){
		input = $('<input type="file" multiple="multiple">');
		input.change(function(el){
			files = el.currentTarget.files;
			for(f in files){
				if(typeof(files[f]) == 'object'){
					formData = new FormData();
					formData.append("upfile", files[f]);
					uptype = upfile.attr('upfile').replace(/s$/,'');
					$.ajax({
						url: $G['relative']+"system/extend/ueditor/php/controller.php?action=upload"+uptype+"&referer="+encodeURIComponent(window.location.href),
						type: 'POST',
						cache: false,
						data: formData,
						processData: false,
						contentType: false,
						dataType: "json",
						success: function(data) {
							if(data.state == 'SUCCESS'){
								if($.getCookie('upfileEasyType')){
									folder = data.url.replace(/[^\/]+$/,'').replace(/^.+upload\//,'upload/').replace($config[uptype+'ManagerListPath'],'');
								}else{
									folder = '';
								}
								upfunc.olli(upfile, folder, 0);
							}else{
								_alert(data.state);
							}
						}
					});
				}
			}
			input.remove();
		}).click();
	},'json');
})
/* 打开文件列表按钮 */
.on('click','code.upfile div p ins em.fa-folder-open',function(){
	upfile = $(this).parents('code.upfile');
	if(upfile.find('div p').hasClass('on')){
		upfile.find('div p ins em.fa-link').click();
	}
	active = upfile.find('section.easy').hasClass('active');
	upfunc.olli(upfile, (active&&$(this).attr('folder'))||'', (active&&$(this).attr('start'))||0);
})
/* 返回按钮 */
.on('click','code.upfile div dfn a.back',function(){
	upfile = $(this).parents('code.upfile');
	upfunc.olli(upfile, $(this).attr('folder')||'', 0);
})
/* 确定按钮 */
.on('click','code.upfile div menu a',function(){
	upfile = $(this).parents('code.upfile');
	upfile.find('section.easy span.close em.fa-times').click();
})
/* 打开外部链接按钮 */
.on('click','code.upfile div p ins em.fa-link',function(){
	upfile = $(this).parents('code.upfile');
	p = upfile.find('div p');
	if(p.hasClass('on')){
		p.removeClass('on');
	}else{
		p.addClass('on');
		p.find('input').val('').focus();
	}
})
/* 文件列表单个删除按钮 */
.on('click','code.upfile div section.easy ol li u',function(){
	if(confirm('确定删除该文件吗？')){
		(function(li){
			$.ajax({
				url: $G['relative']+"system/extend/ueditor/php/controller.php?action=delete&referer="+encodeURIComponent(window.location.href),
				type: 'POST',
				cache: false,
				data: {path: li.attr('path')},
				dataType: "json",
				success: function(data) {
					if(data.state == 'SUCCESS'){
						li.fadeOut(333,function(){
							li.remove();
							_alert('删除成功','green');
						});
					}else{
						_alert(data.state);
					}
				}
			});
		})($(this).parent('li'));
	}
})
/* 文件列表单个选中按钮 */
.on('click','code.upfile div section.easy ol li i',function(){
	upfile = $(this).parents('code.upfile');
	li = $(this).parent('li');
	if(li.hasClass('dir')){
		upfunc.olli(upfile, li.attr('title'), 0);
	}else{	
		path = li.attr('path');
		switch(upfile.attr('upfile')){
			case 'image':
			case 'video':
			case 'file':
				if(li.hasClass('on')){
					li.removeClass('on')
					upfile.find('div p input').val('');
					upfile.find('div ul').html('');
					upfile.find('textarea').val('');
				}else{
					upfile.find('div section.easy ol li').removeClass('on');
					li.addClass('on');
					upfile.find('div p input').val(path);
					upfile.find('div ul').html( upfunc.li(path, false, '', true, true, true, true) );
					upfunc.rep(upfile, path);
					upfile.find('div section.easy span.close em.fa-times').click();
				}
			break;
			case 'images':
				if(li.hasClass('on')){
					li.removeClass('on');
					li = upfile.find('div ul li[path="'+path+'"]');
					if(li.hasClass('on')){
						upfile.find('div p input').val('');
					}
					li.remove();
				}else{
					li.addClass('on');
					upfile.find('div p input').val(path);
					upfile.find('div ul li.on').removeClass('on');
					upfile.find('div ul').append( upfunc.li(path, false, '', true, true, true, true) );
				}
				upfunc.vals(upfile);
			break;
		}
	}
})
/* 文件列表分页按钮 */
.on('click','code.upfile div section.easy ol ins i[start]',function(){
	if(!$(this).hasClass('on')){
		upfile = $(this).parents('code.upfile');
		upfunc.olli(upfile,upfile.find('div p ins em.fa-folder-open').attr('folder')||'',$(this).attr('start'));
	}
})
.on('click','code.upfile div section.easy ol ins i.fa-angle-left',function(){
	$('code.upfile div section.easy ol ins i.on[start]').prev('i[start]').click();
})
.on('click','code.upfile div section.easy ol ins i.fa-angle-right',function(){
	$('code.upfile div section.easy ol ins i.on[start]').next('i[start]').click();
});




/* 参数设置控件 */
pmfunc = {
	value: function(param){
		switch(param.attr('param')){
			case 'odd':
				jn = JSON.parse('[]');
				param.find('ul li').each(function(i,e){
					jn[i] = $(this).find('input').val();
				});
				vl = jn.length>0?JSON.stringify(jn):'';
			break;
			case 'even':
				jn = new Object();
				param.find('ul li').each(function(){
					jn[$(this).find('input').eq(0).val()+$.P] = $(this).find('input').eq(1).val();
				});
				vl = JSON.stringify(jn).replace(new RegExp($.P,'g'),'');
				if(vl=='[]' || vl=='{}') vl='';
			break;
		}
		if(vl==''){
			param.find('u').removeClass('active');
		}else{
			param.find('u').addClass('active');
		}
		param.find('textarea[name]').html(vl).val(vl).change();
		param.parents('tr').find('input[name*="id"]').prop('checked','checked');
	}
}
function param_init(obj){
	obj.each(function(){
		pamval = $(this).attr('param');
		tetval = $(this).find('textarea[name]').val();
		rowval = $(this).find('textarea[name]').attr('row');
		offval = $(this).find('textarea[name]').attr('off');
		offval = offval?offval:'|';
		$(this).find('textarea[name]').attr('off',offval);
		cutval = $(this).find('textarea[name]').attr('cut');
		cutval = cutval?cutval:':';
		$(this).find('textarea[name]').attr('cut',cutval);
		pampla = $(this).find('textarea[name]').attr('placeholder');
		pampla = JSON.parse(pampla&&pampla!='[]'?pampla:'{"值":"选项"}');
		for(var pa in pampla) break;
		tetval = tetval.replace(new RegExp('":"','g'),$.P+'":"').match(/^[\S\s]*[\[|\{].*[\]|\}][\S\s]*$/);
		if(tetval && tetval!='[]'){
			if(pamval=='even'){
				tetval = tetval[0].match(/^(\{\}|\{\".*\"\})$/)?tetval[0]:('{"0":"'+tetval[0]+'"}');
			}else{
				tetval = tetval[0].match(/^(\[\]|\[\".*\"\])$/)?tetval[0]:('["'+tetval[0]+'"]');
			}
		}else{
			tetval = '[]';
		}
		txtval = tetval.match(/^(\{|\[)/)?JSON.parse(tetval):[];
		pmhtml = $('<div>'+
					  '<u><ul row'+rowval+'></ul></u>'+
					  '<ins>'+
						  (pamval=='even'?'<input placeholder="'+pa+'"/>':'')+
						  '<input placeholder="'+pampla[pa]+'"/>'+
						  '<i class="fa fa-plus-square" title="批量"></i>'+
						  '<i class="fa fa-times" title="删除"></i>'+
						  '<i class="fa fa-plus" title="添加"></i>'+
					  '</ins>'+
					  '<span>'+
						  '<textarea placeholder="'+pampla[pa]+'"></textarea>'+
						  '<p>'+
							  '<i class="fa fa-check" title="确定"></i>'+
							  '<font>'+
								  (pamval=='even'?'':'注意：批量添加的参数，')+
								  '请以 <b>'+offval+'</b> 作为分割符隔开每个参数；'+
								  (pamval=='even'?'单个参数再请以 <b>'+cutval+'</b> 分割字段和值':'')+
							  '</font>'+
						  '</p>'+
					  '</span>'+
				  '</div>');
		if(tetval!='' && tetval!='[]'){
			u = pmhtml.find('u');
			u.addClass('active');
			ul = u.find('ul');
			for(i in txtval){
				ul.append(
					'<li>'+
						(pamval=='even'?'<input value="'+$.quotesFilter(i).replace($.P,'')+'"/>':'')+
						'<input value="'+$.quotesFilter(txtval[i])+'"/>'+
						'<i class="fa fa-remove" title="删除"></i>'+
					'</li>'
				);
			}
		}
		$(this).prepend(pmhtml);
	});
}
param_init($('code.param'));
$(document).on('click','code.param li i',function(){
	param = $(this).parents('code.param');
	$(this).parent('li').remove();
	pmfunc.value(param);
}).on('change','code.param li input',function(){
	param = $(this).parents('code.param');
	pmfunc.value(param);
}).on('click','code.param ins i.fa-plus',function(){
	param = $(this).parents('code.param');
	ins = $(this).parent('ins');
	if(ins.hasClass('on')){
		ins.find('i.fa-plus-square').click();
	}else{
		val = ins.find('input').eq(0).val();
		if(val==''){
			ins.find('input').focus();
		}else{
			ul = param.find('ul');
			ul.append(
				'<li>'+
					'<input value="'+$.quotesFilter(val)+'"/>'+
					(param.attr('param')=='even'?'<input value="'+$.quotesFilter(ins.find('input').eq(1).val())+'"/>':'')+
					'<i class="fa fa-remove" title="删除"></i>'+
				'</li>'
			);
			pmfunc.value(param);
			ins.find('input').val('');
		}
	}
}).on('click','code.param ins i.fa-times',function(){
	param = $(this).parents('code.param');
	param.find('ul').html('');
	pmfunc.value(param);
}).on('click','code.param ins i.fa-plus-square',function(){
	param = $(this).parents('code.param');
	ins = $(this).parent('ins');
	if($(this).hasClass('on')){
		$(this).removeClass('on');
		ins.removeClass('on');
		param.find('div>span').removeClass('on');
	}else{
		$(this).addClass('on')
		ins.addClass('on');
		param.find('div>span').addClass('on');
	}
}).on('click','code.param div>span p i',function(){
	param = $(this).parents('code.param');
	textarea = param.find('div>span textarea');
	val = textarea.val();
	if(val==''){
		textarea.focus();
	}else{
		html = '';
		ul = param.find('ul');
		vs = val.split(param.find('textarea[name]').attr('off'));
		for(v in vs){
			if(param.attr('param')=='even'){
				vt = vs[v].split(param.find('textarea[name]').attr('cut'));
				html +=
				'<li>'+
					'<input value="'+$.quotesFilter(vt[0])+'"/>'+
					'<input value="'+$.quotesFilter(vt[1]?vt[1]:'')+'"/>'+
					'<i class="fa fa-remove" title="删除"></i>'+
				'</li>';
			}else{
				html +=
				'<li>'+
					'<input value="'+$.quotesFilter(vs[v])+'"/>'+
					'<i class="fa fa-remove" title="删除"></i>'+
				'</li>';
			}
		}
		ul.append(html);
		pmfunc.value(param);
		textarea.val('');
	}
});
	
	


/* 代码文本切换控件 */
togglefunc = {
	val: function(toggle, val){			
		val = val.replace(this.rep(toggle,''),'');
		toggle.children('textarea[toggle]').html(val).val(val).change();
	},
	rep: function(toggle, val, rpl){
		tetdiv = toggle.children('textarea[toggle]');
		togval = tetdiv.attr('toggle');
		if(rpl){
			togval = togval.replace(/([\(\)\^\$\+\*\.\?\|\\])/g,'\\$1');
		}
		tognam = '['+tetdiv.attr('name')+']';
		return togval.replace(tognam, val);
	},
	display: function(toggle, type){
		if(type===0){
			toggle.find('ins').css('display','block');
			toggle.find('text').css('display','none');
		}else{
			toggle.find('ins').css('display','none');
			toggle.find('text').css('display','block');
		}
	}
}
function toggle_init(obj){
	obj.each(function(){
		tetval = $(this).find('textarea[toggle]').val();
		tetwth = $(this).find('textarea[toggle]').attr('width');
		$(this).prepend('<div style="width:'+tetwth+(tetwth.indexOf('%')?'':'px')+'">'+
							'<ins>'+
								'<em class="fa fa-code" title="代码模式"></em>'+
								'<input placeholder="'+$(this).find('textarea[toggle]').attr('placeholder')+'"/>'+
							'</ins>'+
							'<text>'+
								'<textarea></textarea>'+
								'<em class="fa fa-text-height" title="文本模式"></em>'+
							'</text>'+
						'</div>');
		if(tetval != ''){
			val = tetval.match(togglefunc.rep($(this),'(.+?)',true));
			if(val){
				togglefunc.display($(this),0);
				$(this).find('ins input').val(val[1]);
				$(this).find('text textarea').val(tetval);
			}else{
				togglefunc.display($(this),1);
				$(this).find('text textarea').val(tetval);
			}
		}else{
			togglefunc.display($(this),0);
			$(this).find('text textarea').val(togglefunc.rep($(this),'',false));
		}		
	});
}
toggle_init($('code.toggle'));
$(document)
.on('change','code.toggle div ins input',function(){
	toggle = $(this).parents('code.toggle');
	tetval = togglefunc.rep(toggle,$(this).val(),false);
	toggle.find('text textarea').val(tetval);
	togglefunc.val(toggle,tetval);
})
.on('change','code.toggle div text textarea',function(){
	toggle = $(this).parents('code.toggle');
	tetval = $(this).val();
	val = tetval.match(togglefunc.rep(toggle,'(.+?)',true));
	if(val){
		toggle.find('ins input').val(val[1]);
	}else{
		toggle.find('ins input').val('');
	}
	togglefunc.val(toggle, tetval);
})
.on('click','code.toggle em.fa-code',function(){
	toggle = $(this).parents('code.toggle');
	togglefunc.display(toggle,1);
})
.on('click','code.toggle em.fa-text-height',function(){
	toggle = $(this).parents('code.toggle');
	togglefunc.display(toggle,0);
});
	
	


/* 字体图标icon选择 */
iconfunc = {
	value: function(icon, val){
		icon.find('div ins input').val(val);
		icon.find('div ins em').removeAttr('class').addClass('fa '+val);
		icon.find('.fontawesome a[data-content]').removeClass('on');
		icon.find('.fontawesome a[data-content="'+val+'"]').addClass('on');
		textarea = icon.children('textarea[icon]');
		if(textarea.val() != val){
			textarea.text(val).val(val).change();
		}
		if(val){
			icon.addClass('on');
		}else{
			icon.removeClass('on');
		}
	}
}
function icon_init(obj){
	obj.each(function(){
		$(this).prepend('<div>'+
							'<ins>'+
								'<em title="选择图标"></em>'+
								'<input/>'+
							'</ins>'+
						'</div>');
		iconfunc.value($(this), $(this).find('textarea[icon]').val());
	});
}
icon_init($('code.icon'));
$(document)
.on('change','code.icon div ins input',function(){
	icon = $(this).parents('code.icon');
	iconfunc.value(icon,$(this).val());
})
.on('click','code.icon div ins em',function(){
	icon = $(this).parents('code.icon');
	if(icon.hasClass('active')){
		icon.removeClass('active');
	}else{
		icon.addClass('active');
		if(icon.find('article').length==0){
			$.get($G['relative']+"system/admin/common/fontawesome.php?body=true", function(data){
				icon.children('div').append('<article>'+ data +'</article>');
				iconfunc.value(icon, icon.find('textarea[icon]').val());
			});
		}
	}
})
.on('click','code.icon .fontawesome a[data-content]',function(){
	icon = $(this).parents('code.icon');
	val = $(this).data('content');
	iconfunc.value(icon, val);
	if(icon.hasClass('active')){
		icon.removeClass('active');
	}
});



/* 多项目控件 */
projectfunc = {
	serial: function(project){
		textarea = project.children('textarea');
		project.find('*[name^="'+textarea.attr('name')+'["]').each(function(){
			prjname = $(this).attr('name').replace(/\[\d+(\]\[\w+\])/g,'[{key}$1');
			mat = prjname.match(/\{key\}/g);
			len = mat.length;
			for(i=len; i>=1; i--){
				fun = 'function prjkeyfun(obj){return obj';
				for(j=1; j<=i; j++){
					fun += ".parents('div.init')";
				}
				fun += '.index()-1;}';
				eval(fun);
				prjname = prjname.replace('{key}',prjkeyfun($(this)));
			}
			$(this).attr('name',prjname);
		});
		if(item = textarea.attr('item')){
			textarea.siblings('div.init').each(function(i){
				$(this).children('dfn').html(String(item).replace('[item]',i+1))
			});
		}
	},
	val: function(project){
		this.serial(project);
		textarea = project.children('textarea');
		prjing = '|';
		prjson = [];
		project.find('*[name^="'+textarea.attr('name')+'["]').each(function(){
			prjname = $(this).attr('name');
			if(prjing.indexOf('|'+prjname+'|') == -1){
				prjing += prjname+'|';
				type = $(this).attr('type');
				if(type == 'radio'){
					val = '';
					project.find('input[type=radio][name="'+prjname+'"]').each(function(){
						if($(this).prop('checked')){
							val = $(this).val();
							return true;
						}
					});
				}else if(type == 'checkbox'){
					val = [];
					project.find('input[type=checkbox][name="'+prjname+'"]').each(function(){
						if($(this).prop('checked')){
							val.push($(this).val());
						}
					});
				}else{
					val = $(this).val();
					if($(this)[0].hasAttribute('images') || $(this)[0].hasAttribute('param') || $(this)[0].hasAttribute('params') || $(this)[0].hasAttribute('multiple')){
						val = val?JSON.parse(val):[];
					}
				}
				mat = prjname.match(/\w+/g);
				len = mat.length-1;
				fun = 'function prjfunc(json, mat, val){';
				for(i=1; i<=len-1; i++){
					fun += 'if(!json';
					for(j=1; j<=i; j++) 
					fun += '[mat['+j+']]';
					fun += '){json';
					for(j=1; j<=i; j++) 
					fun += '[mat['+j+']]';
					fun += '='+(i%2?'{}':'[]')+';}';
				}
				fun += 'json';
				for(i=1; i<=len; i++) 
				fun += '[mat['+i+']]';
				fun += '=val;';
				fun += 'return json;}';
				eval(fun);
				prjson = prjfunc(prjson, mat, val);
			}
		});
		prjson = JSON.stringify(prjson);
		textarea.html(prjson).val(prjson).change();
	}
}
var prjX = prjY = prjMove = 0;
var prjCon = prjThe = prjHtml = prjNew = '';
$(document)
.mousemove(function(e){
	prjX = e.pageX;
	prjY = e.pageY;
	if(prjMove === 1){
		window.getSelection?window.getSelection().removeAllRanges():document.selection.empty();
		prjMove = 2;
		prjThe.addClass('move');
		uX = prjThe.offset().left;
		uY = prjThe.offset().top;
		prjHtml = prjThe[0].outerHTML;
		$('body').append('<div id="prjNew"><code class="project" style="width:'+prjThe.outerWidth()+'px;">'+prjHtml+'</code></div>');
		prjNew = $('#prjNew');
		prjNew
		.css('left',prjX)
		.css('top',prjY)
		.css('margin-left',-Math.abs(prjX-uX))
		.css('margin-top',-Math.abs(prjY-uY));
		prjNew.find('.divide').remove();
	}else if(prjMove === 2){
		window.getSelection?window.getSelection().removeAllRanges():document.selection.empty();
		prjNew.show()
		.css('left',prjX-$(window).scrollLeft())
		.css('top',prjY-$(window).scrollTop());
		prjList = prjCon.children('div.init')
		if(prjList.length > 1){
			prjList.each(function(){
				the = $(this);
				l = $(this).offset().left;
				r = l+375;
				h = $(this).outerHeight();
				if(the.prev('div.init').hasClass('move')){
					b = h/2>188?188:h/2;
					t = $(this).offset().top+b;
					b = t+b;
					z = 1;
				}else if(the.next('div.init').hasClass('move')){
					t = $(this).offset().top;
					b = t+(h/2>188?h-188:h/2);
					z = 2;
				}else{
					t = $(this).offset().top;
					b = t+h;
					z = 3;
				}
				if(prjY>t && prjY<b && prjX>l && prjX<r && !the.hasClass('move')){
					prjCon.find('div.init.move').remove();
					if(z == 1){
						the.after(prjHtml);
					}else{
						the.before(prjHtml);
					}
				}
			});
		}
		
	}
})
.mouseup(function(){
	if(prjMove === 2){
		prjNew.remove();
		dMove = prjCon.find('div.init.move');
		dMove.removeClass('move');
		projectfunc.val(dMove.parents('code.project.best'));
	}
	if(prjMove){
		prjMove = 0;
		return false;
	}
})
.on('mousedown','code.project>div.init>dfn',function(e){
	if(e.which == 1){
		prjMove = 1;
		prjThe = $(this).parent('div.init');
		prjCon = prjThe.parent('code.project');
	}
})
.on('click','code.project>a.add',function(){
	best = $(this).parents('code.project.best');
	max = best.children('textarea').attr('max');
	if(!max || ($(this).siblings('div').length<max)){
		$(this).before(decodeURIComponent($(this).attr('data')));
		$(this).siblings('div').each(function(){
			if(!$(this).hasClass('init')){
				initcode($(this));
				$(this).addClass('init');
			}
		});
		projectfunc.val(best);
	}else{
		_alert('最多可添加'+max+'个项目','red');
	}
})
.on('click','code.project>div>del',function(){
	project = $(this).parents('code.project.best');
	$(this).parent('div').remove();
	projectfunc.val(project);
});
changecode($(document), 'code.project.best ', function(obj){
	project = obj.parents('code.project.best');
	projectfunc.val(project);
});




/* 表格拖动 */
$(document).ready(function(e) {
	var moveDown = false;
	$(document)
	.on('mousedown','.main.table tr td a.move',function(){
		tr = $(this).parents('tr');
		tr.addClass('down')
		.mouseout(function(){
			if($(this).hasClass('down')){
				$(this)
				.addClass('on')
				.parents('table').addClass('move');
				moveDown = true;
			}
		})
	})
	.on('mousemove','.main.table table.move tr:not(:first-child)',function(e){
		$(this).removeClass('top');
		if(e.offsetY < 57/2){
			$(this).addClass('top');
		}
		window.getSelection?window.getSelection().removeAllRanges():document.selection.empty();
	})
	.on('mouseout','.main.table table.move tr:not(:first-child)',function(){
		if(!$(this).hasClass('on')){
			$(this).removeClass('top');
		}
	})
	.on('mouseup','.main.table table.move tr',function(){
		if(!$(this).hasClass('on')){
			table = $(this).parents('table');
			tr = table.find('tr.on');
			if(tr.length>0){
				html = tr[0].outerHTML;
				tr.remove();
				if($(this).hasClass('top')){
					$(this).before(html);
					$(this).removeClass('top');
				}else{
					$(this).after(html);
				}
				table.removeClass('move');
				table.find('tr').removeClass('on down top');
				table.find('input[name="id[]"]').prop('checked',true).parent('label.checkbox').change();
				table.find('tr td a.move input[name^="sort"]').each(function(){
					$(this).val($(this).parents('tr').index());
				});
			}
			moveDown = false;
		}
	})
	.mouseup(function(){
		if(moveDown){
			$('.main.table table.move tr').removeClass('on down top');
			$('.main.table table.move').removeClass('move');
			moveDown = false;
		}
	})
});



/* 树状图操作 */
function tree_init(obj){
	obj.find('*[level]').each(function(index, element) {
		l = $(this).attr('level')*1;
		lv = $(this).find('*[lv]');
		if($(this).next('*[level="'+(l+1)+'"]').length>0){
			lv.addClass('check').prepend('<em class="fa fa-minus-square-o" title="点击查看/收起子栏"></em>');
		}else{
			lv.prepend('<em class="fa fa-file-o"></em>');
		}
		b = ' b';
		$(this).nextAll('*[level]').each(function(){
			tl = $(this).attr('level')*1;
			if(tl == l){ 
				b = '';
			}else if(tl < l){
				return false;
			}
		});
		v = true;
		for(i=1; i<=l; i++){
			s = ' s';
			g = l-i+2;
			$(this).nextAll('*[level]').each(function(){
				tl = $(this).attr('level')*1;
				if(tl == g){ 
					s = '';
				}else if(tl < g){
					return false;
				}
			});
			if(i>1){
				lv.prepend('<i '+g+' class="l'+(v?' v'+b:''+s)+'"></i>');
				v = false;
			}
		}
	});
	obj.each(function(){
		if($(this).hasClass('off')){
			$(this).find('*[level="1"] *[lv] em.fa-minus-square-o').click();
		}
		if(cok = $(this).attr('cookie')){
			if(tlis = $.getCookie(cok)){
				tls = tlis.split(',');
				for(ti in tls){
					$(this).find('*[level][it='+tls[ti]+'] *[lv].check').addClass('temp').click();
				}
			}
		}
		if($(this).find('*[level] *[lv].check em.fa-minus-square-o:not(.on)').length==0 && (ctree=$(this).attr('tree'))){
			$('.treecheck[tree='+ctree+']').addClass('on');
		}
	});
}
$(document).on('click','section.tree *[level] *[lv].check',function(){
	tree = $(this).parents('section.tree');
	cok = false;
	if($(this).hasClass('temp')){
		$(this).removeClass('temp');
	}else{
		if(cok = tree.attr('cookie')){
			tli = $.getCookie(cok);
			it = $(this).parent('*[level]').attr('it');
		}
	}
	em = $(this).find('em.fa-minus-square-o');
	if(em.length>0){
		tr = $(this).parents('*[level]');
		l = tr.attr('level')*1;
		if(em.hasClass('on')){
			em.removeClass('on');
			tr.nextAll('*[level]').each(function(){
				tl = $(this).attr('level')*1;
				if(tl == l){ 
					return false;
				}else if(tl == l+1){ 
					$(this).show();
				}
			});
			if(cok && tli){
				$.setCookie(cok, (','+tli+',').replace(','+it+',',',').replace(/^,/,'').replace(/,$/,''));
			}
			$('.treecheck[tree='+tree.attr('tree')+']').removeClass('on');
		}else{
			em.addClass('on');
			tr.nextAll('*[level]').each(function(){
				tl = $(this).attr('level')*1;
				if(tl > l){
					$(this).hide();
				}else if(tl <= l){
					return false;
				}
				$(this).find('em.fa-minus-square-o').addClass('on');
			});
			if(cok){
				$.setCookie(cok, tli?((','+tli+',').indexOf(','+it+',')>=0?tli:(tli+','+it)):it);
			}
			if(tree.find('*[level] *[lv].check em.fa-minus-square-o:not(.on)').length==0 && (ctree=tree.attr('tree'))){
				$('.treecheck[tree='+tree.attr('tree')+']').addClass('on');
			}
		}
	}
}).on('click','section.tree *[level] input[type="checkbox"]:not([name])',function(){
	checked = $(this).prop('checked');
	tr = $(this).parents('*[level]');
	l = tr.attr('level')*1;
	tr.nextAll('*[level]').each(function(){
		tl = $(this).attr('level')*1;
		if(tl > l){
			$(this).find('input[type="checkbox"]').each(function(){
				if(checked){
					$(this).prop('checked',true).parent('label.checkbox').addClass('checked');
				}else{
					$(this).prop('checked',false).parent('label.checkbox').removeClass('checked');
				}
			});
		}else if(tl <= l){
			return false;
		}
	});
}).on('click','.treecheck',function(){
	tree = $(this).attr('tree');
	if($(this).hasClass('on')){
		$(this).removeClass('on');
		$('section.tree[tree='+tree+'] *[level] *[lv] em.fa-minus-square-o').each(function() {
			if($(this).hasClass('on')){
				$(this).click();
			}
		});
	}else{
		$(this).addClass('on');
		$('section.tree[tree='+tree+'] *[level] *[lv] em.fa-minus-square-o').each(function() {
			if(!$(this).hasClass('on')){
				$(this).click();
			}
		});
	}
});
tree_init($('section.tree'));

/* 页面滚动到 */
if($G['mold'] && $('header.topnav', window.parent.document).length>0){
	if(iframeScroll=$.getCookie('iframeScroll')){
		iSo = iframeScroll.split('~~~');
		if(iSo[1] == window.location.search){
			if(iSo[0].match(/^\d+$/)){
				$(window).scrollTop(iSo[0]);
			}
		}else{
			$.setCookie('iframeScroll','')
		}
	}
}



/* 公共操作 */
$(document).ready(function(e) {
	if(window.parent.window != window){
		category = $('section.category div.nav', window.parent.document);
		if(category.length>0 && !$('section.easy',window.parent.document).hasClass('active')){
			$('header.topnav>.column>ul>li', window.parent.document).removeClass('on');
			category.find('ul,li').removeClass('on');
			
			li = category.find('li.'+$G['mold']+'_'+$G['part']);
			if(li.length == 0){
				li = category.find('li.'+$G['mold']);
			}
			if(li.length == 0){
				li = category.find('li.'+$G['part']);
			}
			
			$('header.topnav>.column>ul>li.nav'+
				 li.addClass('on')
				.parent('ul').parent('li').addClass('on')
				.parent('ul').addClass('on')
				.attr('nav'),
			window.parent.document).addClass('on')
			
			para = '';
			sear = window.location.search;
			sear = sear.substring(1, sear.length);
			if(sear){
				se = sear.split('&');
				slen = se.length;
				for(i=0; i<slen; i++){
					if(se[i]){
						x = se[i].split('=');
						if(x[0] && 
						  x[0]!='mold' && 
						  x[0]!='part' && 
						  x[0]!='func' && 
						  x[0]!='success' && 
						  !(x[0]=='lang' && x[1]==$G['lang'])){
							para += '/'+x[0].replace(/\,/g,'%2C')+','+decodeURI(x[1]);
						}
					}
				}
			}
			
			url = '#mpf='+$G['mold']+($G['mold']!=$G['part']||$G['func']!='init'?'/'+$G['part']:'')+($G['func']!='init'?('/'+$G['func']):'')+para;
			if(has = window.parent.location.hash.match(/#mpf=\w+(\/(?:\w|%2C)+(,[^\/#]*){0,1})*/)){
				window.parent.location.hash = window.parent.location.hash.replace(has[0], url);
			}else{
				window.parent.location.hash = window.parent.location.hash + url;
			}
			$(window).scroll(function(){
				$.setCookie('iframeScroll', $(this).scrollTop()+'~~~'+window.location.search);
			});
		}
	}
	
	$('section.main.tab').each(function(Tindex, Telement) {
		main = $(this);
        aside = main.children('aside');
		if(aside.length>0){
			html = '';
			aside.each(function(index, element) {
                h2 = $(this).children('div').children('h2');
				html += h2.html();
				h2.remove();
				if(index){
					html = html.replace('<strong','<strong class="on"');
					$(this).attr('hide','hide');
				}
            });
			main.prepend('<h2 class="tab">'+html+'</h2>');
		}
		main.find('h2.tab strong').click(function() {
			if(!$(this).hasClass('on')){
				main.find('h2.tab strong').removeClass('on');
				$(this).addClass('on');
				main.children('aside').attr('hide','hide').eq($(this).index()).removeAttr('hide');
				$.setCookie('iframeMainTab', Tindex+','+$(this).index()+'~~~'+window.location.search);
				$(window).scroll();
			}
		});
    });
	
	if($G['mold'] && (iframeMainTab=$.getCookie('iframeMainTab'))){
		iMT = iframeMainTab.split('~~~');
		if(iMT[1] == window.location.search){
			if(iMT[0].match(/^\d+\,\d+$/)){
				Mt = iMT[0].split(',');
				$('section.main.tab').eq(Mt[0]).find('h2.tab strong').eq(Mt[1]).click();
			}
		}else{
			$.setCookie('iframeMainTab','')
		}
	}
	
	
	
    $(document)
	/* 表格单独删除按钮 */
	.on('click','.main.table .delete[url]',function(){
		if(confirm('确定删除吗？')){
			$.postForm($(this).attr('url'),{'url':window.location.href});
		}
	})
	/* 表格中的文本框输入内容后直接写入value中 */
	.on('change','.main.table input[type=text]',function(){
		if($(this).attr('name').match(/^sort\d+$/) && $(this).val()==''){
			$(this).attr('value', 0).val(0);
		}else{
			$(this).attr('value', $(this).val());
		}
	})
	.on('input propertychange','code.input>input[name], code.textarea>textarea[name]',function(){
		$(this).attr('value', $(this).val());
	})
	/* 表格选中项删除按钮 */
	.on('click','.delcheck[url]',function(){
		var list = $('[name="id[]"]:checked');
		if(list.length==0){
			_alert('没有选中项');
		}else if(
			confirm('确定删除选中项吗？')){
			var id = '';
			list.each(function(i,e){
				id += (i>0?',':'')+$(this).val();
			});
			$.postForm($(this).attr('url')+'&id='+id,{'url':window.location.href});
		}
	})
	/* 表格选中项触发添加id */
	.on('mousedown','.clickcheck[url]',function(){
		$(this).removeAttr('noeasy');
		var list = $('[name="id[]"]:checked');
		var copys = $('[name="copys"]').val();
		if(list.length==0){
			$(this).attr('url',$.params($(this).attr('url'),'id',null));
			_alert('没有选中项');
			$(this).attr('noeasy','noeasy');
		}else{
			var id = '';
			list.each(function(i,e){
				id += (i>0?',':'')+$(this).val();
			});
			$(this).attr('url',$.params($(this).attr('url'),'id',id));
		}
	})
	/* 表格删除一行tr */
	.on('click','.main.table .deltr',function(){
		$(this).parents('tr').remove();
	})
	/* 表格修改数据触发选中改行id */
	.on('change','.main.table input:not([name="id[]"]), .main.table textarea, .main.table select',function(){
		$(this).parents('tr').find('input[name="id[]"]').prop('checked',true).parent('label.checkbox').change();
	})
	/* 表格左上角全选按钮 */
	.on('click','.main.table th:eq(0) input[type="checkbox"]',function(){
		checked = $(this).prop('checked');
		$(this).parents('.main.table').find('input[name="id[]"]').each(function(){
			if(checked){
            	$(this).prop('checked',true).parent('label.checkbox').addClass('checked');
			}else{
            	$(this).prop('checked',false).parent('label.checkbox').removeClass('checked');
			}
        });
	})
	/* 打开漂浮窗口控件 */
	.on('click','a.button[fixed]',function(){
		if($(this).attr('checked') && $('[name="id[]"]:checked').length==0){
			_alert('请先选中项目');
		}else{
			$('.main.fixed.'+$(this).attr('fixed')).addClass('active');
		}
	})
	/* 关闭漂浮窗口控件 */
	.on('click','.main.fixed a.close',function(){
		$(this).parents('.main.fixed').removeClass('active');
	})
	/* 验证图片点击更新 */
	.on('click','img[captcha]',function(){
		src = $(this).attr('captcha');
		if(!src){
			src = $(this).attr('src');
			$(this).attr('captcha', src);
		}
		$(this).attr('src', $.srcRand(src));
	})
	/* 区块多系列控件打开隐藏 */
	.on('click','div.ctrl>h3',function(){
		ctrl = $(this).parent('div.ctrl');
		if(ctrl.hasClass('on')){
			ctrl.removeClass('on');
		}else{
			ctrl.siblings('div.ctrl').removeClass('on');
			ctrl.addClass('on');
		}
	})
	/* 多控件切换 */
	.on('click','div.cutover>ol>li',function(){
		if(!$(this).hasClass('on')){
			$(this).siblings('li').removeClass('on');
			$(this).addClass('on');
			$(this).parent('ol').next('ul').children('li').removeClass('on').eq($(this).index()).addClass('on');
		}
	})
	.on('click','code.complex a.complexCheck',function(){
		complex = $(this).parent('ins').parent('code.complex');
		$.get($(this).attr('url'),function(data){
			div = complex.children('div');
			div.html(data);
			initcode(div);
		});
	})	
	/* 关闭功能提示区 */
	.on('click','section.main aside div>article>b',function(){
		$(this).parent('article').remove();
	})
	.on('click','section.caring em',function(){
		$(this).parent('section.caring').removeClass('active');
	})
	/* 触发多参数控件 */
	$('code.complex a.complexCheck').click();
	/* 图片移动到展示大图的准备html排版 */
	$('img[check]').each(function(){
		img = $(this)[0].outerHTML;
		src = $(this).attr('src');
		html = '<div class="img check"><a href="'+src+'" target="_blank">'+img+'</a><section>'+img+'</section></div>';
		$(this).after(html).remove();
	});
	
	$('.head .search a.button').click(function(){
		url = window.location.href;
		searchs = $(this).parent('.search');
		keyword = searchs.find('input[name="keyword"]').val();
		if(keyword != ''){
			url = $.params(url, 'keyword', keyword);
			window.location.href = url;
		}else{
			_alert('请输入搜索信息，再点击查询');
		}
	});
	/* 图片标签带有rand属性路径加随机数 */
	$('img[rand]').each(function(){
		$(this).attr('src',$.srcRand($(this).attr('src')));
	});
	/* 单选控件选中同级移除选择 */
	$(document).on('change','code.radio label.radio',function(){
		$(this).addClass('checked').siblings().removeClass('checked');
	});
	/* 多选控件选中判断选择 */
	$(document).on('change','code.checkbox label.checkbox',function(){
		checkbox = $(this).find('input');
		if(checkbox.is(':checked')){
			$(this).addClass('checked');
			checkbox.attr('checked','checked');
		}else{
			$(this).removeClass('checked');
			checkbox.removeAttr('checked');
		}
	});
	/* 单选控件和多选控件修改颜色选项 */ 
	$('code.radio label.radio, code.checkbox label.checkbox').each(function(index, element) {
		ins = $(this).find('ins').html();
		reg = /^rgb[a]*\(\d/i;
		if(reg.test(ins)){
			$(this).find('ins').html('<span style="background-color:'+ins+'"></span>');
		}
	});
	
	/* 窗口载入单多选控件选中判断选择 */
	$(window).load(function(){
		$('code.radio label.radio').each(function(){
			if($(this).find('input').is(':checked')){
				$(this).addClass('checked').siblings().removeClass('checked');
			}
		});
		$('code.checkbox label.checkbox').each(function(){
			if($(this).find('input').is(':checked')){
				$(this).addClass('checked');
				$(this).find('input').removeAttr('required');
			}else{
				$(this).removeClass('checked');
			}
		});
		if( $(window).height() - (window.innerHeight +  $(window).scrollTop()) < 64 ){
			$('body').removeClass('refer');
		}else{
			$('body').addClass('refer');
		}
	}).scroll(function(){
		if( $(window).height() - (window.innerHeight +  $(window).scrollTop()) < 64 ){
			$('body').removeClass('refer');
		}else{
			$('body').addClass('refer');
		}
	});
});
/* 操作弹窗窗口 */
$(document).ready(function(e) {
	var easy = '',
		div = '',
		bool = false,
		offsetX = 0,
		offsetY = 0;
		esetW = 0;
		esetH = 0;
	
	$(document).on('mousedown','section.easy div.window div.move',function(e){
		easy = $(this).parents('section.easy');
		div = easy.children('div.window');
		easy.addClass('mouse');
		bool = true;
		offsetX = event.offsetX;  
		offsetY = event.offsetY;
		esetW = easy.width()-$(this).width();
		esetH = easy.height()-38;
	});
		
	var peasy = $('section.easy>div.window>div.icon>span.close', window.parent.document);
	if(peasy.length>0 && window.location.href.indexOf('success=')>0){
		peasy.addClass('ok').click();
	}
	$('a[easy-close]').click(function(){
		peasy.click();
	});
	
	$(document).mousemove(function(e){
		if(bool){
			window.getSelection?window.getSelection().removeAllRanges():document.selection.empty();
			eX = e.clientX-offsetX;
			eY = e.clientY-offsetY;
			if(eX < 0){
				eX = 0;
			}else if(eX > esetW){
				eX = esetW;
			}
			if(eY < 0){
				eY = 0;
			}else if(eY > esetH){
				eY = esetH;
			}
			div.css("left", eX);
			div.css("top", eY);
		}
	}).mouseup(function(){
		if(bool){
			easy.removeClass('mouse');
			bool = false;
		}
	}).on('click','section.easy>div.window>div.icon>span.full',function(){
		if($(this).hasClass('on')){
			$(this).removeClass('on');
			$(this).parents('section.easy').removeClass('full');
			wi = $(this).parents('section.easy').children('.window');
			wi.css('left',($('section.easy',win.document).width()-wi.outerWidth())/2)
			  .css('top',($('section.easy',win.document).height()-wi.outerHeight())/2);
		}else{
			$(this).addClass('on');
			$(this).parents('section.easy').addClass('full');
		}
		$(this).parents('section.easy').find('iframe').contents().find('section.easy.active').each(function(){
			cwin = $(this).find('div.window')
			cl = Math.ceil($(this).width()-cwin.width())/2;
			ct = Math.ceil($(this).height()-cwin.height())/2;
			cwin.css('left',cl>0?cl:0).css('top',ct>0?ct:0);
		});
	}).on('click','section.easy>div.window>div.icon>span.close',function(){
		if($(this).hasClass('ok')){
			$('body').addClass('success');
			$(this).removeClass('ok').click();
			window.setTimeout(function(){
				window.location.reload();
			},1500);
		}else{
			if($(this).hasClass('on') && $(this).prev('span.full').length>0){
				$(this).parents('section.easy').removeClass('active').addClass('full').children('.window').removeAttr('style').find('.icon>span').addClass('on');
			}else{
				$(this).parents('section.easy').removeClass('full active').children('.window').removeAttr('style').find('.icon>span.full').removeClass('on');
			}
		}
	}).on('click','a[easy][url]',function(){
		the = $(this);
		if(!the.attr('noeasy')){
			win = window;
			if(the.attr('win')=='top'){
				win = window.top;
			}else if(the.attr('win')=='parent'){
				win = window.parent;
			}else if(the.attr('win')=='parent2'){
				win = window.parent.parent;
			}else if(the.attr('win')=='parent3'){
				win = window.parent.parent.parent;
			}
			if(the.attr('easy')=='full'){
				$('body>section.easy>div.window>div.icon>span.full',win.document).addClass('on').parents('section.easy').addClass('full');
			}
			if(the.attr('easy')=='nofull'){
				$('body>section.easy>div.window>div.icon>span.full',win.document).removeClass('on').parents('section.easy').removeClass('full');
				$('body>section.easy>div.window>div.icon>span.full',win.document).remove();
			}
			$("body>section.easy",win.document).addClass('active').find('iframe').attr('src',the.attr('url'));
			$('body>section.easy>div.window',win.document).each(function(){
				if(eywidth=the.attr('width')){
					$('body>section.easy>div.window',win.document).width(eywidth.match(/^\d+\%$/)?eywidth.replace('%','')/100*$('body>section.easy',win.document).width():eywidth);
				}
				if(eyheight=the.attr('height')){
					$('body>section.easy>div.window',win.document).height(eyheight.match(/^\d+\%$/)?eyheight.replace('%','')/100*$('body>section.easy',win.document).height():eyheight);
				}
				if(eyname=the.attr('name')){
					$('body>section.easy>div.window>div.move',win.document).html(eyname);
				}else{
					$('body>section.easy>div.window>div.move',win.document).text(the.text());
				}
				$(this)
					.css('left',($('body>section.easy',win.document).width()-$(this).outerWidth())/2)
					.css('top',($('body>section.easy',win.document).height()-$(this).outerHeight())/2);
			});
		}
	});
});
/* 操作弹窗窗口 */
$(document).ready(function(e) {
	var setup = box = $('<div></div>'),
		bool = false,
		offsetX = 0,
		offsetY = 0;
	$(document).on('mousedown','section.setup>div.box>div.move',function(e){
		setup = $(this).parents('section.setup');
		box = setup.addClass('mouse').children('div.box');
		bool = true;  
		offsetX = event.offsetX;  
		offsetY = event.offsetY;
	});
	$(document).mousemove(function(e){
		if(bool){
			window.getSelection?window.getSelection().removeAllRanges():document.selection.empty();
			box.css("left",e.clientX-offsetX).css("top",e.clientY-offsetY);
		}
	}).mouseup(function(){
		if(bool){
			setup.removeClass('mouse');
			bool = false;
		}
	}).on('click','section.setup>div.box>div.close',function(){
		$(this).parents('section.setup').removeClass('active');
	}).on('click','a[setup]',function(){
		$(this).next('section.setup').addClass('active').find('.box').each(function(index, element) {
			if(!$(this).attr('style')){
				$(this)
				  .css('left',($('section.setup').width()-$(this).outerWidth())/2)
				  .css('top',($('section.setup').height()-$(this).outerHeight())/2);
			}
        });
	});
	
	if($('section.navsub').length>0){
		$('section.navsub').scroll(function(){
			$.setCookie('iframeContentTreeScroll', $(this).scrollTop());
		});
		$('section.navsub').scrollTop( $.getCookie('iframeContentTreeScroll') );
	}
	
	/* 打开界面自动执行事件 */
	$('a[auto]').each(function(index, element) {
        if(ao = $(this).attr('auto')){
			this[ao]();
		}
    });
});


function _alert(str, type){
	var date = new Date();
	now = date.getTime();
	win = window.top.document;
	$(win).find('body').append('<h6 class="alert '+type+'" time="'+now+'" style="z-index:'+now+';"><b>'+str+'</b></h6>');
	tha = $(win).find('h6.alert[time="'+now+'"]');
	tha.animate({top:78,opacity:1},288);
	window.top.realt(tha);
}

function realt(tha){
	window.setTimeout(function(){
		tha.remove();
	},
	tha.hasClass('green')?3000:2000);
}

function easyhtml(html, name, width, height, left, top, full){
	width = width>0?width+'px':width;
	height = height>0?height+'px':height;
	left = left>0?left+'px':left;
	top = top>0?top+'px':top;
	return '<section class="easy active">'+
	  '<div class="window" style="width:'+width+';height:'+height+';left:'+left+';top:'+top+';">'+
		'<div class="icon">'+
		  (full?
		  '<span class="full">'+
			'<em class="fa fa-expand"></em>'+
			'<em class="fa fa-compress"></em>'+
		  '</span>':'')+
		  '<span class="close">'+
			'<em class="fa fa-times"></em>'+
		  '</span>'+
		'</div>'+
		'<div class="move">'+name+'</div>'+
		html+
	  '</div>'+
	'</section>';
}

/* 初始化功能汇总事件 */
function initcode(obj){
	textarea_func(obj[0]);
	ueditor_init(obj[0]);
	upfile_init(obj.find('code.upfile'));
	color_init(obj.find('code.color'));
	icon_init(obj.find('code.icon'));
	toggle_init(obj.find('code.toggle'));
	param_init(obj.find('code.param'));
	select_init(obj.find('code.select'));
	radio_init(obj.find('code.radio'));
	seekbar_init(obj.find('code.seekbar'));
	linkage_init(obj.find('code.linkage'));
}

/* 控件内容触发汇总事件 */
function changecode(obj, doc, func){
	obj
	.on('input propertychange', 
	  doc+'code.input>input[name],'+
	  doc+'code.textarea>textarea[name]',function(){
		func($(this), $(this).attr('name'), $(this).val());
	})
	.on('change', 
	  doc+'code.upfile:not([upfile="images"])>textarea[name],'+
	  doc+'code.ueditor>textarea[name],'+
	  doc+'code.select>textarea[name],'+
	  doc+'code.color>textarea[name],'+
	  doc+'code.icon>textarea[name],'+
	  doc+'code.toggle>textarea[name],'+
	  doc+'code.seekbar>textarea[name],'+
	  doc+'code.radio>textarea[name],'+
	  doc+'code.linkage>textarea[name],'+
	  doc+'code.radio>label>input[name]',function(){
		func($(this), $(this).attr('name'), $(this).val());
	})
	.on('change', 
	  doc+'code.upfile[upfile="images"]>textarea[name],'+
	  doc+'code.param>textarea[name],'+
	  doc+'code.params>textarea[name],'+
	  doc+'code.project>textarea[name]',function(){
		func($(this), $(this).attr('name'), $(this).val()?JSON.parse($(this).val()):[]);
	})
	.on('change', doc+'code.checkbox>label>input[name]',function(){
		name = $(this).attr('name');
		val = [];
		$('input[type="checkbox"][name="'+name+'"]').each(function(){
			if($(this).prop('checked')){
				val.push($(this).val());
			}
		});
		func($(this), name.replace(/\[\]$/,''), val);
	});
	
}
/* 公用html */
var sethtml = {
	pages: function(data){
		psurl = window.location.href;
		pshtm = '<li><a href="'+$.params(psurl,'pages',data.first.number>1?data.first.number:null)+'"><i class="fa fa-angle-double-left"></i></a></li>';
        pshtm += '<li><a href="'+$.params(psurl,'pages',data.prev.number>1?data.prev.number:null)+'"><i class="fa fa-angle-left"></i></a></li>';
		for(i in data.list){
			v = data.list[i];
			pshtm += '<li><a href="'+$.params(psurl,'pages',v.number>1?v.number:null)+'" '+(v.current?' class="on"':'')+'>'+v.number+'</a></li>';
		}
        pshtm += '<li><a href="'+$.params(psurl,'pages',data.next.number>1?data.next.number:null)+'"><i class="fa fa-angle-right"></i></a></li>';
        pshtm += '<li><a href="'+$.params(psurl,'pages',data.last.number>1?data.last.number:null)+'"><i class="fa fa-angle-double-right"></i></a></li>';
		return pshtm;
	},
	identity: function(data){
		idhtm = '<section class="identity">';
		if(data.money){
			idhtm += '<aside class="user">';
			idhtm += '  <b>官方账号：</b>';
			idhtm += '  <a href="https://www.bosscms.net/accounts/" target="_blank">'+(data.name?data.name:data.tel)+'</a>';
			idhtm += '  <b class="balance">余额：</b>';
			idhtm += '  <i class="fa fa-rmb money">'+data.money+'</i>';
			idhtm += '  <a href="'+$.mpf('template','market','logout')+'" title="退出登录">退出登录</a>';
			idhtm += '</aside>';
		}else{
			idhtm += '<aside class="login">';
			idhtm += '  <a easy="nofull" width="440" height="216" url="'+$.mpf('template','market','login')+'">';
			idhtm += '	<i class="fa fa-user-circle-o"></i>';
			idhtm += '	<b>登录官方账号</b>';
			idhtm += ' </a>';
			idhtm += '  <span></span>';
			idhtm += '  <a href="https://www.bosscms.net/login/register.php" target="_blank" title="注册会员">';
			idhtm += '	<i class="fa fa-address-book-o"></i>';
			idhtm += '	<b>注册会员</b>';
			idhtm += '  </a>';
			idhtm += '</aside>';
		}
		idhtm += '</section>';
		return idhtm;
	}
}