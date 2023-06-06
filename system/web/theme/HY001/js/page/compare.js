// 快速导航

// 滚动
var productListDom = $('#product-list');
var pTop = productListDom.offset().top + productListDom.height() / 2;
$(window).scroll(function() {
  var scrollTop = $(this).scrollTop();
  if (scrollTop >= pTop) {
    if ($('#fixedProductList').length) {
      var scrollLeft = $('.scroll-box').eq(0).scrollLeft();
      var mLeft = ($('body').width() - $('.page-compare article').width()) / 2;
      $('#fixedProductList').css({ 'left': -scrollLeft + mLeft + 'px' })
      $('#fixedProductList').show();
    } else {
      var newDom = productListDom.clone();
      newDom.addClass('fixed');
      newDom.attr('id', 'fixedProductList');
      productListDom.after(newDom);
    }
  } else {
    if ($('#fixedProductList').length) {
      $('#fixedProductList').css({ 'left': 0 })
      $('#fixedProductList').hide();
    }
  }
});

$('.scroll-box').eq(0).scroll(function() {
  if ($('#fixedProductList').length) {
    var scrollLeft = $(this).scrollLeft();
    var mLeft = ($('body').width() - $('.page-compare article').width()) / 2;
    $('#fixedProductList').css({ 'left': -scrollLeft + mLeft + 'px' })
  }
  // $(this).find('.n-title').css({ 'padding-left': scrollLeft + 'px' })
})

// 删除
$('.page-compare .del-btn').click(function () {
  var productId = $(this).attr('data-id');
  console.log('🚀 ~ file: compare.js:27 ~ productId:', productId)
  var sessionIdsArr = getSessionIdsArr();
  var index = -1;
  for (var i = 0; i < sessionIdsArr.length; i++) {
    if (sessionIdsArr[i] === productId) {
      index = i;
      break;
    }
  }
  if (index >= 0) {
    sessionIdsArr.splice(index, 1);
    setSessionIdsArr(sessionIdsArr)
    jumpToCompare();
  }
});

// 去空行
var sessionIdsArr = getSessionIdsArr();
if (sessionIdsArr.length > 0) {
  $('.page-compare .baseInfo-list > .row, .page-compare .nutrients > .row').each(function() {
    var col = $(this).find('> .col');
    var colList = col.eq(0).siblings();
    var isEmpty = true;
    for(var i = 0; i < colList.length; i ++) {
      var value = $(colList[i]).text();
      if (value.replace(/\s+/g, '') !== '') {
        isEmpty = false;
        break;
      }
    }
    if (isEmpty) {
      $(this).hide();
    }
  })
}