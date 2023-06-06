/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
$(document).ready(function(e) {
	$('.add.button').click(function(){
		$('.main table tbody tr').last().after( $('table[hidden] tbody').html().replace(/{Rep}/g,Math.ceil(Math.random()*100000)) );
	});
	$.get($.mpf('feedback','feedback','reading'),function(n){
		$('header.topnav .wrap a[news]',window.top.document).attr('news', n);
	});
});