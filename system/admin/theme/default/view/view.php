<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');
?>
<?php
if(!session::get("view{$G['language']['id']}")){
	session::set("view{$G['language']['id']}", url::home(null, true));
}
?>
<?php load::into('head'); ?>
<header class="topnav">
  <ul>
    <li><a target="_blank" href="<?php echo url::mpf('view','view','page'); ?>"><em class="fa fa-unlink"></em>查看页面</a></li>
    <li><a target="page" href="<?php echo url::home(null, true); ?>"><em class="fa fa-pencil"></em>编辑首页</a></li>
    <?php if(isset($data['ctrl']['common'])){ ?>
    <li><a fixed target="edit" href="<?php echo url::mpf('view','view','edit',array('core'=>'common','eid'=>0)); ?>"><em class="fa fa-ticket"></em>公共设置</a></li>
    <?php } ?>
    <li><a href="javascript:document.getElementById('page').contentWindow.Citems();"><em class="fa fa-tasks"></em>当前栏目</a></li>
	<?php
	if(count($data['language'])>1){
		if(into::load_class('admin','iframe','iframe','new')->cover('language','R',true)){
	?>
	<li>
      <a href="javascript:;"><em class="fa fa-globe"></em>切换语言</a>
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
    <?php
		}
	}
	?>
    <li><a href="javascript:document.getElementById('page').contentWindow.location.reload(true);"><em class="fa fa-refresh"></em>刷新</a></li>
  </ul>
</header>
<section class="page">
  <iframe id="page" name="page" src="<?php echo session::get("view{$G['language']['id']}"); ?>"></iframe>
</section>
<section class="fixed">
  <div class="box">
    <span class="close">&times;</span>
    <span class="move"></span>
    <iframe name="edit"></iframe>
  </div>
</section>
<?php load::into('foot'); ?>
