var idsKey = "ids";
$(".head article .search-box>i").click(function () {
  if ($(this).hasClass("on")) {
    $(this).removeClass("on");
  } else {
    $(this).addClass("on");
  }
});
$(".head article>.menu-box").click(function () {
  if ($(this).hasClass("on")) {
    $(this).removeClass("on");
  } else {
    $(this).addClass("on");
  }
});

var nav = $(".nav").html(),
  nav_li_more =
    '<li class="more has"><a href="javascript:;"><b><?php echo $nav["more"]; ?></b></a><div><ul></ul></div></li>';
function nav_li_func() {
  $(".nav").html(nav);
  var nav_win992 = $(window).width() < 992;
  if (nav_win992) {
    $(".head .menu-box").click(function () {
      $(this).removeClass("on active");
      $(".nav").addClass("active");
    });
    $(".nav").prepend('<a class="close" href="javascript:;"></a>');
    $(".nav article>div>ul").prepend(
      '<li class="close"><a href="javascript:;"></a></li>'
    );
    $(".nav>a.close, .nav article>div>ul>li.close>a").click(function () {
      $(".nav").removeClass("active");
    });
    $(".nav div>ul>li>strong").remove();
    $(".nav div>ul>li.has").prepend("<strong></strong>");
    $(".nav div>ul>li.has>strong").click(function () {
      var li = $(this).parent("li");
      if (li.hasClass("active")) {
        li.removeClass("active");
      } else {
        li.addClass("active");
      }
    });
    $(".nav article>div>ul div>ul").prepend(
      '<li class="back"><a href="javascript:;"></a></li>'
    );
    $(".nav article>div>ul div>ul>li.back>a").click(function () {
      $(this)
        .parent("li")
        .parent("ul")
        .parent("div")
        .parent("li")
        .removeClass("active");
    });
  } else {
    $(".nav article>div>ul").append(nav_li_more);
    var nav_li = [],
      nav_li_width = [],
      nav_li_number = 0,
      nav_html = "",
      nav_html_outer = "",
      nav_width = $(".nav article>div>ul").width(),
      nav_html_width = 0,
      nav_more_width = $(".nav article>div>ul>li.more").width();
    $(".nav article>div>ul>li.more").remove();
    $(".nav article>div>ul>li").each(function (i, e) {
      nav_li[i] = $(this)[0].outerHTML;
      nav_li_width[i] = $(this).width();
      nav_li_number++;
    });
    for (i = 0; i < nav_li_number; i++) {
      nav_html_width += nav_li_width[i] * 1;
      if (
        nav_html_width < nav_width ||
        nav_html_width + nav_more_width < nav_width
      ) {
        nav_html += nav_li[i];
      } else {
        nav_html_outer += nav_li[i];
      }
    }
    $(".nav article>div>ul").html(nav_html);
    if (nav_html_outer != "") {
      $(".nav article>div>ul").append(nav_li_more);
      $(".nav article>div>ul>li.more>div>ul").html(nav_html_outer);
    }
    $(".nav article>div>ul>li>div>ul li").mouseover(function () {
      div = $(this).children("div");
      if (
        div.length > 0 &&
        div.width() + div.offset().left > $(window).width()
      ) {
        $(this).addClass("right");
      }
    });
  }
}
nav_li_func();
$(window).resize(function () {
  nav_li_func();
});

if ($(".banner>ul>li").length > 1) {
  $(".banner>ul").after("<ol></ol>");
  $(".banner>ul").after("<dl><dt></dt><dd></dd></dl>");
  new Swiper(".banner", {
    wrapperClass: "banner>ul",
    slideClass: "banner>ul>li",
    autoplay: 5 * 1000,
    loop: true,
    watchSlidesProgress: true,
    watchSlidesVisibility: true,
    observer: true,
    observeParents: true,
    slidesPerView: 1,
    simulateTouch: false,
    keyboardControl: true,
    pagination: ".banner>ol",
    paginationElement: "li",
    paginationClickable: true,
    bulletActiveClass: "active",
    slideDuplicatedActiveClass: "active",
    slideVisibleClass: "visible",
    slideActiveClass: "active",
    prevButton: ".banner>dl>dt",
    nextButton: ".banner>dl>dd",
  });
}

$(".subnav ul").each(function (index, element) {
  li = $(this).children("li.on");
  if (li.length > 0) {
    $(this).scrollLeft(li.last().position().left);
  }
});
$(".subnav ul li.has>a").click(function () {
  if ($(window).width() < 992) {
    li = $(this).parent("li");
    if (li.hasClass("active")) {
      li.removeClass("active");
    } else {
      li.siblings().removeClass("active");
      li.addClass("active");
    }
    return false;
  }
});

function setSessionItem(key, value) {
  sessionStorage.setItem(key, value);
}

function getSessionItem(key) {
  return sessionStorage.getItem(key);
}

function getSessionIdsArr() {
  var sessionIds = sessionStorage.getItem(idsKey);
  return sessionIds ? sessionIds.split(",") : [];
}

function setSessionIdsArr(sessionIdsArr) {
  var limit = 5;
  var len = sessionIdsArr.length;
  var start = len - limit > 0 ? len - limit : 0;
  var ids = sessionIdsArr.slice(start, start + limit).join(",");
  setSessionItem(idsKey, ids);
}

function jumpToCompare() {
  $(".parent-nav-item").each(function () {
    var name = $(this).attr("title");
    if (name === "对比") {
      var url = $(this).attr("data-url");
      var target = $(this).attr("data-target");
      var ids = sessionStorage.getItem(idsKey);
      if (ids) {
        var prefix = url.indexOf("?") === -1 ? "?" : "&";
        url = url + prefix + idsKey + "=" + ids;
      }
      window.open(url, target || "_self");
    }
  });
}

// 添加对比
$(".compare_btn").click(function () {
  var productId = $(this).attr("data-id");
  var sessionIdsArr = getSessionIdsArr();
  var isExist = false;
  for (var i = 0; i < sessionIdsArr.length; i++) {
    if (sessionIdsArr[i] === productId) {
      isExist = true;
      break;
    }
  }
  if (!isExist) {
    sessionIdsArr.push(productId);
  }
  setSessionIdsArr(sessionIdsArr);
  jumpToCompare();
});

// 选项卡
$(".tabs .tabs-title .tabs-title-item").eq(0).addClass("on");
$(".tabs .tabs-content .tabs-content-item").eq(0).addClass("on");
$(".tabs .tabs-title .tabs-title-item").hover(function () {
  var index = $(this).index();
  $(".tabs .tabs-title .tabs-title-item")
    .eq(index)
    .addClass("on")
    .siblings()
    .removeClass("on");
  $(".tabs .tabs-content .tabs-content-item")
    .eq(index)
    .addClass("on")
    .siblings()
    .removeClass("on");
});

// 回到顶部
$("#back-to-top").click(function () {
  $("html, body").animate({ scrollTop: 0 }, 600);
  return false;
});
