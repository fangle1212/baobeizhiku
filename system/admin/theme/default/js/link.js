/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
$(document).ready(function(e){
	$('input[name=type]').change(function(){
		type();
	});
	type();
	function type(){
		val = $('input[name=type]:checked').val();
		if(val==1){
			$('dl[image]').show();
		}else if(val==0){
			$('dl[image]').hide();
		}
	}
});