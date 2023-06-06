/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
$(document).ready(function(e){
	$(document).on('change','code.param textarea[name=tag]',function(){
		$('code.tag ul li').removeClass('on');
		txtval = $(this).val();
		if(txtval){
			txtval = JSON.parse(txtval);
			for(i in txtval){
				$('code.tag ul li[value="'+txtval[i]+'"]').addClass('on');
			}
		}
	});
	$('code.tag div>a').click(function(){
		obj = {
			type: $.request('type')
		};
		$('code.tag>ul').remove();
		$.get($.mpf('tag','tag','select',obj),function(data){
			html='<ul>';
			data = JSON.parse(data);
			for(i in data){
				html+='<li value="'+$.quotesFilter(data[i].title)+'">'+data[i].title+'</li>';
			}
			html+='</ul>';
			$('code.tag').append(html);
			$('code.param textarea[name=tag]').change();
		});
	});
	$(document).on('click','code.tag ul li',function(){
		if(!$(this).hasClass('on')){
			param = $('textarea[name=tag]').parents('code.param');
			param.find('ins input').val($(this).attr('value'));
			param.find('ins i.fa-plus').click();
		}
	});
});