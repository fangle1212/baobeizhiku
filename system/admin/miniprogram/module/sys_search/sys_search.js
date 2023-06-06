var cacheSearch = {},
	objSearch = uliSearch = turlSearch = '',
	maxpageSearch = 1,
	pagesSearch = 1,
	loadingSearch = true,
	divSearch = '.mob-sys-search';
$(window).load(function(){
	if($(divSearch).length>0 && !$(divSearch).hasClass('active')){
		maxpageSearch = 1;
		pagesSearch = 1;
		objSearch = $(divSearch+'>ul');
		uliSearch = objSearch.html().replace('data-src','src');
		turlSearch = $G['relative']+'api/miniprogram/?action=search_list&items='+objSearch.attr('items')+'&keyword='+objSearch.attr('keyword')+'&rows='+objSearch.attr('rows')+'&pages=';
		objSearch.html('');
		addResSearch(1);
		$(divSearch).addClass('active');
	}
});
var ctSearch = $(divSearch).parents('div.content.win');
ctSearch.scroll(function(){
	if(pagesSearch<=maxpageSearch && $(divSearch).hasClass('active') && ctSearch[0].scrollHeight-10<ctSearch.outerHeight()+ctSearch.scrollTop()){
		addResSearch(pagesSearch);
	}
});
function addResSearch(pg){
	if(loadingSearch){
		loadingSearch = false;
		if(cacheSearch[turlSearch+pg]){
			addLiSearch(cacheSearch[turlSearch+pg]);
			loadingSearch = true;
		}else{
			$.get(turlSearch+pg, function(res){
				if(res){
					res = JSON.parse(res);
					if(res.pages){
						cacheSearch[turlSearch+res.pages.pages] = res;
						addLiSearch(res);
					}
				}
				loadingSearch = true;
			});
		}
	}
}
function addLiSearch(res){
	if(res.pages){
		if(pagesSearch == 1){
			objSearch.html('');
		}
		for(v in res.list){
			nli = uliSearch;
			for(v2 in res.list[v]){
				nli = nli.replace(new RegExp('{{'+v2+'}}','g'),res.list[v][v2]);
			}
			objSearch.append(nli).find('li').show();
		}
		maxpageSearch = res.pages.last.number;
		pagesSearch++;
		if(pagesSearch > maxpageSearch){
			$(divSearch+'>u').addClass('over');
		}
	}else{
		$(divSearch+'>u').addClass('over');
	}
}