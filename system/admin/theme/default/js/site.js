/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
$(document).ready(function(e) {
	if(domain = $('input[name=domain]').val()){
		$('a[domain]',window.top.document).attr('href',domain).attr('target','_blank');
	}else{
		$('a[domain]',window.top.document).attr('href',"javascript:_alert('未设置站点域名');").removeAttr('target');
	}
});