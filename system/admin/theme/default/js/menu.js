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
});