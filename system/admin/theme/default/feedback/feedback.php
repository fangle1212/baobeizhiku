<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');
?>
<?php load::into('head'); ?>
<form action="<?php echo url::mpf('feedback','feedback','modify'); ?>" method="post" enctype="multipart/form-data">
<section class="main table">
  <aside>
    <div>
      <table>
        <tbody>
          <tr>
            <th><?php echo form::checkbox(null,null,null,array(null)); ?></th>
            <?php
			$form = json::decode(arrExist($data['config'],'feedback_form'));
			foreach($data['form'] as $v){
			if(in_array($v['id'],$form)){
			?>
            <th><?php echo $v['title']; ?></th>
            <?php
			}
			}
			?>
            <th>提交时间</th>
            <th>状态</th>
            <th>操作</th>
          </tr>
          <?php
          foreach($data['list'] as $v){
		  $param = json::decode($v['param']);
          ?>
          <tr>
            <td width="33"><?php echo form::checkbox('id',null,null,array($v['id']=>null)); ?></td>
            <?php
			foreach($data['form'] as $f){
			if(in_array($f['id'],$form)){
			$pam = arrExist($param,'params'.$f['id']);
			$val = json::decode($pam);
			?>
            <td><?php echo $val?implode(',',$val):$pam; ?></td>
            <?php
			}
			}
			?>
            <td width="198"><?php echo date('Y-m-d H:i:s',$v['ctime']); ?></td>
            <td width="88">
			  <?php echo form::radio("reading{$v['id']}",$v['reading'],0,$G['option']['reading'],array('color'=>'green')); ?>
            </td>
            <td width="155">
              <a class="btnfa blue" name="查看反馈信息" easy width="770" height="500" url="<?php echo url::mpf('feedback','feedback','edit',array('id'=>$v['id'])); ?>">
                <em class="fa fa-pencil" title="查看"></em>
              </a>
              <a class="btnfa red delete" url="<?php echo url::mpf('feedback','feedback','delete',array('id'=>$v['id'])); ?>">
                <em class="fa fa-trash-o" title="删除"></em>
              </a>
            </td>
          </tr>
          <?php
          }
          ?>
          <tr>
            <td colspan="<?php echo count($data['form'])+4; ?>">
              <ol class="pages">
                <li><a href="<?php echo $data['pages']['first']['url']; ?>"><i class="fa fa-angle-double-left"></i></a></li>
                <li><a href="<?php echo $data['pages']['prev']['url']; ?>"><i class="fa fa-angle-left"></i></a></li>
                <?php foreach($data['pages']['list'] as $v){ ?>
                <li><a href="<?php echo $v['url']; ?>" <?php echo $v['current']?' class="on"':''; ?>><?php echo $v['number']; ?></a></li>
                <?php } ?>
                <li><a href="<?php echo $data['pages']['next']['url']; ?>"><i class="fa fa-angle-right"></i></a></li>
                <li><a href="<?php echo $data['pages']['last']['url']; ?>"><i class="fa fa-angle-double-right"></i></a></li>
              </ol>
            </td>
          </tr>
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
  <a class="button red delcheck" url="<?php echo url::mpf('feedback','feedback','delete'); ?>">
    <em class="fa fa-trash-o"></em>
    <font>批量删除</font>
  </a>
</section> 
</form>
<?php load::into('foot'); ?>