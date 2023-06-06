<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');
?>
<?php load::into('head'); ?>
<section class="main table">
  <article class="hint">
    <i class="fa fa-info-circle"></i>
    <p>检测本地文件是否被修改或篡改，可快速更新官方最新文件。</p>
  </article>
  <aside>
    <div>
      <table>
        <thead>
          <tr>
            <th>文件路径</th>
            <th>文件对比</th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>
  </aside>
</section>
<section class="refer">
  <a class="button green detect" href="javascript:;">
    <em class="fa fa-stethoscope"></em>
    <font>立即检测</font>
  </a>
  <span hide class="speed">检测进度：<b color="red"></b></span>
  <a class="button red tfa all"  hide href="javascript:;">
    <em class="fa fa-cloud-download"></em>
    <font>批量更新</font>
  </a>
</section>
<?php load::into('foot'); ?>