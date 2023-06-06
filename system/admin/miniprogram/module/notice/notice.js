$(window).load(function(){
	mw = new Swiper('.mob-notice-swiper:not(.swiper-container-vertical)',{
		wrapperClass: 'mob-notice-wrapper',
		slideClass: 'mob-notice-slide',
		direction: 'vertical',
		watchSlidesProgress: true,
		watchSlidesVisibility: true,
		observer: true,
		observeParents: true,
		slidesPerView: 1,
		simulateTouch: false,
		onInit: function(swiper){
			swiper.params.autoplay = swiper.container.attr('interval')*1;
			swiper.params.speed = swiper.container.attr('duration')*1;
			swiper.startAutoplay();
		}
	});
});