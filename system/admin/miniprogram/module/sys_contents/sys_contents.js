$(window).load(function(){
	if(!$('.mob-sys-contents').hasClass('click')){
		$('.mob-sys-contents>ul>li').click(function(){
			cts = $(this).parents('.mob-sys-contents');
			cts.find('ul>li').removeClass('on');
			$(this).addClass('on');
			cts.children('div').removeClass('on').eq($(this).index()).addClass('on');
		});
		$('.mob-sys-contents').addClass('click');
	}
});