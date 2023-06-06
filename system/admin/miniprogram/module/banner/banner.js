$(window).load(function(){
	new Swiper('.mob-banner-swiper:not(.swiper-container-horizontal)',{
		wrapperClass: 'mob-banner-wrapper',
		slideClass: 'mob-banner-slide',
		watchSlidesProgress: true,
		watchSlidesVisibility: true,
		observer: true,
		observeParents: true,
		slidesPerView: 1,
		simulateTouch: false,
		keyboardControl: true,
		pagination: '.mob-banner-pagination',
		paginationBulletRender: function (swiper, index, className){
			pg = swiper.paginationContainer;
			return '<span class="'+className+'" style="background:'+pg.attr('indicator-color')+';">'+
				'<i style="background:'+pg.attr('indicator-active-color')+';"></i>'+
			'</span>';
		},
		bulletActiveClass: 'active',
		slideDuplicatedActiveClass: 'active',
		slideVisibleClass: 'visible',
		slideActiveClass: 'active',
		onInit: function(swiper){
			if(swiper.container.attr('autoplays')*1){
				swiper.params.autoplay = swiper.container.attr('interval')*1;
				swiper.params.speed = swiper.container.attr('duration')*1;
				swiper.startAutoplay();
			}
			if(!(swiper.paginationContainer.attr('indicator-dots')*1)){
				swiper.paginationContainer.hide();
			}
		}
	});
});