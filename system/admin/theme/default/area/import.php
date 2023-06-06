<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');
?>
<?php load::into('head'); ?>
<form action="<?php echo url::mpf('area','area','put'); ?>" method="post" enctype="multipart/form-data">
<?php global $aE; $aE=isset($data)?$data:null; ?>
<section class="main form">
  <aside>
    <div>
      <h2>
        <strong>导入城市</strong>
      </h2>
      <dl>
        <dt>
          <strong>城市分级</strong>
        </dt>
        <dd>
          <?php echo form::checkbox('level','[1,2]',null,array(1=>'省级',2=>'市级',3=>'区县级')); ?>
        </dd>
      </dl>
      <dl>
        <dt>
          <strong>城市列表</strong>
        </dt>
        <dd class="level">
          <?php echo form::select('area',$data['id'],null,$data['area'],array('width'=>'80%','multiple')); ?>
        </dd>
      </dl>
    </div>
  </aside>
</section>
<section class="refer">
  <button class="button ok" type="submit">
    <em class="fa fa-floppy-o"></em>
    <font>保存</font>
  </button>
</section>  
</form>
<?php load::into('foot'); ?>