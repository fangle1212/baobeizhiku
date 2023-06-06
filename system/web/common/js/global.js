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

{if:(config.member_open)}
{if:(config.member_agreement_open)}
$('form[register]>div.button>button').click(function(){
	if(!$('form[register]>div.agreement input[name="agreement"]').is(':checked')){
		_alert('{config.member_agreement_error}');
		return false;
	}
});
{/if}
{if:(config.member_captcha_type==1)}
(function($){
	ins = $('span.captcha>ins[resend]');
	if(ins.length>0){
		rt = 0;
		resend = ins.attr('resend');
		ini = ins.find('i');
		word = ini.html();
		phone = $('input[name="phone"]');
		ins.click(function(){
			if(rt == 0){
				if(!isPhone(phone.val())){
					_alert('{config.member_phone_error}');
					phone.focus();
				}else{
					$.post('{path.relative}api/member/?action=phonecode',{phone:phone.val()},function(data){
						if(data.state == 'success'){
							rt = 60;
							rdfunc();
							_alert(data.msg,'green');
						}else{
							_alert(data.msg);
						}
					},'json');
				}
			}
		});
		if(phone.length>0){
			$.get('{path.relative}api/member/?action=phonecode&rdtime=true',function(data){
				if(data.state == 'rdtime'){
					rt = data.msg;
					rdfunc();
				}
			},'json');
		}
		function rdfunc(){
			if(rt>0){
				ini.html( resend.replace('[time]',rt) );
				window.setTimeout(function(){
					rt--;
					rdfunc();
				},1000);
			}else{
				ini.html( word );
			}
		}
	}
	function isPhone(val) {
		reg =/^0?1[3|4|5|6|7|8][0-9]\d{8}$/;
		return reg.test(val);
	}
})($);
{/if}
{/if}