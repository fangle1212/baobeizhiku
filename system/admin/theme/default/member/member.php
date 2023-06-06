<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');
?>
<?php load::into('head'); ?>
<form action="<?php echo url::mpf('member','member','modify'); ?>" method="post" enctype="multipart/form-data">
<section class="main table">
  <aside>
    <div>
      <div class="head">
        <a class="button green" easy width="780" height="560" url="<?php echo url::mpf('member','member','edit'); ?>">
          <em class="fa fa-plus"></em>
          <font>添加会员</font>
        </a>
      </div>
      <table>
        <tbody>
          <tr>
            <th><?php echo form::checkbox(null,null,null,array(null)); ?></th>
            <th>账号ID</th>
            <th>会员账号</th>
            <th>最后登陆时间</th>
            <th>最后登陆IP</th>
            <th>登录次数</th>
            <th>状态</th>
            <th>操作</th>
          </tr>
          <?php
          foreach($data['list'] as $v){
          ?>
          <tr>
            <td width="33"><?php echo form::checkbox('id',null,null,array($v['id']=>null)); ?></td>
            <td width="88"><?php echo $v['id']; ?></td>
            <td><?php echo $v['username'];  if($v['open']==-1){ ?>（邮箱验证中）<?php } ?></td>
            <td><?php echo $v['ltime']>1e9?date('Y-m-d H:i:s',$v['ltime']):''; ?></td>
            <td><?php echo $v['ip']; ?></td>
            <td><?php echo $v['frequency']; ?></td>
            <td width="98">
			  <?php echo form::radio("open{$v['id']}",$v['open'],1,$G['option']['open'],array('color'=>'green')); ?>
            </td>
            <td width="155">
              <a class="btnfa blue" easy name="修改会员" width="780" height="560" url="<?php echo url::mpf('member','member','edit',array('id'=>$v['id'])); ?>">
                <em class="fa fa-pencil" title="修改"></em>
              </a>
              <a class="btnfa red delete" url="<?php echo url::mpf('member','member','delete',array('id'=>$v['id'])); ?>">
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
</section> 
</form>
<?php load::into('foot'); ?>