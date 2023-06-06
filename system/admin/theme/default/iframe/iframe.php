<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');
$icon = $_COOKIE['IframeIconOpen']?'icon':'';
$G['body_class'] = $G['config']['admin_theme_bgcolor'];
$iframe = into::load_class('admin','iframe','iframe','new');
?>
<?php load::into('head'); ?>
<header class="topnav <?php echo $icon; ?>">
  <div class="column">
    <ul>
      <?php foreach($data['navs'] as $k=>$v){ ?>
      <li class="nav<?php echo $k; ?>">
        <a href="javascript:;" title="<?php echo $v['name']; ?>">
          <i class="fa <?php echo $v['icon']; ?>"></i>
          <b><?php echo $v['name']; ?></b>
        </a>
      </li>
      <?php } ?>
      <li class="nav66 <?php echo $G['plugin_must']?'':'hide'; ?>">
        <a href="javascript:;" title="应用">
          <i class="fa fa-puzzle-piece"></i>
          <b>应用</b>
        </a>
      </li>
    </ul>
  </div>
  <div class="wrap">
    <ul>
      <li><a domain 
      <?php if($G['config']['domain']){ ?>
      target="_blank" href="<?php echo $G['config']['domain']; ?>"
      <?php }else{ ?>
      href="javascript:_alert('未设置站点域名');"
      <?php } ?>      
      >网站</a></li>
      <?php if($iframe->cover('view','R',true)){ ?>
      <li><a target="_blank" href="<?php echo url::mpf('view','view','init'); ?>">编辑</a></li>
      <?php } ?>
      <li class="cache">
        <a href="javascript:;">缓存</a>
        <ul>
          <li><a href="javascript:;" url="<?php echo url::mpf('clear','clear','cache',array('jsonmsg'=>1)); ?>">清除全部</a></li>
          <li><a href="javascript:;" url="<?php echo url::mpf('clear','clear','files',array('jsonmsg'=>1)); ?>">清除缓存文件</a></li>
          <li><a href="javascript:;" url="<?php echo url::mpf('clear','clear','thumbnail',array('jsonmsg'=>1)); ?>">清除缩略图</a></li>
        </ul>
      </li>
	  <?php if($iframe->cover('language','R',true)){ ?>
      <li>
        <a target="iframe" href="<?php echo url::mpf('language','language','init'); ?>">语言</a>
        <ul>
          <?php
          foreach($data['language'] as $v){
          ?>
          <li<?php if($v['id']==$G['language']['id']) echo ' class="on"'; ?>>
            <a href="<?php echo url::lang($G['path']['link'], $v['id']); ?>" title="<?php echo $v['name']; ?>">
              <img class="lang" src="<?php echo $v['image']; ?>" />
              <?php echo $v['name']; ?>
            </a>
          </li>
          <?php } ?>
        </ul>
      </li>
      <?php } ?>
	  <?php if($iframe->cover('feedback','R',true)){ ?>
      <li><a news="<?php echo into::load_class('admin','feedback','feedback','new')->reading(); ?>" href="<?php echo url::mpf('feedback','feedback','init'); ?>" target="iframe">消息</a></li>
      <?php } ?>
      <li>
        <span class="user">
          <img src="<?php echo $G['manager']['image']?$G['manager']['image']:load::common('img/use_img.jpg','admin',true); ?>" />
          <b><?php echo $G['manager']['alias']?$G['manager']['alias']:$G['manager']['username']; ?></b>
          <p><?php echo $G['option']['level'][$G['manager']['level']]; ?></p>
        </span>
        <ul>
          <li><a href="<?php echo url::mpf('home','home','init'); ?>" target="iframe"><em class="fa fa-home"></em>欢迎页</a></li>
          <?php if($iframe->cover('manager','R',true)){ ?>
          <li><a href="<?php echo url::mpf('manager','manager','init',array('edit'=>$G['manager']['id'])); ?>" target="iframe"><em class="fa fa-user"></em>账号设置</a></li>
          <?php } ?>
          <li><a href="javascript:;" class="setbgcolor"><em class="fa fa-tachometer"></em>切换主题</a></li>
          <li><a href="<?php echo url::mpf('login','login','logout'); ?>"><em class="fa fa-power-off"></em>退出登陆</a></li>
        </ul>
      </li>
    </ul>
  </div>
</header>
<section class="category <?php echo $icon; ?> bosscms">
  <div class="logo">
    <a href="<?php echo $G['path']['url']; ?>" title="<?php echo $G['config']['admin_title']; ?>">
      <img class="img" rand src="../system/admin/common/img/logo.png" />
      <img class="ico" rand src="../system/admin/common/img/logo_ico.png" />
      <span><?php echo $G['config']['admin_title']; ?></span>
    </a>
  </div>
  <div class="nav">
    <ul nav="88">
      <li>
        <a href="javascript:;">
          <em class="fa fa-home"></em>
          <font>后台管理</font>
          <i class="fa fa-caret-up"></i>
        </a>
        <ul>
          <li class="home"><a href="<?php echo url::mpf('home','home','init'); ?>" target="iframe">欢迎页</a></li>
          <?php if(into::load_class('admin','examine','examine','new')->cover('examine','R',true)){ ?>
          <li><a href="<?php echo url::mpf('examine','examine','init'); ?>" target="iframe">系统体检</a></li>
          <?php } ?>
          <?php if($iframe->cover('update','R',true)){ ?>
          <li update><a href="<?php echo url::mpf('update','update','init'); ?>" target="iframe">版本更新</a></li>
          <?php } ?>
        </ul>
      </li>
    </ul>
	<?php foreach($data['navs'] as $key=>$value){ ?>
    <ul nav="<?php echo $key; ?>">
	  <?php foreach($value['child'] as $val){ ?>
      <li>
        <a href="javascript:;">
          <em class="fa <?php echo $val['icon']; ?>"></em>
          <font><?php echo $val['name']; ?></font>
          <i class="fa fa-caret-up"></i>
        </a>
        <ul>
		  <?php foreach($val['child'] as $v){ ?>
          <li class="<?php echo $v['tag']; ?>">
            <a href="<?php echo url::mpf($v['mold'],$v['part']?$v['part']:$v['mold'],$v['func']?$v['func']:'init',$v['param']?$v['param']:array()); ?>" target="iframe"><?php echo $v['name']; ?></a>
          </li>
		  <?php } ?>
        </ul>
      </li>
	  <?php } ?>
    </ul>
	<?php } ?>
    <ul nav="66">
      <li>
        <a href="javascript:;">
          <em class="fa fa-puzzle-piece"></em>
          <font>应用软件</font>
          <i class="fa fa-caret-up"></i>
        </a>
        <ul>
          <?php foreach($G['plugin_must'] as $v){ ?>
          <li class="<?php echo $v['mold']; ?>">
            <a href="<?php echo url::mpf($v['mold'],$v['part']?$v['part']:$v['mold'],$v['func']?$v['func']:'init'); ?>" target="iframe"><?php echo $v['title']; ?></a>
          </li>
          <?php } ?>
        </ul>
      </li>
    </ul>
  </div>
  <?php if($G['authorize']['oem']){ ?>
  <div class="info">
    <span><?php echo $G['authorize']['name'].'：'.$G['authorize']['oem']; ?></span>
  </div>
  <?php } ?>
  <div class="btn">
    <button class="fa fa-outdent"></button>
  </div>
</section>
<section class="content <?php echo $icon; ?>">
  <iframe name="iframe" src="javascript:;"></iframe>
</section>
<?php load::into('foot'); ?>