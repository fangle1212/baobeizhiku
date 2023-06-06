/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
$(document).ready(function(e) {
	$('.isdefault').click(function(){
		$.postForm($(this).data('url'), {'id': $(this).data('id'), 'default': 1});
	});
	$('.isdisplay').click(function(){
		$.postForm($(this).data('url'), {'id': $(this).data('id'), 'display': $(this).data('display')});
	});
});