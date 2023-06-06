var at = window.location.hash.match(/#_alert=(.+?),(red|green|blue|yellow|gold)/);
if(at){
	_alert(decodeURI(at[1]),at[2]);
	window.location.hash = window.location.hash.replace(at[0],'');
}
function _alert(str, type){
	var date = new Date();
	now = date.getTime();
	$('body').append('<h6 class="alert '+type+'" time="'+now+'" style="z-index:'+now+';"><b>'+str+'</b></h6>');
	tha = $('h6.alert[time="'+now+'"]');
	tha.animate({top:78,opacity:1},288);
	(function(tha){
		window.setTimeout(function(){
			tha.remove();
		},
		tha.hasClass('green')?3000:2000);
	})(tha);
}

$(window).load(function(){
	$('body>.main>div.content.win').css('padding-bottom',$('body>.main>.tabbar').height());
});