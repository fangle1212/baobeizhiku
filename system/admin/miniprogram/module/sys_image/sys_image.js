var cacheImage = {},
	objImage = uliImage = turlImage = '',
	maxpageImage = 1,
	pagesImage = 1,
	loadingImage = true,
	divImage = '.mob-sys-Image';
$(window).load(function(){
	if($(divImage).length>0 && !$(divImage).hasClass('active')){
		maxpageImage = 1;
		pagesImage = 1;
		objImage = $(divImage+'>ul');
		uliImage = objImage.html().replace('data-src','src');
		turlImage = $G['relative']+'api/miniprogram/?action=group_list&items='+objImage.attr('items')+'&rows='+objImage.attr('rows')+'&pages=';
		objImage.html('');
		addResImage(1);
		$(divImage).addClass('active');
	}
});
var ctImage = $(divImage).parents('div.content.win');
ctImage.scroll(function(){
	if(pagesImage<=maxpageImage && $(divImage).hasClass('active') && ctImage[0].scrollHeight-10<ctImage.outerHeight()+ctImage.scrollTop()){
		addResImage(pagesImage);
	}
});
function addResImage(pg){
	if(loadingImage){
		loadingImage = false;
		if(cacheImage[turlImage+pg]){
			addLiImage(cacheImage[turlImage+pg]);
			loadingImage = true;
		}else{
			$.get(turlImage+pg, function(res){
				if(res){
					res = JSON.parse(res);
					if(res.pages){
						cacheImage[turlImage+res.pages.pages] = res;
						addLiImage(res);
					}
				}
				loadingImage = true;
			});
		}
	}
}
function addLiImage(res){
	if(res.pages){
		if(pagesImage == 1){
			objImage.html('');
		}
		for(v in res.list){
			nli = uliImage;
			for(v2 in res.list[v]){
				nli = nli.replace(new RegExp('{{'+v2+'}}','g'),res.list[v][v2]);
			}
			objImage.append(nli).find('li').show();
		}
		maxpageImage = res.pages.last.number;
		pagesImage++;
		if(pagesImage > maxpageImage){
			$(divImage+'>u').addClass('over');
		}
	}else{
		$(divImage+'>u').addClass('over');
	}
}