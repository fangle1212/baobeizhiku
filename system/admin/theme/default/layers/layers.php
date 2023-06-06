<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');
?>
<?php load::into('head'); ?>
<form action="<?php echo url::mpf('layers','layers','modify'); ?>" method="post" enctype="multipart/form-data">
<section class="main table tree" tree="layer<?php echo $G['get']['core']; ?>stable" cookie="layers<?php echo $G['get']['core']; ?>TableTr">
  <aside>
    <div>
      <?php if(arrExist($G['get'],'series')){ ?>
      <div class="head">
        <a class="button green" easy url="<?php echo url::mpf('layers','layers','edit',array('series'=>$G['get']['series'])); ?>">
          <em class="fa fa-plus"></em>
          <font>添加内容</font>
        </a>
      </div>
      <?php } ?>
      <table>
        <tbody>
          <tr>
            <th><?php echo form::checkbox(null,null,null,array(null)); ?></th>
            <th width="58">排序</th>
            <th>模块 / 标题</th>
            <th width="88">显示</th> 
            <th>操作</th>
          </tr>
          <?php
		  $parent = 0;
          foreach($data as $v){
		  if(isset($v['ctrl'])){
          ?>
          <tr level="<?php echo $v['level']; ?>" it="<?php echo $parent.'000'; ?>">
            <td width="33"><?php echo form::checkbox(null,null,null,array(null)); ?></td>
            <td></td>
            <td lv colspan="2"><?php echo $v['title']; ?></td>
            <td width="155">
              <a class="button green tfa" easy url="<?php echo url::mpf('layers','layers','edit',array('series'=>$v['id'],'parent'=>$v['parent']?$parent:null)); ?>">
                <em class="fa fa-plus"></em>
                <font>添加内容</font>
              </a>
            </td>
          </tr>
          <?php
		  }else{
		  $parent = $v['id'];
          ?>
          <tr level="<?php echo $v['level']; ?>" it="<?php echo $v['id']; ?>">
            <td width="33"><?php echo form::checkbox('id',null,null,array($v['id']=>null)); ?></td>
            <td width="58">
			  <?php echo form::input("sort{$v['id']}",$v['sort'],null,'text',null); ?>
            </td>
            <td lv><?php echo $v['name']; ?></td>
            <td width="88">
			  <?php echo form::radio("display{$v['id']}",$v['display'],1,$G['option']['is'],array('color'=>'green')); ?>
            </td>
            <td width="155">
              <a class="btnfa blue" easy url="<?php echo url::mpf('layers','layers','edit',array('id'=>$v['id'],'series'=>$v['series'])); ?>">
                <em class="fa fa-pencil" title="修改"></em>
              </a>
              <a class="btnfa red delete" url="<?php echo url::mpf('layers','layers','delete',array('id'=>$v['id'])); ?>">
                <em class="fa fa-trash-o" title="删除"></em>
              </a>
            </td>
          </tr>
          <?php
          }
		  }
          ?>
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
  <a class="button red delcheck" url="<?php echo url::mpf('layers','layers','delete'); ?>">
    <em class="fa fa-trash-o"></em>
    <font>批量删除</font>
  </a>
</section> 
</form>
<?php load::into('foot'); ?>