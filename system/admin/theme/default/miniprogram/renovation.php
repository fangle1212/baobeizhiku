<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');
?>
<?php load::into('head'); ?>
<section class="operation">
  <div class="fm">
    <a class="back" url="<?php echo url::mpf('miniprogram','miniprogram','init',array('name'=>null)); ?>">
      <i class="fa fa-arrow-left"></i>
      <b>返回</b>
    </a>
  </div>
  <div class="btn">
    <a class="button green" easy="nofull" width="308" height="308" url="<?php echo url::mpf('miniprogram','miniprogram','qrcode',array('name'=>$G['get']['name'],'body'=>'true')); ?>">
      <em class="fa fa-eye"></em>
      <font>预览</font>
    </a>
    <button class="button ok" type="submit">
      <em class="fa fa-floppy-o"></em>
      <font>保存</font>
    </button>
  </div>
</section>
<section class="main renovation">
  <div class="fast">
    <div class="kind">
      <a class="button blue tfa on" tag="module">
        <em class="fa fa-calendar"></em>
        <font>组件列表</font>
      </a>      
      <a class="button blue tfa" tag="diypage">
        <em class="fa fa-sliders"></em>
        <font>页面列表</font>
      </a>
    </div>
    <div class="module on">
      <div class="disting">
        <i class="fa fa-caret-down"></i>
        <b>常用组件</b>
      </div>
      <div class="assembly">
        <ul>
          <li>
            <a type="banner">
              <i class="fa fa-photo"></i>
              <b>海报图</b>
            </a>
          </li>
          <li>
            <a type="title">
              <i class="fa fa-trademark"></i>
              <b>标题栏</b>
            </a>
          </li>
          <li>
            <a type="icon">
              <i class="fa fa-dot-circle-o"></i>
              <b>按钮组</b>
            </a>
          </li>
          <li>
            <a type="img">
              <i class="fa fa-file-photo-o"></i>
              <b>单图</b>
            </a>
          </li>
          <li>
            <a type="imgs">
              <i class="fa fa-object-ungroup"></i>
              <b>多图</b>
            </a>
          </li>
          <li>
            <a type="content">
              <i class="fa fa-edit"></i>
              <b>富文本</b>
            </a>
          </li>
          <li>
            <a type="hr">
              <i class="fa fa-ellipsis-h"></i>
              <b>分割线</b>
            </a>
          </li>
          <li>
            <a type="search">
              <i class="fa fa-search"></i>
              <b>搜索</b>
            </a>
          </li>
          <li>
            <a type="notice">
              <i class="fa fa-volume-up"></i>
              <b>公告</b>
            </a>
          </li>
          <li>
            <a type="video">
              <i class="fa fa-film"></i>
              <b>视频</b>
            </a>
          </li>
          <li>
            <a type="map">
              <i class="fa fa-map-o"></i>
              <b>地图</b>
            </a>
          </li>
        </ul>
      </div>
      <div class="disting" bosscms>
        <i class="fa fa-caret-down"></i>
        <b>内容组件</b>
      </div>
      <div class="assembly">
        <ul>
          <li>
            <a type="product">
              <i class="fa fa-shopping-bag"></i>
              <b>产品</b>
            </a>
          </li>
          <li>
            <a type="news">
              <i class="fa fa-server"></i>
              <b>文章</b>
            </a>
          </li>
          <li>
            <a type="image">
              <i class="fa fa-newspaper-o"></i>
              <b>图片</b>
            </a>
          </li>
          <li>
            <a type="download">
              <i class="fa fa-download"></i>
              <b>下载</b>
            </a>
          </li>
          <li>
            <a type="feedback">
              <i class="fa fa-check-square-o"></i>
              <b>反馈</b>
            </a>
          </li>
        </ul>
      </div>
    </div>
    <div class="diypage">
      <h3>
        <i class="fa fa-crosshairs"></i>
        <b>全部页面</b>
      </h3>
      <ul></ul>
      <a class="add">+ 新增页面</a>
    </div>
  </div>
  <div class="phone">
    <div class="mob">
      <div class="topbar" type="top_bar"></div>
      <div class="content win">
        <div class="conbar"></div>
      </div>
      <div class="cutbar" type="cut_bar"></div>
      <div class="tabbar" type="tab_bar"></div>
    </div>
  </div>
  <div class="design"></div>
</section>
<?php echo html::link("{$G['path']['relative']}system/admin/miniprogram/module/top_bar/top_bar.css"); ?>
<?php echo html::link("{$G['path']['relative']}system/admin/miniprogram/module/tab_bar/tab_bar.css"); ?>
<script>
window.$name = '<?php echo $data['name']; ?>',
window.$diypage = '<?php echo $data['diypage']; ?>',
window.jsonPage = <?php echo $data['jsonPage']; ?>,
window.jsonCtrl = <?php echo $data['jsonCtrl']; ?>;
</script>
<?php echo html::script("{$G['path']['relative']}system/extend/ueditor/third-party/swiper/swiper.jquery.min.js"); ?>
<?php echo html::script("{$G['path']['relative']}system/extend/ueditor/third-party/html2canvas/html2canvas.min.js"); ?>
<?php load::into('foot'); ?>