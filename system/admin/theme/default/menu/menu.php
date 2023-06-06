<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');
?>
<?php load::into('head'); ?>
<form action="<?php echo url::mpf('menu','menu','modify'); ?>" method="post" enctype="multipart/form-data">
<section class="main table">
  <aside>
    <div>
      <div class="head">
        <a class="button green" easy width="880" height="580" url="<?php echo url::mpf('menu','menu','edit'); ?>">
          <em class="fa fa-plus"></em>
          <font>添加菜单</font>
        </a>
      </div>
      <table>
        <tbody>
          <tr>
            <th><?php echo form::checkbox(null,null,null,array(null)); ?></th>
            <th>排序</th>
            <th>标题</th>
            <th>类型</th>
            <th>值</th>
            <th>新窗口</th>
            <th>显示</th>
            <th>操作</th>
          </tr>
          <?php
          foreach($data as $v){
          ?>
          <tr>
            <td width="33"><?php echo form::checkbox('id',null,null,array($v['id']=>null)); ?></td>
            <td width="58">
			  <?php echo form::input("sort{$v['id']}",$v['sort'],null,'text',null); ?>
            </td>
            <td width="88"><?php echo $v['name']; ?></td>
            <td><?php echo $G['option']['menu'][$v['type']]; ?></td>
            <td>
			  <?php
			  	if($v['type']==0 && $items=page::items_one($v['value'])) echo "<a href='{$items['url']}' target='_blank'>{$items['name']}</a>";
			    else if($v['type']==2) echo "<a href='{$v['value']}' target='_blank'><img src='{$v['value']}' height=37 /></a>";
				else echo $v['value'];
		      ?>
            </td>
            <td width="88" bosscms>
			  <?php echo form::radio("target{$v['id']}",$v['target'],1,$G['option']['is']); ?>
            </td>
            <td width="88">
			  <?php echo form::radio("display{$v['id']}",$v['display'],1,$G['option']['is'],array('color'=>'green')); ?>
            </td>
            <td width="155">
              <a class="btnfa blue" easy name="修改菜单" width="880" height="580" url="<?php echo url::mpf('menu','menu','edit',array('id'=>$v['id'])); ?>">
                <em class="fa fa-pencil" title="修改"></em>
              </a>
              <a class="btnfa red delete" url="<?php echo url::mpf('menu','menu','delete',array('id'=>$v['id'])); ?>">
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
    <em class="fa fa-floppy-o"></em>
    <font>保存</font>
  </button>
  <a class="button red delcheck" url="<?php echo url::mpf('menu','menu','delete'); ?>">
    <em class="fa fa-trash-o"></em>
    <font>批量删除</font>
  </a>
</section> 
</form>
<?php load::into('foot'); ?>