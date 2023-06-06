var cacheProduct = {},
	objProduct = uliProduct = turlProduct = '',
	maxpageProduct = 1,
	pagesProduct = 1,
	loadingProduct = true;
	divProduct = '.mob-sys-product';
$(window).load(function(){
	if($(divProduct).length>0 && !$(divProduct).hasClass('active')){
		maxpageProduct = 1;
		pagesProduct = 1;
		objProduct = $(divProduct+'>ul');
		uliProduct = objProduct.html().replace('data-src','src');
		turlProduct = $G['relative']+'api/miniprogram/?action=group_list&items='+objProduct.attr('items')+'&rows='+objProduct.attr('rows')+'&pages=';
		objProduct.html('');
		addResProduct(1);
		$(divProduct).addClass('active');
	}
});
var ctProduct = $(divProduct).parents('div.content.win');
ctProduct.scroll(function(){
	if(pagesProduct<=maxpageProduct && $(divProduct).hasClass('active') && ctProduct[0].scrollHeight-10<ctProduct.outerHeight()+ctProduct.scrollTop()){
		addResProduct(pagesProduct);
	}
});
function addResProduct(pg){
	if(loadingProduct){
		loadingProduct = false;
		if(cacheProduct[turlProduct+pg]){
			addLiProduct(cacheProduct[turlProduct+pg]);
			loadingProduct = true;
		}else{
			$.get(turlProduct+pg, function(res){
				if(res){
					res = JSON.parse(res);
					if(res.pages){
						cacheProduct[turlProduct+res.pages.pages] = res;
						addLiProduct(res);
					}
				}
				loadingProduct = true;
			});
		}
	}
}
function addLiProduct(res){
	if(res.pages){
		if(pagesProduct == 1){
			objProduct.html('');
		}
		for(v in res.list){
			nli = uliProduct;
			for(v2 in res.list[v]){
				nli = nli.replace(new RegExp('{{'+v2+'}}','g'),res.list[v][v2]);
			}
			objProduct.append(nli).find('li').show();
		}
		maxpageProduct = res.pages.last.number;
		pagesProduct++;
		if(pagesProduct > maxpageProduct){
			$(divProduct+'>u').addClass('over');
		}
	}else{
		$(divProduct+'>u').addClass('over');
	}
}