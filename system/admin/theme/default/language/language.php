<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');
?>
<?php load::into('head'); ?>
<form action="<?php echo url::mpf('language','language','modify'); ?>" method="post" enctype="multipart/form-data">
<section class="main table">
  <aside>
    <div>
      <div class="head">
        <a class="button green" easy width="800" height="500" url="<?php echo url::mpf('language','language','edit'); ?>">
          <em class="fa fa-plus"></em>
          <font>添加语言</font>
        </a>
      </div>
      <table>
        <tbody>
          <tr>
            <th><?php echo form::checkbox(null,null,null,array(null)); ?></th>
            <th>排序</th>
		    <th>国旗</th>
            <th>语言</th>
            <th>编号</th>
            <th>标识</th>
			<th>默认</th>
            <th>新窗口</th>
            <th>状态</th>
            <th>操作</th>
          </tr>
          <?php foreach($data as $k=>$v){ ?>
          <tr>
            <td width="33"><?php echo form::checkbox('id',null,null,array($v['id']=>null)); ?></td>
            <td width="58">
			  <?php echo form::input("sort{$v['id']}",$v['sort'],null,'text',null); ?>
            </td>
            <td width="88"><img rand cover src="<?php echo $v['image']; ?>" height="30" /></td>
            <td>
			  <span><?php echo $v['name']; ?></span>
			  <a class="fa fa-eye" href="<?php echo url::home($v['id']); ?>" title="<?php echo $v['name']; ?>" target="_blank"></a>
			</td>
            <td width="88"><?php echo $v['id']; ?></td>
            <td width="88"><?php echo $v['sign']; ?></td>
			<td width="118">
              <?php if($v['defaults']){ ?>
              <a class="btnfa blue">
                <em class="fa fa-check" title="已为默认"></em>
              </a>
              <?php }else{ ?>
              <a class="btnfa green isdefault" data-id="<?php echo $v['id']; ?>" data-url="<?php echo url::mpf('language','language','defaults'); ?>">
                <em class="fa fa-mouse-pointer" title="设为默认"></em>
              </a>
              <?php } ?>
			</td>
            <td width="88">
			  <?php echo form::radio("target{$v['id']}",$v['target'],0,$G['option']['is']); ?>
            </td>
            <td width="88">
			  <?php echo form::radio("display{$v['id']}",$v['display'],1,$G['option']['is'],array('color'=>'green')); ?>
            </td>
            <td width="155">
              <a class="btnfa blue" easy width="800" height="500" name="语言修改" url="<?php echo url::mpf('language','language','edit',array('id'=>$v['id'])); ?>">
                <em class="fa fa-pencil" title="修改"></em>
              </a>
              <a class="btnfa red delete" url="<?php echo url::mpf('language','language','delete',array('id'=>$v['id'])); ?>">
                <em class="fa fa-trash-o" title="删除"></em>
              </a>
            </td>
          </tr>
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