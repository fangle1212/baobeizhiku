/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
$(document).ready(function(e) {
	obj = {host:window.location.href}
	if(oem = $('section.news .authorize').attr('oem')){
		obj.oem = oem;
	}
    $.post('https://api.bosscms.net/rest/authorize/face.php',obj,function(data){
		$('section.news .authorize').html(data.name);
	},'json');
	$.get($.mpf('home','home','develop'),function(data){
		$('section.news span.update>span').html(data.update);
		$('section.news span.qq>span').html(data.qq);
	},'json');	
	$('.caring.admin_folder').each(function(index, element) {
        $(this).addClass('active');
    });
});