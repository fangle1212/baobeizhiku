<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');
?>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0,minimal-ui">
  <title><?php echo $G['config']['admin_title']; ?></title><?php echo
html::link(load::common(null,'web',true).'font/font-awesome.css').
html::link(load::common('css/bosscms.css','admin',true)).
html::link(load::theme('css/'.BOSSCMS_MOLD.'.css','admin',true)).
html::link(load::theme('css/'.BOSSCMS_MOLD.'_'.BOSSCMS_PART.'.css','admin',true)).
html::script($G['path']['relative']."system/extend/ueditor/third-party/jquery-1.10.2.min.js").
html::link(url::upload($G['config']['icon']),'shortcut icon',array('type'=>'image/x-icon'));
if($G['copyright']=load::copyright()){?>
</head>

<body<?php } if(isset($G['body_class'])){ ?> class="<?php echo $G['body_class']; ?>"<?php } ?>>
<?php if(isset($G['navs1']) && count($G['navs1'])>1 && !arrExist($G,'get|navs1')){ ?>
  <section class="head1">
    <aside>
      <ul>
        <?php
		foreach($G['navs1'] as $v){
			if(!isset($v['hide'])){
		?>
        <li>
          <a<?php if(isset($v['active'])){ ?> class="active"<?php } ?> href="<?php echo url::mpf($v['mold'],$v['part']?$v['part']:$v['mold'],$v['func']?$v['func']:'init',$v['param']?$v['param']:array()); ?>"> 
			<span><?php echo $v['name']; ?></span>
          </a>
        </li>
        <?php
			}
		}
		?>
      </ul>
    </aside>
  </section>
<?php } ?>
<?php if(isset($G['navs0']) && !arrExist($G,'get|navs0')){ ?>
  <section class="head">
    <aside>
      <ul>
        <?php
		foreach($G['navs0'] as $v){
			if(!isset($v['hide'])){
		?>
        <li<?php if(isset($v['active'])){ ?> class="active"<?php } ?>>
          <a href="<?php echo url::mpf($v['mold'],$v['part']?$v['part']:$v['mold'],$v['func']?$v['func']:'init',$v['param']?$v['param']:array()); ?>">
            <em class="fa fa-caret-right"></em>
			<span><?php echo $v['name']; ?></span>
          </a>
        </li>
        <?php
			}
		}
		?>
      </ul>
    </aside>
  </section>
<?php } ?>
<?php if(isset($G['navs2']) && !arrExist($G,'get|navs2')){ ?>
  <section class="head sub">
    <aside>
      <ul>
        <?php
		foreach($G['navs2'] as $v){
			if(!isset($v['hide'])){
		?>
        <li<?php if(isset($v['active'])){ ?> class="active"<?php } ?>>
          <a href="<?php echo url::mpf($v['mold'],$v['part']?$v['part']:$v['mold'],$v['func']?$v['func']:'init',$v['param']?$v['param']:array()); ?>">
			<span><?php echo $v['name']; ?></span>
          </a>
        </li>
        <?php
			}
		}
		?>
      </ul>
    </aside>
  </section>
<?php } ?>