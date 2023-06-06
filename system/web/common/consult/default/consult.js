$(document).ready(function(e) {
	$('.consult-online li.top a').click(function(){
		$('html,body').animate({scrollTop:0}, 888);
		return false;
	});
	$('.consult-online li.qq a').each(function(){
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
			$('.consult-online .list ul li.top').addClass('on');
		}else{
			$('.consult-online .list ul li.top').removeClass('on');
		}
	});
});