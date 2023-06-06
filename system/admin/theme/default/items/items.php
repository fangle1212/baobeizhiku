<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');
?>
<?php load::into('head'); ?>
<form action="<?php echo url::mpf('items','items','modify'); ?>" method="post" enctype="multipart/form-data">
<section class="main table tree" tree="itemstable" cookie="itemsTableTr">
  <aside>
    <div>
      <div class="head">      
        <a class="button green" easy url="<?php echo url::mpf('items','items','edit'); ?>">
          <em class="fa fa-plus"></em>
          <font>添加一级栏目</font>
        </a>  
        <a class="button black treecheck" tree="itemstable">
          <em class="fa fa-expand"></em>
          <em class="fa fa-compress"></em>
          <font>展开<b> · </b>折叠栏目</font>
        </a>
      </div>
      <table>
        <tbody>
          <tr>
            <th><?php echo form::checkbox(null,null,null,array(null)); ?></th>
            <th>排序</th>
            <th>栏目名称</th>
            <th>栏目类型</th>
            <th>栏目目录</th> 
            <th>顶部显示</th>
            <th>底部显示</th>
            <th>新窗口</th>
            <th>显示</th>
            <th>子栏目</th> 
            <th>操作</th>
          </tr>
          <?php
          foreach($data['list'] as $v){
          ?>
          <tr level="<?php echo $v['level']; ?>" it="<?php echo $v['id']; ?>">
            <td width="33" title="栏目编号： <?php echo $v['id']; ?>"><?php echo form::checkbox('id',null,null,array($v['id']=>null)); ?></td>
            <td width="58">
			  <?php echo form::input("sort{$v['id']}",$v['sort'],null,'text',null); ?>
            </td>
            <td lv><?php echo $v['name']; ?></td>
            <td><?php echo $G['option']['type'][$v['type']]; ?></td>
            <td>
              <a href="<?php echo url::items($v); ?>" target="_blank">
			    <?php echo $v['type']==9?$v['link']:$v['folder']; ?>
              </a>
            </td> 
            <td width="88">
			  <?php echo form::radio("head{$v['id']}",$v['head'],0,$G['option']['is'],array('color'=>'green')); ?>
            </td>
            <td width="88">
			  <?php echo form::radio("foot{$v['id']}",$v['foot'],0,$G['option']['is']); ?>
            </td>
            <td width="88">
			  <?php echo form::radio("target{$v['id']}",$v['target'],0,$G['option']['is'],array('color'=>'green')); ?>
            </td>
            <td width="88">
			  <?php echo form::radio("display{$v['id']}",$v['display'],1,$G['option']['is']); ?>
            </td>
            <td width="88">
              <?php if($v['type']!=0 && $v['level']<$data['max']){?>
              <a class="btnfa green" easy name="添加子栏目" url="<?php echo url::mpf('items','items','edit',array('parent'=>$v['id'])); ?>">
                <em class="fa fa-plus" title="添加"></em>
              </a>
              <?php } ?>
            </td>
            <td width="155">
              <a class="btnfa blue" easy name="修改栏目" url="<?php echo url::mpf('items','items','edit',array('id'=>$v['id'])); ?>">
                <em class="fa fa-pencil" title="修改"></em>
              </a>
              <a class="btnfa red delete" url="<?php echo url::mpf('items','items','delete',array('id'=>$v['id'])); ?>">
                <em class="fa fa-trash-o" title="删除"></em>
              </a>
            </td>
          </tr>
          <?php
          }
          ?> 
        </tbody>
      </table>
    </div>
  </aside>
</section>
<section class="refer">
  <button class="button ok" type="submit">
    <em class="fa fa-floppy-o fa-bosscms"></em>
    <font>保存</font>
  </button>
  <a class="button red delcheck" url="<?php echo url::mpf('items','items','delete'); ?>">
    <em class="fa fa-trash-o"></em>
    <font>批量删除</font>
  </a>
</section> 
</form>
<?php load::into('foot'); ?>