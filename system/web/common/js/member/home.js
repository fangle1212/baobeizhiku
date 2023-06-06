$(document).ready(function(e) {
    $('dl.avatar>dd>div>ins>input[type="file"]').change(function(){
		var ins = $(this).parent('ins');
		var files = $(this).prop('files');
		if(files.length){
			if(/image/.test(files[0].type)){
				if(files[0].size>0 && files[0].size<{config.upload_maxsize}*1024*1024){
					var reader = new FileReader();
					reader.readAsDataURL(files[0]);
					reader.onloadend = function(){
						var imgobj = new Image();
						imgobj.src = reader.result;
						imgobj.onload = function(){
							if(imgobj.width>0&&imgobj.height>0){
								ins.prev('img').attr("src", reader.result).addClass('on');
							}else{
								ins.html('<input type="file" />');
								_alert('{config.member_avatar_error}');
							}
						}
						imgobj.onerror = function(){
							ins.html('<input type="file" />');
							_alert('{config.member_avatar_error}');
						}
					}
				}else{
					ins.html('<input type="file" />');
					_alert('{config.member_avatar_size_error} {config.upload_maxsize} MB');
				}
			}else{
				ins.html('<input type="file" />');
				_alert('{config.member_avatar_error}');
			}
		}
	});
	$('section.member>article>.sidebar dl.mnav>dt i').click(function(){
		if($(this).hasClass('on')){
			$(this).removeClass('on');
			$('section.member>article>.sidebar dl.mnav>dd').removeClass('on');
		}else{
			$(this).addClass('on');
			$('section.member>article>.sidebar dl.mnav>dd').addClass('on');
		}
	});
});

	