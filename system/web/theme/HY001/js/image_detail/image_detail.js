$(document).ready(function(e) {
if($('.imagedetail .images>.imgs>.img').length>1){
	if(1) $('.imagedetail .images>.imgs').after('<dl><dt></dt><dd></dd></dl>');
	new Swiper('.imagedetail .images',{
		wrapperClass: 'images>.imgs',
		slideClass: 'images>.imgs>.img',
		autoplay: 3.5 * 1000,
		loop: true,
		watchSlidesProgress: true,
		watchSlidesVisibility: true,
		observer: true,
		observeParents: true,
		slidesPerView: 1,
		simulateTouch: false,
		keyboardControl: true,
		bulletActiveClass: 'active',
		slideDuplicatedActiveClass: 'active',
		slideVisibleClass: 'visible',
		slideActiveClass: 'active',
		prevButton: '.imagedetail .images>dl>dt',
		nextButton: '.imagedetail .images>dl>dd'
	});
}
});