<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');
?>
<?php load::into('head'); ?>
<section class="main form">
  <article class="hint">
    <b>温馨提示:</b>
    <p> 1、升级前请做好网站与数据的备份。</p>
    <p> 2、升级过程中请不要关闭浏览器，尽量在访客少时候升级。</p>
    <p> 3、如果您网站开启了宝塔加固或防篡改程序功能，请先关闭后再进行升级。</p>
  </article>
  <aside>
	<div>
	  <h2>
		<strong>检测更新</strong>
	  </h2>
      <div class="text">
        <div class="version">
          <p color="green">当前版本：<span class="old"><?php echo $G['config']['version']; ?></span></p>
          <p hide><a href="#" color="red" target="_blank">更新版本：<span class="new"></span></a></p>
        </div>
        <div class="update" hide><h3>当前已经为最新版本，无需更新！</h3></div>
      </div>
	</div>
  </aside>
</section>
<section class="refer">
  <button class="button green ce">
    <em class="fa fa-spinner"></em>
    <font>立即检测</font>
  </button>
  <button class="button ok up" hide>
    <em class="fa fa-refresh"></em>
    <font>立即更新</font>
  </button>
  <span class="prompt" color="blue"></span>
</section>
<?php load::into('foot'); ?>