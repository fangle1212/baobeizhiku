$(document).ready(function(e) {
	$('dd.level li[value*=",3"]').addClass('hide');
	selectfunc.val($('dd.level code.select'));
    $('input[name="level[]"]').change(function(){
		level = $(this).val();
		if($(this).prop("checked")){
            $('dd.level li[value*=",' + level + '"]').addClass('on').removeClass('hide');
		}else{
            $('dd.level li[value*=",' + level + '"]').each(function(index, element) {
				if(level!=2 || (level==2 && ($(this).attr('value').indexOf(',1,2')<0 || !$('input[name="level[]"][value="1"]').prop("checked")))){
                	$(this).removeClass('on').addClass('hide');
				}
            });
		}
		selectfunc.val($('dd.level code.select'));
	});
	$('input[name="area_link_type"]').click(function(){
		if($(this).val()==0){
			$('dl[area_link_type]').removeAttr('hide');
			$('dl[area_link_type1]').attr('hide','hide');
		}else{
			$('dl[area_link_type]').attr('hide','hide');
			$('dl[area_link_type1]').removeAttr('hide');
		}
	});
});