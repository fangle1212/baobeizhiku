<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');
?>
<?php load::into('head'); ?>
<section class="main table">
  <article class="hint">
    <i class="fa fa-info-circle"></i>
    <p>更多模板风格请到官网查看，如需模板定制请联系客服！</p>
  </article>
  <div class="market">
    <div class="cut">
      <span>模板分类：</span>
      <ul>
        <?php if($G['field']['templates']){ ?>
        <li<?php if(!$G['get']['divide'] && $G['get']['part']!='template'){ ?> class="on"<?php } ?>><a href="<?php echo url::param(url::mpf('template','market','init'),'divide',null); ?>">全部</a></li>
        <?php } ?>
        <li<?php if($G['get']['part']=='template'){ ?> class="on"<?php } ?>><a href="<?php echo url::mpf('template','template','init'); ?>">已安装</a></li>
        <?php foreach($G['field']['templates']['divide'] as $k=>$v){ ?>
        <li<?php if($G['get']['divide']==$k){ ?> class="on"<?php } ?>><a href="<?php echo url::param(url::mpf('template','market','init'),'divide',$k); ?>"><?php echo $v; ?></a></li>
        <?php } ?>
      </ul>
    </div>
    <?php if($G['field']['templates']){ ?>
    <div class="filter">
      <?php foreach($G['field']['templates']['complex'] as $v){ ?>
      <dl>
        <dt><?php echo $v['title']; ?>：</dt>
        <dd class="param">
          <a<?php if(!$G['get'][$v['name']]){ ?> class="on"<?php } ?> href="<?php echo url::param(url::param(url::param($G['path']['url'],'part','market'),'pages',null),$v['name'],null); ?>">全部</a>
          <?php foreach($v['param'] as $s){ ?>
          <a<?php if($G['get'][$v['name']]==$s){ ?> class="on"<?php } ?> href="<?php echo url::param(url::param(url::param($G['path']['url'],'part','market'),'pages',null),$v['name'],urlencode($s)); ?>"><?php echo $s; ?></a>
          <?php } ?>
        </dd>
      </dl>
      <?php } ?>
      <dl>
        <dt>搜索：</dt>
        <dd>
          <form method="get" action="./">
            <?php echo form::input('lang',$G['get']['lang'],null,'hidden',array(),false); ?>
            <?php echo form::input('mold','template',null,'hidden',array(),false); ?>
            <?php echo form::input('part','market',null,'hidden',array(),false); ?>
            <?php echo form::input('func','init',null,'hidden',array(),false); ?>
			<?php echo form::input('search',$G['get']['search'],null,'text',array('required','placeholder'=>'请输入行业信息搜索')); ?>
            <button class="fa fa-search"></button>
          </form>
          <a class="collect<?php if($G['get']['collect']=='list'){ ?> red<?php } ?>"
          <?php if($G['identity']){ ?>
            href="<?php echo url::mpf('template','market','init',array('collect'=>$G['get']['collect']=='list'?null:'list')); ?>"
          <?php }else{ ?>
            href="javascript:_alert('请先登录官方账号');"
          <?php } ?>><i class="fa fa-star"></i>我的收藏</a>
        </dd>
      </dl>
    </div>
    <?php } ?>
    <div class="list">
      <ul>
	    <?php foreach($data['list'] as $v){ ?>
        <li>
          <aside>
            <p class="img"><img src="<?php echo $v['image']; ?>" alt="<?php echo $v['name']; ?>" /></p>
            <p class="name"><a href="<?php echo $v['link']; ?>" target="_blank" class="name"><u class="green"><?php echo $v['name']; ?></u><?php echo $v['title']; ?> </a></p>
			<?php if($G['get']['part']=='market'){ ?>
            <p class="text">
              <span class="price">价格：
              <?php if($v['groups']==0){ ?>免费<?php }else{ ?>
              <i class="fa fa-rmb money"><?php echo $v['price']; ?></i> / <?php echo $v['buy_duration']; ?>
              <?php if($v['remark']){ ?><a href="javascript:_alert('<?php echo $v['remark']; ?>','gold');" color="red" class="preferential">[优惠]</a><?php } ?>
              <?php } ?>
              </span>
            </p>
			<?php } ?>
			<?php if($G['get']['part']=='market'){ ?>
            <p class="btn">
              <?php if($v['groups']==0 || $v['buyed']){ ?>
              <a class="btnfa green"
                <?php if($G['identity']){ ?>
                url="<?php echo url::mpf('template','market','install',array('name'=>$v['name'])); ?>" install="<?php echo $v['name']; ?>" groups="<?php echo $v['groups']; ?>"
				<?php }else{ ?>
                href="javascript:_alert('请先登录官方账号');"
                <?php } ?>>
                <em class="fa fa-cloud-download" title="安装"></em>
              </a>
              <?php }else{ ?>
              <a class="btnfa green buy"
                <?php if($G['identity']){ ?>
                easy="nofull" width="580" height="420" name="购买 “<?php echo $v['name']; ?>” 模板" url="<?php echo url::mpf('template','market','info',array('id'=>$v['id'],'name'=>$v['name'])); ?>"
                <?php }else{ ?>
                href="javascript:_alert('请先登录官方账号');"
                <?php } ?>><em class="fa fa-pencil" title="购买"></em></a>
               <?php } ?> 
                
              <?php  if($v['collect']){ ?>
              <a class="btnfa red"
                <?php if($G['identity']){ ?>
                href="<?php echo url::mpf('template','market','collect',array('id'=>$v['id'])); ?>"
                <?php }else{ ?>
                href="javascript:_alert('请先登录官方账号');"
                <?php } ?>>
                <em class="fa fa-star" title="已收藏"></em>
              </a>
              <?php }else{ ?>
              <a class="btnfa blue"
                <?php if($G['identity']){ ?>
                href="<?php echo url::mpf('template','market','collect',array('id'=>$v['id'])); ?>"
                <?php }else{ ?>
                href="javascript:_alert('请先登录官方账号');"
                <?php } ?>>
                <em class="fa fa-star-o" title="收藏"></em>
              </a>
              <?php } ?>
              <a class="btnfa red" href="<?php echo $v['demo']; ?>" target="_blank">
                <em class="fa fa-eye" title="演示"></em>
              </a>
            </p>
            <?php }else{ ?>
            <p class="btn">
              <?php if($G['update'] && $G['update'][$v['name']]>$v['version']){ ?>
              <a class="btnfa green"
                <?php if($G['identity']){ ?>
                href="<?php echo url::mpf('template','market','install',array('name'=>$v['name'],'update'=>$G['update'][$v['name']])); ?>"
				<?php }else{ ?>
                href="javascript:_alert('请先登录官方账号');"
                <?php } ?>>
                <em class="fa fa-cloud-upload" title="升级"></em>
              </a>
              <?php } ?>
              <?php if($v['name']==$G['config']['web_theme']){ ?>
              <a class="btnfa blue" href="javascript:;">
                <em class="fa fa-check-square-o" title="使用中"></em>
              </a>
              <?php }else{ ?>
              <a class="btnfa green" href="<?php echo url::mpf('template','template','modify',array('name'=>$v['name'])); ?>">
                <em class="fa fa-external-link" title="启用"></em>
              </a>
              <?php } ?>
              <a class="btnfa red delete" url="<?php echo url::mpf('template','template','delete',array('name'=>$v['name'])); ?>">
                <em class="fa fa-trash-o" title="删除"></em>
              </a>
            </p>
            <?php } ?>
          </aside>
        </li>
        <?php } ?>
      </ul>
    </div>
    <div class="pages">
      <ol>
        <li><a href="<?php echo url::param($G['path']['url'],'pages',$data['pages']['first']['number']>1?$data['pages']['first']['number']:null); ?>"><i class="fa fa-angle-double-left"></i></a></li>
        <li><a href="<?php echo url::param($G['path']['url'],'pages',$data['pages']['prev']['number']>1?$data['pages']['prev']['number']:null); ?>"><i class="fa fa-angle-left"></i></a></li>
        <?php foreach($data['pages']['list'] as $v){ ?>
        <li><a href="<?php echo url::param($G['path']['url'],'pages',$v['number']>1?$v['number']:null); ?>" <?php echo $v['current']?' class="on"':''; ?>><?php echo $v['number']; ?></a></li>
        <?php } ?>
        <li><a href="<?php echo url::param($G['path']['url'],'pages',$data['pages']['next']['number']>1?$data['pages']['next']['number']:null); ?>"><i class="fa fa-angle-right"></i></a></li>
        <li><a href="<?php echo url::param($G['path']['url'],'pages',$data['pages']['last']['number']>1?$data['pages']['last']['number']:null); ?>"><i class="fa fa-angle-double-right"></i></a></li>
      </ol>
    </div>
  </div>
</section>
<?php load::into('foot'); ?>