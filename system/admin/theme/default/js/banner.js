/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
$(document).ready(function(e){
	$('input[name=site]').change(function(){
		store();
	});
	store();
	function store(){
		val = $('input[name=site]:checked').val();
		if(val==1){
			$('dl[type]').hide();
			$('dl[items]').show();
		}else if(val==0){
			$('dl[type]').show();
			$('dl[items]').hide();
		}
	}
});