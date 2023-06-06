/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
$(document).ready(function(e) {
	var fix = $('section.fixed'),
		box = fix.children('div.box'),
		clearT = true,
		bool = false,
		offsetX = 0,
		offsetY = 0;
    box.children('span.close').click(function(){
		fix.removeClass('active');
	});
	box.children('span.move').mousedown(function(e){
		fix.addClass('mouse');
		bool = true;  
		offsetX = event.offsetX;  
		offsetY = event.offsetY;
	});
	$(document).mousemove(function(e){
		if(bool){
			window.getSelection?window.getSelection().removeAllRanges():document.selection.empty();
			box.css("left",e.clientX-offsetX).css("top",e.clientY-offsetY);
		}
	}).mouseup(function(){
		if(bool){
			fix.removeClass('mouse');
			bool = false;
		}
	});
	$('a[fixed]').click(function(){
		box.css('left',($(window).width()-box.outerWidth())/2);
		box.css('top',($(window).height()+50-box.outerHeight())/2);
		$("section.fixed").addClass('active');
	});
});