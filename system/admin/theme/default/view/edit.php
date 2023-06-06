<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');
?>
<?php load::into('head'); ?>
<form action="<?php echo url::mpf('view','view','add',array('dparam'=>urlencode($G['dparam']))); ?>" method="post" enctype="multipart/form-data">
<?php global $aE; $aE=isset($data)?$data:null; ?>
<section class="main form"> 
  <?php if($data['ctrl']){ ?>
  <aside>
	<?php
	foreach($data['ctrl'] as $core=>$series){
		if($series){
	?>
	<div>
	  <?php
	  $k=0;
	  foreach($series as $s){
	  ?>
      <div class="ctrl <?php echo $k?'':'on'; $k++; ?>">
        <h3>
          <em class="fa fa-caret-down"></em>
          <em class="fa fa-caret-right"></em>
		  <strong><?php echo $s['title']; ?></strong>
          <span><?php echo $s['description']; ?></span>
        </h3>
		<?php foreach($s['ctrl'] as $v){ ?>
        <dl>
          <dt>
            <strong <?php if($v['description']){ ?>data="<?php echo $v['description']; ?>"<?php } ?>><?php echo $v['title']; ?></strong>
          </dt>
          <dd>
            <?php echo ctrl::complex(arrExist($G,'get|eid'), $core, $v, aE('items'), $data); ?>
          </dd>
        </dl>
        <?php } ?>
      </div>
	  <?php } ?>
	</div>
	<?php
    	}
	}
	?>
  </aside>
  <?php } ?>
</section>
<section class="refer">
  <button class="button ok" type="submit">
    <em class="fa fa-floppy-o"></em>
    <font>保存</font>
  </button>
</section>
</form>
<?php load::into('foot'); ?>