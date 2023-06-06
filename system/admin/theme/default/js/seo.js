/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
$(document).ready(function(e) {
    $('section.main aside>div>dl>dd>a').click(function(){
		data = $(this).attr('data');
		$(this).next('code').find('input').attr('value',data).val(data).change();
	});
    $('section.main aside>div>dl>dd>code>input').change(function(){
		dl=$(this).parents('dl');
		if($(this).val()==dl.find('dd>a').attr('data')){
			dl.removeClass('on');
		}else{
			dl.addClass('on');
		}
	});
});