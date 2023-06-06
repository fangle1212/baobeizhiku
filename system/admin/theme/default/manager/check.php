<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');
?>
<?php load::into('head'); ?>
<form action="<?php echo url::mpf('manager','manager','check_add'); ?>" method="post" enctype="multipart/form-data">
<section class="main table tree" tree="checktable" cookie="checkTableTr">
  <aside>
    <div>
      <div class="head">
        <a class="button green selectall">
          <em class="fa fa-random"></em>
          <font><u>取消</u>全选</font>
        </a>
        <a class="button black treecheck" tree="checktable">
          <em class="fa fa-expand"></em>
          <em class="fa fa-compress"></em>
          <font>展开<b>·</b>折叠菜单</font>
        </a>
      </div>
      <table>
        <tbody>          
          <?php foreach($G['permit'] as $k=>$v){ ?>
          <?php if($G['manager']['level']==1 || (!$v['input'] || $data['pe'][$v['input']])){ ?>
          <tr level="<?php echo $v['level']; ?>" it="<?php echo $k; ?>">
            <td lv><?php echo $v['name']; ?></td>
            <td class="check">
			  <?php
			  if($v['check']){
				  $arr = array('R'=>'查看','A'=>'新增','M'=>'修改','D'=>'删除');
				  $param = array();
				  $check = str_split($v['check']);
				  foreach($check as $c){
            if($G['manager']['level']==1 || in_array($c,$data['pe'][$v['input']])){
              $param[$c] = $arr[$c]; 
            }
				  }
				  echo form::checkbox($v['input'],$data['permit'][$v['input']],null,$param);
			  }
			  ?>
            </td>
          </tr>
          <?php } ?>
          <?php } ?>
        </tbody>
      </table>
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