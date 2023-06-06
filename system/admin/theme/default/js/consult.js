/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
$(document).ready(function(e){
	$('textarea[name=type]').change(function(){
		type($(this).val());
	});
	type($('textarea[name=type]').val());
	function type(val){
		$('dl[type]').hide();
		$('dl[type='+val+']').show();
	}
	
	bosscms = true;
	$('textarea[name=consult_theme]').change(function(){
		img($(this).val());
	});
	img($('textarea[name=consult_theme]').val());
	function img(val){
		$('textarea[name=consult_theme]').parents('dd').find('img').each(function(index, element) {
            $(this).attr('src', $(this).attr('url').replace('themes',val));
        });
	}
});