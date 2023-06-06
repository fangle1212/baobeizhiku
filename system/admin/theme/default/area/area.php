<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');
?>
<?php load::into('head'); ?>
<form action="<?php echo url::mpf('area','area','modify'); ?>" method="post" enctype="multipart/form-data">
<section class="main table">
  <aside>
    <div>
      <?php if(!arrExist($G,'get|parent')){ ?>
      <div class="head">
        <a class="button green" easy="nofull" width="800" height="670" url="<?php echo url::mpf('area','area','import'); ?>">
          <em class="fa fa-plus"></em>
          <font>导入城市</font>
        </a>
      </div>
      <?php } ?>
      <table>
        <tbody>
          <tr>
            <th><?php echo form::checkbox(null,null,null,array(null)); ?></th>
            <th>编号</th>
            <th>名称</th>
            <th>域名</th>
            <th>下级城市</th> 
            <th>友情链接</th> 
            <th>显示</th> 
            <th>操作</th>
          </tr>
          <?php
          foreach($data['list'] as $v){
          ?>
          <tr>
            <td width="33"><?php echo form::checkbox('id',null,null,array($v['id']=>null)); ?></td> 
            <td width="108"><?php echo $v['sign']; ?></td> 
            <td width="98"><?php echo $v['name']; ?></td>
            <td><?php echo $v['domain']; ?> <a class="fa fa-eye" href="<?php echo $v['domain']; ?>" target="_blank"></a></td>
            <td width="118">
            <?php if($v['child']){ ?>
            <a class="btnfa green" width="1100" height="700" easy name="下级分站" url="<?php echo url::mpf('area','area','init',array('parent'=>$v['id'],'navs'=>1,'navs0'=>1,'navs1'=>1,'navs2'=>1)); ?>">
              <em class="fa fa-cog" title="下级"></em>
            </a>
            <?php } ?>
            </td>
            <td width="118">
            <a class="btnfa blue" easy name="友情链接" url="<?php echo url::mpf('link','link','init',array('area'=>$v['id'],'navs'=>1,'navs0'=>1,'navs1'=>1,'navs2'=>1)); ?>">
              <em class="fa fa-link" title="友链"></em>
            </a>
            </td> 
            <td width="88">
			  <?php echo form::radio("display{$v['id']}",$v['display'],1,$G['option']['is'],array('color'=>'green')); ?>
            </td> 
            <td width="155">
              <a class="btnfa blue" easy name="修改分站" width="800" height="500" url="<?php echo url::mpf('area','area','edit',array('id'=>$v['id'])); ?>">
                <em class="fa fa-pencil" title="修改"></em>
              </a>
              <a class="btnfa red delete" url="<?php echo url::mpf('area','area','delete',array('id'=>$v['id'])); ?>">
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
    </div>
  </aside>
</section>

<section class="refer">
  <button class="button ok" type="submit">
    <em class="fa fa-floppy-o"></em>
    <font>保存</font>
  </button>
  <a class="button red delcheck" url="<?php echo url::mpf('area','area','delete'); ?>">
    <em class="fa fa-trash-o"></em>
    <font>批量删除</font>
  </a>
  <a class="button green tfa clickcheck" easy url="<?php echo url::mpf('link','link','edit',array('area'=>'all')); ?>">
    <em class="fa fa-trash-o"></em>
    <font>批量友链</font>
  </a>
</section> 
</form>
<?php load::into('foot'); ?>