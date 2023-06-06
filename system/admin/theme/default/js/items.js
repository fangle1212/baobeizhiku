/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
$(document).ready(function(e){
	id = $.request('id');
	parent = $.request('parent');
	function theme(){
		dls = $('dl[theme][type'+$('textarea[name=type]').val()+']').eq(0).find('textarea');
		folder = dls.attr('folder');
		if(folder){
			if(folder){
				getdir(folder, 0);
			}
		}else{
			$('input[name="folder"]').val('');
		}
	}
	function dir(folder){
		return $.mpf('items','items','folder',{'folder':folder,'id':id,'parent':parent,'jsonmsg':'true'});
	}
	function getdir(folder, i){
		folders = folder + (i==0?'':i);
		$.get(dir(folders),function(data){
			if(data){
				getdir(folder, i+1);
			}else{
				$('input[name="folder"]').val(folders).attr('required','required');;
			}
		});
	}
	$('input[name="folder"]').change(function(){
		$.getJSON(dir($(this).val()),function(data){
			if(data){
				alert(data.msg);
				$('input[name="folder"]').focus();
			}
		})
	});

	$('textarea[name=type]').change(function(){
		bosscms = 1;
		type = $(this).val();
		if(type==9){
			$('[link]').attr('hide','hide');
			$('[unlink]').removeAttr('hide');
			$('input[name="folder"]').removeAttr('required');
		}else{
			$('[link]').removeAttr('hide');
			$('[unlink]').attr('hide','hide');
			$('input[name="folder"]').attr('required','required');
		}
		$('dl[theme]').attr('hide','hide');
		$('dl[type'+$(this).val()+']').removeAttr('hide');
		theme();
	}); 
});