/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
$(document).ready(function(e) {
    if(window.parent!=window){
		admin_folder = $.request('admin_folder');
    	if(admin_folder){
			window.parent.location.href='../'+admin_folder+'/';
		}
	}
	$('input[name="admin_captcha_type"]').change(function(){
		if($('input[name="admin_captcha_type"]:checked').val()==1){
			if(captchaappid = $('script[captchaappid]').attr('captchaappid')){
				try{
					TC = new TencentCaptcha(captchaappid, function(res){
						if(res.ret===0){
							$.post($.mpf('safe','safe','captcha',{jsonmsg:1}),{'admin_captcha_type':1,'randstr':res.randstr,'ticket':res.ticket},function(r){
								if(r.msg=='success'){
									$('input[name="admin_captcha_type"]').removeAttr('checked').parent('label').removeClass('checked');
									$('input[name="admin_captcha_type"][value="1"]').attr('checked','checked').parent('label').addClass('checked');
									_alert('图形验证启用成功','green');
								}else{
									_alert(r.msg);
								}
							},'json');
						}
					},{});
					TC.show(); 
				}catch(e){}
			}else{
				_alert('启用图形验证必须先配置接口');
			}
			window.setTimeout(function(){
				$('input[name="admin_captcha_type"]').removeAttr('checked').parent('label').removeClass('checked');
				$('input[name="admin_captcha_type"][value="0"]').attr('checked','checked').parent('label').addClass('checked');
			},200);
		}else{
			$.post($.mpf('safe','safe','captcha',{jsonmsg:1}),{'admin_captcha_type':0},function(r){
				if(r.state=='success'){
					_alert('修改成功','green');
				}else{
					_alert(r.msg);
				}
			},'json');
		}
	});
	$('.btnfa.green.import').click(function(){
		if(confirm('是否覆盖管理员账号密码')){
			window.location.href=$(this).attr('url')+'&cover=1';
		}else{
			window.location.href=$(this).attr('url')+'&cover=0';
		}
	});
});