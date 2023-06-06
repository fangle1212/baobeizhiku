var $G=[];
$G['lang']={if:(language.id)}{language.id}{else}0{/if};
$G['relative']='{path.relative}';
$G['items']={if:(items.id)}{items.id}{else}0{/if};
$G['type']={if:(items.type)}{items.type}{else}0{/if};
$G['id']={if:(isset(get.id))}{get.id}{else}0{/if}

{if:(isset(get.id))}
$(document).ready(function(){
	$('notice[type][id]').each(function(){
		bosscms = true;
		$.post(
			$G['relative']+'api/notice/?lang='+$G['lang'],
			{
				type: $(this).attr('type'),
				id: $(this).attr('id')
			},
			function(data){
				if(data){
					$('notice[type="'+data.type+'"][id="'+data.id+'"]').before(data.notice).remove();
				}
			},
			'json'
		);
	});
});
{/if}

