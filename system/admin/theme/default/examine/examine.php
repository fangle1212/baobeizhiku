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
    <p>该功能为系统提供安全、权限体检，通过全面体检来确保网站的安全和健康。操作完成后建议清除系统缓存。</p>
  </article>
  <aside>
    <div>
      <table>
        <tbody>
          <tr>
            <th>体检项目</th>
            <th>体检结果</th>
          </tr>
          <tr>
            <td width="388">域名https协议检测</td>
            <td><a examine color="blue" url="<?php echo url::mpf('examine','examine','ssl'); ?>">未检测</a></td>
          </tr>
          <tr>
            <td>文件夹权限检测</td>
            <td><a examine color="blue" url="<?php echo url::mpf('examine','examine','permission'); ?>">未检测</a></td>
          </tr>
          <tr>
            <td>后台文件夹检测</td>
            <td><a examine color="blue" url="<?php echo url::mpf('examine','examine','admin'); ?>">未检测</a></td>
          </tr>
          <tr>
            <td>安装文件检测</td>
            <td><a examine color="blue" url="<?php echo url::mpf('examine','examine','install'); ?>">未检测</a></td>
          </tr>
          <tr>
            <td>数据库结构检测</td>
            <td><a examine color="blue" url="<?php echo url::mpf('examine','examine','database'); ?>">未检测</a></td>
          </tr>
        </tbody>
      </table>
    </div>
  </aside>
</section>
<section class="refer">
  <a class="button green all">
    <em class="fa fa-hospital-o"></em>
    <font>立即体检</font>
  </a>
</section>
<?php load::into('foot'); ?>