<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');
?>
<?php if($data['ctrl']){ ?>
<aside>
  <?php
  $k=0;
  foreach($data['ctrl'] as $s){
  ?>
  <div class="ctrl <?php echo $k?'':'on'; $k++; ?>">
	<h3>
	  <em class="fa fa-caret-down"></em>
	  <em class="fa fa-caret-right"></em>
	  <strong><?php echo $s['title']; ?></strong>
	  <span><?php echo $s['description']; ?></span>
	</h3>
	<?php foreach($s['ctrl'] as $v){ ?>
	<dl <?php if($v['style']==31) echo 'class="item"'; else if($v['style']==2) echo 'class="edit"'; ?>>
	  <dt>
		<strong <?php if($v['description'] && !preg_match('/<\/\w+>/',$v['description'])){ ?>data="<?php echo $v['description']; ?>"<?php } ?>><?php echo $v['title']; ?></strong>
	  </dt>
	  <dd class="parts">
		<?php echo ctrl::style($v['style'],$v['name'],$data['param'][$v['name']],$v['value'],$v['param'],$v['title'],$v['attribute'],$v['ctrl']); ?>
		<?php if($v['description'] && preg_match('/<\/\w+>/',$v['description'])){ ?>
		<cite><?php echo $v['description']; ?></cite>
		<?php } ?>
	  </dd>
	</dl>
	<?php } ?>
  </div>
  <?php } ?>
</aside>
<?php } ?>