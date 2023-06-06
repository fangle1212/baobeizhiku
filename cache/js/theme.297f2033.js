var $G=[];
$G['lang']=1;
$G['relative']='../';
$G['items']=97;
$G['type']=3;
$G['id']=67
$(document).ready(function(){
	$('notice[type][id]').each(function(){
		bosscms = true;
		$.post(
			$G['relative']+'api/notice/?lang='+$G['lang'],
			{
				type: $(this).attr('type'),
				id: $(this).attr('id')
			},
			function(data){
				if(data){
					$('notice[type="'+data.type+'"][id="'+data.id+'"]').before(data.notice).remove();
				}
			},
			'json'
		);
	});
});


if($('.productdetail .images>ul>li').length>1){	
	$('.productdetail .images>ul').after('<ol></ol><dl><dt></dt><dd></dd></dl>');
	new Swiper('.productdetail .images',{
		wrapperClass: 'productdetail .images>ul',
		slideClass: 'productdetail .images>ul>li',
		autoplay: false,
		loop: false, 
		watchSlidesProgress: true,
		watchSlidesVisibility: true,
		observer: true,
		observeParents: true,
		slidesPerView: 'auto',
		simulateTouch: true,
		keyboardControl: true,
		pagination: '.productdetail .images>ol',
		paginationElement: 'li',
		paginationClickable: true,
		paginationClickableClass: 'image-',
		paginationModifierClass: 'image-',
		bulletClass: 'image-number',
		bulletActiveClass: 'active',
		containerModifierClass: 'image-',
		slideDuplicatedActiveClass: 'active',
		slideDuplicatedPrevClass: 'prev',
		slideDuplicatedNextClass: 'next',
		slideDuplicateClass: 'duplicate',
		slideVisibleClass: 'visible',
		slideActiveClass: 'active',
		slidePrevClass: 'prev',
		slideNextClass: 'next',
		prevButton: '.productdetail .images>dl>dt',
		nextButton: '.productdetail .images>dl>dd',
		onClick: function(swiper){
		}
	});
	$(document).on('mouseover','.productdetail .images>ul>li',function(){
		$('.productdetail .images>ul>li').removeClass('on');
		$(this).addClass('on');
		$('.productdetail .photo>span>a').attr('href', $(this).find('a').attr('href'));
		$('.productdetail .photo>span>a>img').attr('src', $(this).find('img').attr('src'));
	});
}

$('.productdetail .content>ul>li').click(function(){
	$('.productdetail .content>ul>li').removeClass('on');
	$(this).addClass('on');
	$('.productdetail .content>aside').removeClass('on').eq($(this).index()).addClass('on');
});