<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');
?>
<?php load::into('head'); ?>
<section class="main table">
  <div class="market">
    <div class="cut">
      <span>软件搜索：</span>
      <form method="get" action="./">
        <?php echo form::input('lang',$G['get']['lang'],null,'hidden',array(),false); ?>
        <?php echo form::input('mold','software',null,'hidden',array(),false); ?>
        <?php echo form::input('part','software',null,'hidden',array(),false); ?>
        <?php echo form::input('func','init',null,'hidden',array(),false); ?>
        <?php echo form::input('search',$G['get']['search'],null,'text',array('required','placeholder'=>'请输入产品名称搜索')); ?>
        <button class="fa fa-search"></button>
      </form>
    </div>
    <div class="cut">
      <span>软件分类：</span>
      <ul></ul>
    </div>
    <div class="filter">
      <aside></aside>
    </div>
    <div class="list">
      <table>
        <thead>
          <tr>
            <th>软件名称</th>
            <th>开发商</th>
            <th>价格</th>
            <th>产品介绍</th>
          </tr>
        </thead>
        <tbody>          
          <tr style="display:none;">
            <td>
              <div class="vimg">
                <imgsrc="[image]" alt="[title]" />
                <span>
                  <b name="[name]">[title]</b>
                  <p>[description]</p>
                </span>
              </div>
            </td>
            <td>[author]</td>
            <td>
              <span class="fa fa-rmb money">[price]</span> / [buy_duration]
              <a remark href="javascript:_alert('[remark]','gold');" color="red" class="preferential">[优惠]</a>
            </td>
            <td><a href="[link]" target="_blank">查看详情</a></td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="pages">
      <ol></ol>
    </div>
  </div>
</section>
<?php load::into('foot'); ?>