$(document).ready(function(e) {
	$('menu.mobile-menu .list ul li a.img').click(function(){
		if($(this).hasClass('on')){
			$(this).removeClass('on');
		}else{
			$(this).addClass('on');
		}
	});
});