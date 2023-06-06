<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');
?>
<?php load::into('head'); ?>
<section class="main table bind">
  <article class="hint">
    <i class="fa fa-info-circle"></i>
    <p>请选择你需要安装到本站的软件产品</p>
  </article>
  <aside>
	<div>
      <table>
        <tbody>
          <tr>
            <th>订单号</th>
            <th>产品名称</th>
            <th>交易时间</th>
            <th>操作</th>
          </tr>
          <?php foreach($data as $v){ ?>
          <tr>
            <td width="168"><?php echo $v['orders'] ?></td>
            <td><?php echo $v['name'] ?></td>
            <td width="188"><?php echo $v['time'] ?></td>
            <td width="88"><a class="button green tfa auth" url="<?php echo url::mpf('template','market','bind',array('orders'=>$v['orders'])); ?>"><em class="fa fa-check"></em><font>授权</font></a></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </aside>
</section>
<?php load::into('foot'); ?>