$(document).ready(function(e) {
	$('address.consult-online>.list>h4').click(function(){
		if($('address.consult-online').hasClass('active')){
			$('address.consult-online').removeClass('active');
			document.cookie='consult001open=0;path=/';
		}else{
			$('address.consult-online').addClass('active');
			document.cookie='consult001open=1;path=/';
		}
	});
	$('address.consult-online li.top a').click(function(){
		$('html,body').animate({scrollTop:0}, 888);
		return false;
	});
	$('address.consult-online li.qq a').each(function(){
		qq = $(this).attr('qq');
		if(/(iPhone|iPad|iPod|iOS)/i.test(navigator.userAgent)){ 
			href = 'mqq://im/chat?chat_type=wpa&uin='+qq+'&version=1&src_type=web';
		}else if(/(Android)/i.test(navigator.userAgent)) { 
			href = 'mqqwpa://im/chat?chat_type=wpa&uin='+qq;
		}else{
			href = 'http://wpa.qq.com/msgrd?v=3&uin='+qq+'&site=qq&menu=yes';
		}
		$(this).attr('href',href);
	});
	$(window).scroll(function(){
		if($(this).scrollTop()>588){
			$('address.consult-online .list ul li.top').addClass('on');
		}else{
			$('address.consult-online .list ul li.top').removeClass('on');
		}
	});
	
});