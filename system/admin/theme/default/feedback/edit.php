<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');
?>
<?php load::into('head'); ?>
<section class="main table nomrgbot">
  <aside>
    <div>
      <table>
        <tbody>
          <tr>
            <th>标题</th>
            <th>内容</th>
          </tr>
          <?php foreach($data['form'] as $v){ ?>
          <tr>
            <td width="178"><?php echo $v['title']; ?></td>
            <td><?php echo arrExist($data['param'],'params'.$v['id']); ?></td>
          </tr>
          <?php
          }
          ?>
        </tbody>
      </table>
    </div>
  </aside>
</section>

<form action="<?php echo url::mpf('feedback','feedback','add'); ?>" method="post" enctype="multipart/form-data">
<section class="main form">
  <aside>
    <div>
      <h2>
        <strong>反馈设置</strong>
      </h2>
      <dl>
        <dt>
          <strong>管理员回复</strong> 
        </dt>
        <dd>
          <?php echo form::textarea('reply',$data['feedback']['reply'],null,array('placeholder'=>'请输入回复信息！')); ?>
        </dd>
      </dl>
      <dl>
        <dt>
          <strong>是否显示</strong>
        </dt>
        <dd>
          <?php echo form::radio('display',$data['feedback']['display'],0,$G['option']['display']); ?>
        </dd>
      </dl>
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