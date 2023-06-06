var cache = {},
	obj = uli = turl = '',
	utop = 0,
	maxpage = 1,
	pages = 1,
	loading = true,
	div = '.mob-sys-download';
$(window).load(function(){
	if($(div).length>0 && !$(div).hasClass('active')){
		maxpage = 1;
		pages = 1;
		obj = $(div+'>ul');
		uli = obj.html();
		turl = $G['relative']+'api/miniprogram/?action=group_list&items='+obj.attr('items')+'&rows='+obj.attr('rows')+'&pages=';
		obj.html('');
		addRes(1);
		$(div).addClass('active');
	}
});
var ct = $(div).parents('div.content.win');
ct.scroll(function(){
	if(pages<=maxpage && $(div).hasClass('active') && ct[0].scrollHeight-10<ct.outerHeight()+ct.scrollTop()){
		addRes(pages);
	}
});
function addRes(pg){
	if(loading){
		loading = false;
		if(cache[turl+pg]){
			addLi(cache[turl+pg]);
			loading = true;
		}else{
			$.get(turl+pg, function(res){
				if(res){
					res = JSON.parse(res);
					if(res.pages){
						cache[turl+res.pages.pages] = res;
						addLi(res);
					}
				}
				loading = true;
			});
		}
	}
}
function addLi(res){
	if(res.pages){
		if(pages == 1){
			obj.html('');
		}
		for(v in res.list){
			nli = uli;
			for(v2 in res.list[v]){
				nli = nli.replace(new RegExp('{{'+v2+'}}','g'),res.list[v][v2]);
			}
			obj.append(nli).find('li').show();
		}
		maxpage = res.pages.last.number;
		pages++;
		if(pages > maxpage){
			$(div+'>u').addClass('over');
		}
	}else{
		$(div+'>u').addClass('over');
	}
}