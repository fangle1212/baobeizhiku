/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
$(document).ready(function(e){
	ul = $('section.iframe', window.parent.document)
	if(ul.length){
		ul.find('li').removeClass('on');
		ul.find('li[items="'+$G['items']+'"]').addClass('on');
	}
});