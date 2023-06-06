/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
$(document).ready(function(e) {
	if(window.top.window != window){
		window.top.window.location.href = window.location.href;
	}
	if($('script[captchaappid]').length>0){
		loginform = $('section.login-box form');
		loginform.submit(function(){
			if(captchaappid = $('script[captchaappid]').attr('captchaappid')){
				if(!loginform.hasClass('rtstate')){
					try{
						TC = new TencentCaptcha(captchaappid, function(res){
							if(res.ret===0){
								loginform.find('input[name="randstr"]').val(res.randstr);
								loginform.find('input[name="ticket"]').val(res.ticket);
								loginform.addClass('rtstate').submit();
							}
						},{});
						TC.show(); 
					}catch(e){}
					return false;
				}	
			}else{
				_alert('图形验证未配置');
				return false;
			}
		});
	}
});