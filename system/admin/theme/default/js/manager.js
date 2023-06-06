/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
$(document).ready(function(e){
	$('textarea[name=level]').change(function(){
		level($(this).val());
	});
	level($('textarea[name=level]').val());
	function level(val){
		$('dd[level]').hide();
		$('dd[level='+val+']').show();
	}
	$('a.button.selectall').click(function(){
		if($(this).hasClass('on')){
			$(this).removeClass('on');
			$('section.main.table table input[type=checkbox]').prop('checked',false).parent('label.checkbox').removeClass('checked');
		}else{
			$(this).addClass('on');
			$('section.main.table table input[type=checkbox]').prop('checked',true).parent('label.checkbox').addClass('checked');
		}
	});
	$('section.main.table table input[type=checkbox]').change(function(){
		if($('section.main.table table input[type=checkbox]:not(:checked)').length>0){
			$('a.button.selectall').removeClass('on');
		}else{
			$('a.button.selectall').addClass('on');
		}
	});
	$(window).load(function(){
		$('section.main.table table input[type=checkbox]').eq(0).change();
	});
});