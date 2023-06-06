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
  <aside class="theme miniprogram">
    <div>
      <div class="head">
        <a class="button green" easy width="620" height="420" url="<?php echo url::mpf('miniprogram','miniprogram','edit',array('name'=>null)); ?>">
          <em class="fa fa-plus"></em>
          <font>新增模板</font>
        </a>
        <?php if(0){ ?>
        <a class="button blue tfa" href="<?php echo url::mpf('miniprogram','miniprogram','market'); ?>">
          <em class="fa fa-edit"></em>
          <font>模板市场</font>
        </a>
        <?php } ?>
        <a class="button red tfa" href="<?php echo url::mpf('miniprogram','renovation','init',array('name'=>$G['config']['miniprogram_theme'])); ?>">
          <em class="fa fa-edit"></em>
          <font>页面装修</font>
        </a>
      </div>
      <div class="list">
        <ul>
          <?php foreach($data['list'] as $v){ ?>
          <li>
            <aside>
              <p class="img">
                <ins>
                  <img src="<?php echo $v['image']; ?>" alt="<?php echo $v['name']; ?>" />
                </ins>
                <span>
                  <img src="<?php echo url::mpf('miniprogram','miniprogram','qrcode',array('name'=>$v['name'])); ?>" />
                  <b>手机扫一扫<br />查看预览</b>
                </span>
              </p>
              <p class="name">
                <?php if($G['config']['miniprogram_theme'] == $v['name']){ ?>
                <a>使用中</a>
                <?php }else{ ?>
                <a href="<?php echo url::mpf('miniprogram','miniprogram','modify',array('name'=>$v['name'])); ?>">启用</a>
                <?php } ?>
                <b><?php echo $v['title']; ?></b>
              </p>
              <p class="btn">
                <a class="btnfa green" href="<?php echo url::mpf('miniprogram','renovation','init',array('name'=>$v['name'])); ?>">
                  <em class="fa fa-cog" title="编辑"></em>
                </a>
                <a class="btnfa blue" name="修改模板" easy width="800" height="600" url="<?php echo url::mpf('miniprogram','miniprogram','edit',array('name'=>$v['name'])); ?>">
                  <em class="fa fa-pencil" title="修改"></em>
                </a>
                <?php if($v['name']==$G['config']['web_theme']){ ?>
                <a class="btnfa green" href="javascript:;">
                  <em class="fa fa-check-square-o" title="使用中"></em>
                </a>
                <?php } ?>
                <a class="btnfa red delete" url="<?php echo url::mpf('miniprogram','miniprogram','delete',array('name'=>$v['name'])); ?>">
                  <em class="fa fa-trash-o" title="删除"></em>
                </a>
              </p>
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
  </aside>
</section>
<?php load::into('foot'); ?>