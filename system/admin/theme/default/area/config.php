<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');
?>
<?php load::into('head'); ?>
<form action="<?php echo url::mpf('area','config','add'); ?>" method="post" enctype="multipart/form-data">
<?php global $aE; $aE=$G['config']; ?>
<section class="main form tab">
  <aside>
    <div>
      <h2>
        <strong>基础设置</strong>
      </h2>
      <dl>
        <dt>
          <strong>功能开关</strong>
        </dt>
        <dd>
          <?php echo form::radio('area_open',aE('area_open'),0,$G['option']['open']); ?>
          <cite>城市分站功能开关</cite>
        </dd>
      </dl>
      <dl>
        <dt>
          <strong>添加名称</strong>
        </dt>
        <dd>
          <?php echo form::select('area_name_type',aE('area_name_type'),'["1","2","3","4","5","6"]',array('栏目名称','栏目描述','简介内容','新闻、产品、图片、下载标题','新闻、产品、图片、下载描述','新闻、产品、图片、下载内容','其他文本内容'),array('width'=>'50%','multiple')); ?>
          <cite>选择需要添加分站城市名称的项目</cite>
        </dd>
      </dl>
      <dl>
        <dt>
          <strong>详情分站</strong>
        </dt>
        <dd>
          <?php echo form::radio('area_detail_open',aE('area_detail_open'),0,$G['option']['open'],array('color'=>'green')); ?>
          <cite>产品、新闻、图片、下载的详情页是否需要进行城市分站；关闭则分站的详情页链接都跳转至主站。</cite>
        </dd>
      </dl>
      <dl>
        <dt>
          <strong>SiteMap</strong>
        </dt>
        <dd>
          <?php echo form::radio('area_sitemap_open',aE('area_sitemap_open'),0,$G['option']['open']); ?>
          <cite>是否将城市分站列表链接导入SiteMap站点地图文件</cite>
        </dd>
      </dl>
    </div>
  </aside>

  <aside>
    <div>
      <h2>
        <strong>分站列表</strong>
      </h2>
      <dl>
        <dt>
          <strong>启用列表</strong>
        </dt>
        <dd>
          <?php echo form::radio('area_foot_open',aE('area_foot_open'),0,$G['option']['open']); ?>
          <cite>开启显示城市分站列表</cite>
        </dd>
      </dl>
      <dl>
        <dt>
          <strong>显示方式</strong>
        </dt>
        <dd>
          <?php echo form::radio('area_foot_show',aE('area_foot_show'),'0',array('全部显示','分级显示'),array('no')); ?>
          <cite>全部显示：显示所有{省/市/区县级}城市<br />分级显示：显示同等级{省级、市级、区级}的分站列表</cite>
        </dd>
      </dl>
      <dl>
        <dt>
          <strong>插入位置</strong>
        </dt>
        <dd>
          <?php echo form::textarea('area_foot_insert',aE('area_foot_insert'),'',array('width6','height1','placeholder'=>'请输入插入位置的代码')); ?>
          <cite>城市分站列表插入前台的位置；不填写则显示于网站底部；注：添加至前端页面html代码的指定位置前面</cite>
        </dd>
      </dl>
      <dl>
        <dt>
          <strong>栏目类型</strong>
        </dt>
        <dd>
          <?php echo form::select('area_foot_type',aE('area_foot_type'),'0',$data['typearr'],array('width'=>'30%','multiple')); ?>
          <cite>选择需要显示分站列表的栏目类型</cite>
        </dd>
      </dl>
    </div>
  </aside>
    
  <aside>
    <div>
      <h2>
        <strong>独立内容</strong>
      </h2>
      <dl>
        <dt>
          <strong>插入位置</strong>
        </dt>
        <dd>
          <?php echo form::textarea('area_insert',aE('area_insert'),'<footer',array('width6','height1','placeholder'=>'请输入插入位置的代码')); ?>
          <cite>各城市的独立内容插入前台的位置；注：添加至前端页面html代码的指定位置前面</cite>
        </dd>
      </dl>
      <dl>
        <dt>
          <strong>显示栏目</strong>
        </dt>
        <dd>
          <?php echo form::select('area_items',aE('area_items'),'["88888"]',$data['subarr'],array('width'=>'60%','multiple')); ?>
          <cite>选择需要显示独立内容的栏目</cite>
        </dd>
      </dl>
    </div>
  </aside>
    
  <aside>
    <div>
      <h2>
        <strong>URL设置</strong>
      </h2>
      <dl>
        <dt>
          <strong>链接模式</strong>
        </dt>
        <dd>
          <?php echo form::radio('area_link_type',aE('area_link_type'),0,array('二级目录模式','二级域名模式'),array('no')); ?>
          <cite>二级目录模式：开启伪静态后，城市分站的链接地址使用“<a href="./#mpf=site" target="_blank">站点域名</a>”下的二级目录模式访问；如使用该模式可配置链接地址规则<br />二级域名模式：多个二级域名绑定不同城市分站链接地址；如使用该模式请对域名进行泛解析</cite>
        </dd>
      </dl>
      <dl area_link_type <?php if(aE('area_link_type')) echo 'hide'; ?>>
        <dt>
          <strong>首页规则</strong>
        </dt>
        <dd>
          <?php echo form::input('area_rule_home',aE('area_rule_home'),'zq-[area]','text',array('required','width2')); ?>
          <cite>开启伪静态后，首页地址会插入该分站规则<br />规则参数：地域编号 [area]</cite>
        </dd>
      </dl>
      <dl area_link_type <?php if(aE('area_link_type')) echo 'hide'; ?>>
        <dt>
          <strong>栏目规则</strong>
        </dt>
        <dd>
          <?php echo form::input('area_rule_folder',aE('area_rule_folder'),'[folder]-[area]','text',array('required','width3')); ?>
          <cite>开启伪静态后，站点页面地址中栏目文件夹部分的分站替换规则<br />规则参数：栏目文件夹 [folder] 、 地域编号 [area]</cite>
        </dd>
      </dl>
      <dl area_link_type1 <?php if(!aE('area_link_type')) echo 'hide'; ?>>
        <dt>
          <strong>域名协议</strong>
        </dt>
        <dd>
          <?php echo form::radio('area_link_scheme',aE('area_link_scheme'),'http',array('http'=>'http','https'=>'https'),array('no')); ?>
          <cite>默认为http协议，如果二级域名配置了SSL证书，请切换为https协议</cite>
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