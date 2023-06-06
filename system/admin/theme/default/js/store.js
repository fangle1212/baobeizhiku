/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
$(document).ready(function(e){
	$('input[name=store_type]').change(function(){
		store();
	});
	store();
	function store(){
		val = $('input[name=store_type]:checked').val();
		if(val==1){
			$('dl[platforms]').show();
			type($('textarea[name=store_platform]').val());
		}else{
			$('dl[platforms]').hide();
		}
	}
	$('textarea[name=store_platform]').change(function(){
		type($(this).val());
	});
	function type(val){
		bosscms = true;
		$('dl[platform]').hide();
		$('dl[platform='+val+']').show();
	}
});