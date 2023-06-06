var cacheNews = {},
	objNews = uliNews = turlNews = '',
	maxpageNews = 1,
	pagesNews = 1,
	loadingNews = true,
	divNews = '.mob-sys-News';
$(window).load(function(){
	if($(divNews).length>0 && !$(divNews).hasClass('active')){
		maxpageNews = 1;
		pagesNews = 1;
		objNews = $(divNews+'>ul');
		uliNews = objNews.html().replace('data-src','src');
		turlNews = $G['relative']+'api/miniprogram/?action=group_list&items='+objNews.attr('items')+'&rows='+objNews.attr('rows')+'&pages=';
		objNews.html('');
		addResNews(1);
		$(divNews).addClass('active');
	}
});
var ctNews = $(divNews).parents('div.content.win');
ctNews.scroll(function(){
	if(pagesNews<=maxpageNews && $(divNews).hasClass('active') && ctNews[0].scrollHeight-10<ctNews.outerHeight()+ctNews.scrollTop()){
		addResNews(pagesNews);
	}
});
function addResNews(pg){
	if(loadingNews){
		loadingNews = false;
		if(cacheNews[turlNews+pg]){
			addLiNews(cacheNews[turlNews+pg]);
			loadingNews = true;
		}else{
			$.get(turlNews+pg, function(res){
				if(res){
					res = JSON.parse(res);
					if(res.pages){
						cacheNews[turlNews+res.pages.pages] = res;
						addLiNews(res);
					}
				}
				loadingNews = true;
			});
		}
	}
}
function addLiNews(res){
	if(res.pages){
		if(pagesNews == 1){
			objNews.html('');
		}
		for(v in res.list){
			nli = uliNews;
			for(v2 in res.list[v]){
				nli = nli.replace(new RegExp('{{'+v2+'}}','g'),res.list[v][v2]);
			}
			objNews.append(nli).find('li').show();
		}
		maxpageNews = res.pages.last.number;
		pagesNews++;
		if(pagesNews > maxpageNews){
			$(divNews+'>u').addClass('over');
		}
	}else{
		$(divNews+'>u').addClass('over');
	}
}