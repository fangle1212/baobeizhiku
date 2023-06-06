$(document).ready(function(e) {
	$('code.checkbox label.checkbox').change(function(){
		if($(this).find('input').is(':checked')){
			$(this).addClass('checked');
		}else{
			$(this).removeClass('checked');
		}
	});
	
	step = $('main.install section.step',window.parent.document);
	if(step.length > 0){
		li = step.find('li');
		li.removeClass('on');
		if($('section.license').length>0){
			li.eq(0).addClass('on');
		}else if($('section.check').length>0){
			li.eq(0).addClass('on');
			li.eq(1).addClass('on');
		}else if($('section.database').length>0){
			li.eq(0).addClass('on');
			li.eq(1).addClass('on');
			li.eq(2).addClass('on');
		}else if($('section.manager').length>0){
			li.eq(0).addClass('on');
			li.eq(1).addClass('on');
			li.eq(2).addClass('on');
			li.eq(3).addClass('on');
		}else if($('section.success').length>0){
			li.addClass('on');
		}
	}
	
	if($('section.license div.content').length>0){
		lctop = $('section.license div.content p').last().offset().top - 18;
		lcheight = $('section.license div.content').height();
		$('section.license div.content').scroll(function(){
			if($(this).scrollTop() >= lctop - lcheight){
				$('section.license div.next a').removeClass('nosee');
			}
		});
		$('section.license div.next code.checkbox label.checkbox').change(function(){
			if($('section.license div.next a').hasClass('nosee')){
				alert('请先阅读完用户协议再点击！');
				$(this).removeClass('checked');
				$(this).find('input').prop('checked',false);
			}else{
				if($(this).find('input').is(':checked')){
					$('section.license div.next a').each(function(){
						$(this).attr('href', $(this).attr('url'));
					});
				}else{
					$('section.license div.next a').removeAttr('href');
				}
			}
		});
		$('section.license div.next a').click(function(){
			if(!$(this).attr('href')){
				alert('请先同意用户协议再进入下一步！');
			}
		});
	}
	
	if($('section.check').length>0){
		if($('section.check em.fa-times').length==0){
			$('section.check div.both a.next').each(function(){
				$(this).attr('href', $(this).attr('url')).removeClass('not');
			});
			$('section.check div.both a.next').click(function(){
				if($(this).hasClass('down')){
					return false;
				}else{
					$(this).append('<em class="fa fa-spinner"></em>').addClass('down');
				}
			});
		}else{
			$('section.check div.both a[hide]').removeAttr('hide');
		}
	}

	$('section.database.main.form').parent('form').submit(function(){
		if($(this).hasClass('down')){
			return false;
		}else{
			$(this).addClass('down');
			$(this).find('button.button.green.next').append('<em class="fa fa-spinner"></em>');
		}
	});
});