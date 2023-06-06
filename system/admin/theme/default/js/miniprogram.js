/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
if(window.jsonCtrl){
    var stringCtrl = JSON.stringify(jsonCtrl);

    var diyX = diyY = diyMove = 0;
    var diyCon = diyThe = diyHtml = diyNew = nores = '';
    $(document)
    .mousemove(function(e){
        diyX = e.pageX;
        diyY = e.pageY;
        if(diyMove === 1){
            window.getSelection?window.getSelection().removeAllRanges():document.selection.empty();
            diyMove = 2;
            diyThe.addClass('move');
            uX = diyThe.offset().left;
            uY = diyThe.offset().top;
            diyHtml = diyThe[0].outerHTML;
            $('body').append('<div id="diyNew">'+diyHtml+'</div>');
            diyNew = $('#diyNew');
            diyNew
            .css('left',diyX)
            .css('top',diyY)
            .css('margin-left',-Math.abs(diyX-uX))
            .css('margin-top',-Math.abs(diyY-uY));
            diyNew.find('.divide').remove();
        }else if(diyMove === 2){
            window.getSelection?window.getSelection().removeAllRanges():document.selection.empty();
            diyNew.show()
            .css('left',diyX-$(window).scrollLeft())
            .css('top',diyY-$(window).scrollTop());
            diyList = diyCon.find('.diy');
            if(diyList.length > 1){
                diyList.each(function(){
                    the = $(this);
                    l = $(this).offset().left;
                    r = l+375;
                    h = $(this).outerHeight();
                    if(the.prev('.diy').hasClass('move')){
                        b = h/2>188?188:h/2;
                        t = $(this).offset().top+b;
                        b = t+b;
                        z = 1;
                    }else if(the.next('.diy').hasClass('move')){
                        t = $(this).offset().top;
                        b = t+(h/2>188?h-188:h/2);
                        z = 2;
                    }else{
                        t = $(this).offset().top;
                        b = t+$(this).outerHeight();
                        z = 3;
                    }
                    if(diyY>t && diyY<b && diyX>l && diyX<r && !the.hasClass('move')){
                        var move = diyCon.find('.diy.move');
                        var key = move.index();
                        var id = so_key(jsonCtrl.diypage,'id',$diypage);
                        var json = jsonCtrl.diypage[id]['module'][key];
                        jsonCtrl.diypage[id]['module'].splice(key,1);
                        move.remove();
                        if(z == 1){
                            jsonCtrl.diypage[id]['module'].splice(the.index()+1,0,json);
                            the.after(diyHtml);
                        }else{
                            jsonCtrl.diypage[id]['module'].splice(the.index(),0,json);
                            the.before(diyHtml);
                        }
                    }
                });
            }
            
        }
    })
    .mouseup(function(){
        if(diyMove === 2){
            diyNew.remove();
            dMove = diyCon.find('.diy.move');
            dMove.removeClass('move');
            module_add(dMove.index());
            //init_module();
        }
        if(diyMove){
            diyMove = 0;
            return false;
        }
    })
    .on('mousedown','.phone>.mob>.content>.conbar>.diy>.dimmer',function(e){
        if(e.which == 1){
            diyMove = 1;
            diyThe = $(this).parent('.diy');
            diyCon = $('.phone>.mob>.content>.conbar');
        }
    });

    var diy_bosscms = {};
    $(document)
    .on('click','.phone>.mob>.content>.conbar>.diy>.dimmer',function(){
        var partdiy = $(this).parent('.diy');
        $('.phone>.mob>.content>.conbar>.diy, .phone>.mob div[type$="_bar"]').removeClass('on');
        partdiy.addClass('on');
        var type = partdiy.attr('type');
        var index = partdiy.index();
        var param = [];
        var id = so_key(jsonCtrl.diypage,'id',$diypage);
        if(jsonCtrl.diypage[id]['module'].hasOwnProperty(index)){
            param = jsonCtrl.diypage[id]['module'][index].param;
        }
        $.post($.mpf('miniprogram','renovation','ctrl'),{type:type, param:JSON.stringify(param)},function(data){
            if(data.html){
                design = $('.design');
                design.html(data.html);
                initcode(design);
            }
        },'json');
    })
    .on('click','.phone>.mob div[type$="_bar"]>.dimmer',function(){
        var bar = $(this).parent('div[type$="_bar"]');
        $('.phone>.mob>.content>.conbar>.diy, .phone>.mob div[type$="_bar"]').removeClass('on');
        bar.addClass('on');
        var type = bar.attr('type');
        var param = {};
        if(jsonCtrl[type]){
            param = jsonCtrl[type];
        }
        if(type == 'top_bar'){
            param['navigationBarTitleText'] = jsonCtrl.diypage[so_key(jsonCtrl.diypage,'id',$diypage)].title;
        }
        $.post($.mpf('miniprogram','renovation','ctrl'),{type:type, param:JSON.stringify(param)},function(data){
            if(data.html){
                design = $('.design');
                design.html(data.html);
                initcode(design);
            }
        },'json');
    })
    .on('click','.phone>.mob>.content>.conbar>.diy>.divide ul li a.delete',function(){
        var partdiy = $(this).parents('.diy');
        if(partdiy.attr('type').indexOf('sys_') !== 0){
            if(confirm('确定删除吗？')){
                var id = so_key(jsonCtrl.diypage,'id',$diypage);
                jsonCtrl.diypage[id]['module'].splice(partdiy.index(),1);
                diyOn = partdiy.next('.diy');
                if(diyOn.length == 0){
                    diyOn = partdiy.prev('.diy');
                }
                partdiy.remove();
                if(diyOn.length > 0){
                    diyOn.find('.dimmer').click();
                }else{
                    $('.design').html('');
                }
            }
        }
    })
    .on('click','.phone>.mob>.content>.conbar>.diy>.divide ul li a.moveprev',function(){
        var diyThis = $(this).parents('.diy');
        var diyPrev = diyThis.prev('.diy');
        if(diyPrev.length > 0){
            var key = diyThis.index();
            var id = so_key(jsonCtrl.diypage,'id',$diypage);
            var json = jsonCtrl.diypage[id]['module'][key];
            var index = diyPrev.index();
            jsonCtrl.diypage[id]['module'].splice(key,1);
            diyThis.remove();
            jsonCtrl.diypage[id]['module'].splice(index,0,json);
            diyPrev.before('<div class="diy" type="'+json.type+'"></div>');
            module_add(index);
        }
    })
    .on('click','.phone>.mob>.content>.conbar>.diy>.divide ul li a.movenext',function(){
        var diyThis = $(this).parents('.diy');
        var diyNext = diyThis.next('.diy');
        if(diyNext.length > 0){
            var key = diyThis.index();
            var id = so_key(jsonCtrl.diypage,'id',$diypage);
            var json = jsonCtrl.diypage[id]['module'][key];
            var index = diyNext.index();
            jsonCtrl.diypage[id]['module'].splice(key,1);
            diyThis.remove();
            jsonCtrl.diypage[id]['module'].splice(index,0,json);
            diyNext.after('<div class="diy" type="'+json.type+'"></div>');
            module_add(index);
        }
    })
    .on('click','.phone>.mob>.content>.conbar>.diy>.divide ul li a.movefirst',function(){
        var diyThis = $(this).parents('.diy');
        var key = diyThis.index();
        if(key > 0){
            var id = so_key(jsonCtrl.diypage,'id',$diypage);
            var json = jsonCtrl.diypage[id]['module'][key];
            jsonCtrl.diypage[id]['module'].splice(key,1);
            diyThis.remove();
            jsonCtrl.diypage[id]['module'].unshift(json);
            $('.phone>.mob>.content>.conbar').prepend('<div class="diy" type="'+json.type+'"></div>');
            module_add(0);
        }
    })
    .on('click','.phone>.mob>.content>.conbar>.diy>.divide ul li a.movelast',function(){
        var diyThis = $(this).parents('.diy');
        var key = diyThis.index();
        if(key < $('.phone>.mob>.content>.conbar>.diy').length-1){
            var id = so_key(jsonCtrl.diypage,'id',$diypage);
            var json = jsonCtrl.diypage[id]['module'][key];
            jsonCtrl.diypage[id]['module'].splice(key,1);
            diyThis.remove();
            jsonCtrl.diypage[id]['module'].push(json);
            $('.phone>.mob>.content>.conbar').append('<div class="diy" type="'+json.type+'"></div>');
            module_add(jsonCtrl.diypage[id]['module'].length-1);
        }
    })
    .on('click','.diypage>ul>li>span>i.fa-close,bosscms',function(){
        const dp = $(this).prev('a').attr('diypage');
        if(dp!=0 && confirm('确定删除吗？')){
            if(dp == $diypage){
                _alert('不能删除当初编辑页面','red');
            }else{
                jsonCtrl.diypage.splice(so_key(jsonCtrl.diypage,'id',dp),1);
                init_page();
            }
        }
    })
    .on('click','.diypage>ul>li>span>a',function(){
        const dp = $(this).attr('diypage');
        if(id = so_key(jsonCtrl.diypage,'id',dp)){
            $('.phone>.mob>.content>.conbar>.diy.on, .phone>.mob div[type$="_bar"].on').removeClass('on');
            $('section.renovation .design').html('');
            $diypage = dp;
            init_module();
            init_page();
        }else{
            _alert('error','red');
        }
    })
    .on('click','.diypage>a.add',function(){
        dpdiv = $(this).parent('.diypage');
        dpdiv.find('section.easy').remove();
        html = '<div class="addbox">'+
            '<dl>'+
                '<dt>标题</dt>'+
                '<dd><code class="input"><input name="title" placeholder="请输入页面标题" type="text"/></code></dd>'+
            '</dl>'+
            '<dl>'+
                '<dt>类型</dt>'+
                '<dd><code class="select"><select name="class" placeholder="请选择页面类型">';
        for(v in jsonPage){
            if(v != 'home'){
                html += '<option value="'+v+'"'+(v=='page'?' selected':'')+'>'+jsonPage[v]['title']+'</option>';
            }
        }
        html += '</select></code></dd>'+
            '</dl>'+
            '<div><a class="button blue"><font>确定</font></a></div>'+
        '</div>';
        dpdiv.append(easyhtml(html,'新增页面',360,240,window.innerWidth/2-180,window.innerHeight/2-120));
        initcode(dpdiv);
    })
    .on('click','.diypage .addbox>div>a',function(){
        const addbox = $(this).parents('.addbox');
        const tit = addbox.find('[name="title"]').val();
        const cls = addbox.find('[name="class"]').val();
        jsonCtrl.diypage.push({
            'id': set_id(),
            'title': tit,
            'class': cls,
            'module': jsonPage[cls].module.length>0?jsonPage[cls].module:[]
        });
        init_page();
        addbox.parent('.window').find('span.close>em.fa-times').click();
    });
   
    $(document).ready(function(e){
        $('.module>.assembly>ul>li>a').click(function(){
            if(type = $(this).attr('type')){
                var id = so_key(jsonCtrl.diypage,'id',$diypage);
                var key = jsonCtrl.diypage[id]['module'].length;
                jsonCtrl.diypage[id]['module'][key] = {
                    type: type,
                    param: {}
                };
                $('.phone>.mob>.content>.conbar').append('<div class="diy" type="'+type+'"></div>');
                module_add(key, function(key){
                    $('.phone>.mob>.content>.conbar>.diy').eq(key).children('.dimmer').click();
                    $('.phone>.mob>.content').animate({scrollTop:88888}, 888);
                });
            }
        });

        $('section.operation .btn>button').click(function(){
            var id = so_key(jsonCtrl.diypage,'id',$diypage);
            if(jsonCtrl.diypage[id].class == 'home'){
                var imgbase64 = '';
                $('.phone>.mob>.content>.conbar>.diy, .phone>.mob div[type$="_bar"]').removeClass('on');
                $('.design').html('');
                $('.phone>.mob>.content>.conbar')
                    .addClass('screen')
                    .attr('style', $('.conbox').attr('style'))
                    .find('video').each(function(){
                        if(poster = $(this).attr('poster')){
                            $(this).after('<img src="'+poster+'" style="width:100%">').remove();
                        }
                    });
                html2canvas(document.querySelector(".phone>.mob>.content>.conbar"),{
                    backgroundColor: "transparent",
                    allowTaint: true,
                    useCORS: true 
                }).then(canvas =>{
                    post_json(canvas.toDataURL("image/png"));
                });
            }else{
                post_json('');
            }
        });
        $('section.renovation div.module>.disting').click(function(){
            window.getSelection?window.getSelection().removeAllRanges():document.selection.empty();
            if($(this).hasClass('on')){
                $(this).removeClass('on');
            }else{
                $(this).addClass('on');
            }
        });
        $('section.renovation div.kind>a[tag]').click(function(){
            $('section.renovation div.kind>a[tag]').removeClass('on');
            $(this).addClass('on');
            $('section.renovation .fast, bosscms').children('div').removeClass('on');
            $('section.renovation .fast>div.'+$(this).attr('tag')).addClass('on');
        });

        if($('.phone>.mob div[type$="_bar"]').length>0){
            $('.phone>.mob div[type$="_bar"]').each(function(){
                bar_add($(this).attr('type'));
            });
        }

        $('section.operation a.back').click(function(){
            if(stringCtrl==JSON.stringify(jsonCtrl) || confirm('修改未保存，是否继续返回？')){
                window.location.href = $(this).attr('url');
            }
        });

        init_page();
        init_module();
        changecode($('section.renovation .design'), 'dd.parts>', function(obj, name, val){
            module_param(name, val);
        });
    });

    function post_json(imgbase64){
        if(window.parent){
            window.parent.window.screenname = $name;
            window.parent.window.screenshot = imgbase64;
        }
        $.post($.mpf('miniprogram','renovation','add',{name:$name,jsonmsg:true}),{jsonCtrl:JSON.stringify(jsonCtrl)},function(data){
            if(data.state == 1){
                _alert('操作成功','green');
            }else{
                _alert(data.msg,'red');
            }
            window.setTimeout(function(){
                window.location.href = $('section.operation a.back').attr('url');
            },200);
        },'json');
    }

    function init_page(){
        const dps = jsonCtrl.diypage;
        var id = so_key(jsonCtrl.diypage,'id',$diypage);
        html = '';
        for($k in dps){
            html += '<li'+(id==$k?' class="on"':'')+'>'+
                '<span>'+
                    '<a diypage="'+dps[$k].id+'"><b>'+dps[$k].title+'</b><u>('+jsonPage[dps[$k].class].title+')</u></a>'+
                    ($k!=0&&id!=$k?'<i class="fa fa-close"></i>':'')+
                '</span>'+
            '</li>';
            if(id==$k){
                $('.phone>.mob>.topbar>div h4 span').html(dps[$k].title);
            }
        }
        $('.diypage>ul').html(html);
    }

    function init_module(){
        $('.phone>.mob>.content>.conbar').html('');
        $('.phone').attr('class','phone');
        $('.phone').find('link,script').remove();
        if(id = so_key(jsonCtrl.diypage,'id',$diypage)){
            const module = jsonCtrl.diypage[id].module;
            for($k in module){
                $('.phone>.mob>.content>.conbar').append('<div class="diy" type="'+module[$k].type+'"></div>');
                module_add($k);
            }
        }
    }

    function module_param(name, value){
        don = $('.phone>.mob>.content>.conbar>.diy.on, .phone>.mob div[type$="_bar"].on');
        if(don.length == 1){
            const type = don.attr('type');
            if(don.hasClass('diy')){
                const key = don.index();
                var id = so_key(jsonCtrl.diypage,'id',$diypage);
                jsonCtrl.diypage[id]['module'][key].param[name] = value;
                if(name.indexOf('_reset') != -1){
                    clearTimeout(nores);
                    nores = window.setTimeout(function(){
                        module_add(key);
                    },200);
                }else{
                    clearTimeout(nores);
                    nores = window.setTimeout(function(){
                        json = jsonCtrl.diypage[id]['module'][key].param;
                        data = diy_bosscms[don.attr('diy')];
                        for(i in json){
                            data = data.replace(new RegExp('\\['+i+'\\]','g'), json[i]);
                        }
                        don.html(module_html(data));
                        $(window).load();
                    },1);
                }
            }else{
                if(!jsonCtrl.hasOwnProperty(type) || jsonCtrl[type].length==0){
                    jsonCtrl[type] = {};
                }
                jsonCtrl[type][name] = value;
                bar_add(type);
            }
        }
    }

    function module_add(key, func){
        var id = so_key(jsonCtrl.diypage,'id',$diypage);
        var res = jsonCtrl.diypage[id]['module'][key];
        $.post($.mpf('miniprogram','renovation','module'),{key:key, class:jsonCtrl.diypage[id].class, type:res.type, param:JSON.stringify(res.param)},function(data){
            if(data.type){
                var diy = 'DIY'+Math.floor(Math.random()*100000);
                var id = so_key(jsonCtrl.diypage,'id',$diypage);
                diy_bosscms[diy] = data.code;
                if(!jsonCtrl.diypage[id]['module'][data.key].hasOwnProperty('param') || jsonCtrl.diypage[id]['module'][data.key].param.length==0){
                    jsonCtrl.diypage[id]['module'][data.key].param = data.param;
                }else{
                    for(i in data.param){
                        if(!jsonCtrl.diypage[id]['module'][data.key].param.hasOwnProperty(i)){
                            jsonCtrl.diypage[id]['module'][data.key].param[i] = data.param[i];
                        }
                    }
                }
                $('.phone>.mob>.content>.conbar>.diy').eq(data.key)
                    .attr('diy',diy)
                    .attr('display',jsonCtrl.diypage[id]['module'][data.key].param['display_reset'])
                    .html(module_html(data.html));
                if(!$('.phone').hasClass('_'+data.type)){
                    var path = '../system/admin/miniprogram/module/'+data.type+'/'+data.type;
                    var date = new Date();
                    $('.phone')
                        .append('<link href="'+path+'.css" rel="stylesheet" \/>')
                        .append('<script src="'+path+'.js"><\/script>')
                        .addClass('_'+data.type);
                }
                $(window).load();
                if(typeof(func) == 'function'){
                    func(data.key);
                }
            }
        },'json');
    }

    function bar_add(type, func){
        param = jsonCtrl[type];
        if(type=='top_bar' && param && !param.hasOwnProperty('navigationBarTitleText')){
            param['navigationBarTitleText'] = jsonCtrl.diypage[so_key(jsonCtrl.diypage,'id',$diypage)].title;
        }
        $.post($.mpf('miniprogram','renovation','bar'),{type:type, param:JSON.stringify(param)},function(data){
            if(data.type){
                var diy = 'DIY'+Math.floor(Math.random()*100000);
                diy_bosscms[diy] = data.code;
                if(!jsonCtrl[data.type]){
                    jsonCtrl[data.type] = data.param;
                }else{
                    for(i in data.param){
                        if(!jsonCtrl[data.type].hasOwnProperty(i)){
                            jsonCtrl[data.type][i] = data.param[i];
                        }
                    }
                }
                $('.phone>.mob div[type="'+data.type+'"]')
                    .attr('diy',diy)
                    .attr('display',jsonCtrl[data.type]['display'])
                    .html(
                        bar_html(data.type=='top_bar'?data.html.replace('[navigationBarTitleText]',jsonCtrl.diypage[so_key(jsonCtrl.diypage,'id',$diypage)].title):data.html)
                    );
                if(data.type=='top_bar' && jsonCtrl[data.type]['navigationBarTitleText']){
                    jsonCtrl.diypage[so_key(jsonCtrl.diypage,'id',$diypage)]['title'] = jsonCtrl[data.type]['navigationBarTitleText'];
                    delete jsonCtrl[data.type]['navigationBarTitleText'];
                    init_page();
                }
                if(typeof(func) == 'function'){
                    func();
                }
                $('.phone>.mob>.content')
                    .css('padding-top',$('.phone>.mob>.topbar').height())
                    .css('padding-bottom',$('.phone>.mob>.tabbar').height());
                $('.phone>.mob>.cutbar')
                    .css('top',$('.phone>.mob>.topbar').height())
                    .css('bottom',$('.phone>.mob>.tabbar').height());
            }
        },'json');
    }

    function module_html(data){
        data = data.replace(new RegExp('(<img [^>]*?src=)("\s*"|\'\s*\'|\s)','g'),"$1\""+$G['relative']+"system/admin/common/img/not_img.png\"");
        return  '<div class="dimmer"></div>'+
                '<div class="display">'+data+'</div>'+
                '<div class="divide">'+
                    '<ul>'+
                        '<li><a class="movefirst" href="javascript:;"><i class="fa fa-angle-double-up"></i></a></li>'+
                        '<li><a class="moveprev" href="javascript:;"><i class="fa fa-angle-up"></i></a></li>'+
                        '<li><a class="movenext" href="javascript:;"><i class="fa fa-angle-down"></i></a></li>'+
                        '<li><a class="movelast" href="javascript:;"><i class="fa fa-angle-double-down"></i></a></li>'+
                        '<li><a class="delete" href="javascript:;"><i class="fa fa-trash-o"></i></a></li>'+
                    '</ul>'+
                '</div>';
    }

    function bar_html(data){
        return  '<div class="dimmer"></div>'+
                '<div class="display">'+data+'</div>'+
                '<div class="divide"></div>';
    }

    function set_id(){
        const rand = Math.floor(Math.random()*100).toString();
        if(so_key(jsonCtrl.diypage,'id',rand)){
            return set_id();
        }else{
            return rand;
        }
    }

    function so_key(json, name, value){
        for(i in json){
            if(json[i][name] == value){
                return i;
                break;
            }
        }
    }
}else{
    if($('aside.theme.miniprogram').length == 1){
        if(window.parent){
            screenname = window.parent.window.screenname;
            screenshot = window.parent.window.screenshot;
            if(screenname && screenshot){
                $.post($.mpf('miniprogram','renovation','add',{name:screenname,jsonmsg:true}),{imgbase64:screenshot},function(data){
                    if(data.state != 0){
                        $('img[alt="'+data.state+'"]').attr('src',$G['relative']+'system/admin/miniprogram/templates/'+screenname+'/image.png?'+Math.ceil(Math.random()*10000));
                    }
                },'json');
                window.parent.window.screenname = window.parent.window.screenshot = '';
            }
        }
    }
}
