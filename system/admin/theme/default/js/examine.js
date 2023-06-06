/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
$(document).ready(function(e) {
	$('a[examine]').click(function(){
		(function(the){
			$.get(the.attr('url'),function(data){
				the.after(data);
				the.remove();
			});
		})($(this));
	});
	$(document).on('click','a[modify]',function(){
		(function(the){
			$.get(the.attr('url'),{jsonmsg:1},function(res){
				if(res.state=='success'){
					_alert(res.msg,'green');
					(function(t){
						$.get($.mpf('examine','examine',t.attr('modify')),function(data){
							t.parents('td').html(data);
						});
					})(the);
				}else{
					_alert('删除失败');
				}
			},'json');
		})($(this));
	});
	$('a.button.all').click(function(){
		$('a[examine]').each(function(){
			$(this).click();
		});
	});
});