$(document).ready(function(e) {
	if(window.location.hash == '#auto'){
		ce(true);
	}
    $('section.refer button.ce:not(.on)').click(function(){
		$(this).addClass('on');
		ce(false);
	});
    $('section.refer button.up:not(.on)').click(function(){
		$(this).addClass('on');
		$('span.prompt').html('正在下载并解压文件...');
		$.get($.mpf('update','update','download',{version:$('div.version span.new').html()}),function(res){
			if(res=='ok'){
				$('span.prompt').html('正在执行安装文件...');
				$.get($.mpf('update','update','install'),function(ins){
					if(ins=='ok'){
						$('span.prompt').html('安装完成！');
						re('auto');
					}else{
						$('span.prompt').html('执行安装文件失败！');
						alert('安装失败！');
						re('');
					}
				});
			}else{
				$('span.prompt').html('解压文件失败！');
				alert('解压失败！');
				re('');
			}
		});
	});
});
function ce(auto){
	window.setTimeout(function(){
		$.get('https://api.bosscms.net/rest/version/?version='+$('div.version span.old').html(),function(data){
			if(data){
				$('div.version span.new').html(data.version);
				if(data.version == $('div.version span.old').html()){
					 bosscms = true;
					$('span.prompt').append('三秒后自动刷新后台窗口。');
					window.setTimeout(function(){
						window.top.window.location.reload();
					},3000);
				}else{
					$('div.update').html(data.html);
					$('section.refer button.up, div.version p[hide] a').attr('href',data.url);
					$('section.refer button.up, div.version p').removeAttr('hide');
					$('section.refer button.ce').attr('hide','hide');
					if(auto){
						window.setTimeout(function(){
							$('section.refer button.up').click();
						},333);
					}
				}
				$('div.update').removeAttr('hide');
				$('section.refer button.ce').removeClass('on');
			}else{
				alert('最新版本查询失败，请刷新页面后重新检测！');
			}
		});
	},888);
}
function re(has){
	$('span.prompt').append('三秒后自动刷新当前窗口。');
	window.location.hash = has;
	window.setTimeout(function(){
		window.location.reload();
	},3000);
}