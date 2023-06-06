<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');
$type = $G['get']['type'];
?>
<?php load::into('head'); ?>
<?php echo $G['navsub']; ?>
<section class="main table">
  <aside>
    <div>
	  <?php if(arrExist($G['get'],'items')){ ?>
      <div class="head">
        <a class="button green" easy url="<?php echo url::mpf('group','group','edit'); ?>">
          <em class="fa fa-plus"></em>
          <font>添加内容</font>
        </a>
        <form class="search" action="./">
          <?php foreach($G['get'] as $k=>$v) echo form::input($k,urlencode($v),null,'hidden',array(),false); ?>
          <?php echo form::input('keyword',stripslashes($data['keyword']),null,'text',array('placeholder'=>'请输入搜索关键词')); ?>
          <button class="fa fa-search"></button>
        </form>
      </div>
      <?php } ?>
	  <form id="group" action="<?php echo url::mpf('group','group','modify'); ?>" method="post" enctype="multipart/form-data">
      <table>
        <tbody>
          <tr>
            <th><?php echo form::checkbox(null,null,null,array(null)); ?></th>
            <th>排序</th>
            <th>标题</th>
            <th>更新时间</th>
            <th>是否推荐</th>
            <th>是否置顶</th>
            <th>操作</th>
          </tr>
          <?php
          foreach($data['list'] as $v){
          ?>
          <tr>
            <td width="33" title="内容编号： <?php echo $v['id']; ?>"><?php echo form::checkbox('id',null,null,array($v['id']=>null)); ?></td>
            <td width="58">
			  <?php echo form::input("sort{$v['id']}",$v['sort'],null,'text',null); ?>
            </td>
            <td>
			  <?php echo $v['name']; ?>
			  <?php if($v['image']){ ?>
              <a class="fa fa-image" href="<?php echo url::upload($v['image']); ?>" target="_blank"></a>
              <?php } ?>
              <a class="fa fa-eye" href="<?php echo $v['url']; ?>" target="_blank"></a>
            </td>
            <td width="198"><?php echo date('Y-m-d H:i:s',$v['mtime']); ?></td>
            <td width="78">
			  <?php echo form::radio("recommend{$v['id']}",$v['recommend'],0,$G['option']['is']); ?>
            </td>
            <td width="78">
			  <?php echo form::radio("top{$v['id']}",$v['top'],0,$G['option']['is'],array('color'=>'green')); ?>
            </td>
            <td width="155">
              <a class="btnfa blue" easy name="修改内容" url="<?php echo url::mpf('group','group','edit',array('id'=>$v['id'])); ?>">
                <em class="fa fa-pencil" title="修改"></em>
              </a>
              <a class="btnfa red delete" url="<?php echo url::mpf('group','group','delete',array('id'=>$v['id'])); ?>">
                <em class="fa fa-trash-o" title="删除"></em>
              </a>
            </td>
          </tr>
          <?php
          }
          ?>
          <tr>
            <td colspan="8">
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
	  </form>
    </div>
  </aside>
</section>


<section class="refer">
  <button form="group" class="button ok" type="submit">
    <em class="fa fa-floppy-o"></em>
    <font>保存</font>
  </button>
  <a class="button green tfa clickcheck" width="680" height="240" name="复制到栏目" easy="nofull" url="<?php echo url::mpf('group','group','paste',array('action'=>'copys')); ?>">
    <em class="fa fa-files-o"></em>
    <font>复制到</font>
  </a>
  <a class="button blue tfa clickcheck" width="680" height="240" name="移动到栏目" easy="nofull" url="<?php echo url::mpf('group','group','paste',array('action'=>'move')); ?>">
    <em class="fa fa-files-o"></em>
    <font>移动到</font>
  </a>
  <a class="button red delcheck" url="<?php echo url::mpf('group','group','delete'); ?>">
    <em class="fa fa-trash-o"></em>
    <font>批量删除</font>
  </a>
</section>
<?php load::into('foot'); ?>