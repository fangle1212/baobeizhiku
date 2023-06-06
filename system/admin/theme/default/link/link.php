<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');
?>
<?php load::into('head'); ?>
<form action="<?php echo url::mpf('link','link','modify'); ?>" method="post" enctype="multipart/form-data">
<section class="main table">
  <aside>
    <div>
      <div class="head">
        <a class="button green" easy width="880" height="580" url="<?php echo url::mpf('link','link','edit'); ?>">
          <em class="fa fa-plus"></em>
          <font>添加友链</font>
        </a>
      </div>
      <table>
        <tbody>
          <tr>
            <th><?php echo form::checkbox(null,null,null,array(null)); ?></th>
            <th>排序</th>
            <th>类型</th>
            <th>图片</th>
            <th>标题</th>
            <th>链接</th>
            <th>nofollow</th>
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
            <td width="58"><?php echo $G['option']['link'][$v['type']]; ?></td>
            <td width="88"><?php if($v['type']){ ?><img check src="<?php echo $v['image']; ?>" width="60" height="30" /><?php } ?></td>
            <td><?php echo $v['name']; ?></td>
            <td><?php echo $v['link']; ?></td>
            <td width="88">
			  <?php echo form::radio("nofollow{$v['id']}",$v['nofollow'],1,$G['option']['is'],array('color'=>'red')); ?>
            </td>
            <td width="88">
			  <?php echo form::radio("target{$v['id']}",$v['target'],0,$G['option']['is']); ?>
            </td>
            <td width="88">
			  <?php echo form::radio("display{$v['id']}",$v['display'],1,$G['option']['is'],array('color'=>'green')); ?>
            </td>
            <td width="155">
              <a class="btnfa blue" easy width="880" height="580" name="修改友链" url="<?php echo url::mpf('link','link','edit',array('id'=>$v['id'])); ?>">
                <em class="fa fa-pencil" title="修改"></em>
              </a>
              <a class="btnfa red delete" url="<?php echo url::mpf('link','link','delete',array('id'=>$v['id'])); ?>">
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
  <a class="button red delcheck" url="<?php echo url::mpf('link','link','delete'); ?>">
    <em class="fa fa-trash-o"></em>
    <font>批量删除</font>
  </a>
</section> 
</form>
<?php load::into('foot'); ?>