<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');
?>
<?php load::into('head'); ?>
<form action="<?php echo url::mpf('items','items','add'); ?>" method="post" enctype="multipart/form-data">
<?php global $aE; $aE=isset($data)?$data:null; $type=aE('type'); ?>
<section class="main form tab">
  <aside>
	<div>
	  <h2>
		<strong>基础设置</strong>
	  </h2>
	  <dl>
		<dt>
		  <strong>栏目名称</strong>
		</dt>
		<dd>
		  <?php echo form::input('name',aE('name'),null,'text',array('width5','required','placeholder'=>'请输入栏目名称')); ?>
		</dd>
	  </dl>
      <dl>
		<dt>
		  <strong>栏目类型</strong>
		</dt>
		<dd>
		  <?php echo form::select('type',$type,null,$G['option']['type'],array('width'=>'20%','required','placeholder'=>'请选择栏目类型','maxheight'=>888)); ?>
          <cite>选择栏目类型，不同类型页面显示效果不同</cite>
		</dd>
	  </dl>
	  <?php
	  foreach($G['pass']['type'] as $k=>$v){
	  if(!isset($data['page'][$k])){
		  $data['page'][$k] = array();
	  }
	  $hide = $v==$type?'':'hide';
	  ?>
	  <dl <?php echo 'tm'.count($data['page'][$k]); ?> <?php echo $hide; ?> theme <?php echo "type".$v; ?>>
		<dt>
		  <strong><?php echo $G['option']['type'][$v]; ?>模板</strong>
		</dt>
		<dd>
		  <?php echo form::select("theme{$v}",aE("theme"),null,$data['page'][$k],array('width'=>'30%','first','folder'=>$k,'placeholder'=>'请选择模板')); ?>
          <cite>选择不同的页面模板，查看对应栏目时可看到不同的主题风格</cite>
		</dd>
	  </dl>
	  <?php
	  if(in_array($v,array(2,3,4,5))){
	  if(!isset($data['page'][$k.'_detail'])){
		  $data['page'][$k.'_detail'] = array();
      }
	  ?>
	  <dl <?php echo 'tm'.count($data['page'][$k.'_detail']); ?> <?php echo $hide; ?> theme <?php echo "type".$v; ?>>
		<dt>
		  <strong><?php echo $G['option']['type'][$v]; ?>详情模板</strong>
		</dt>
		<dd>
		  <?php echo form::select("themes{$v}",aE("themes"),null,$data['page'][$k.'_detail'],array('width'=>'30%','first','placeholder'=>'请选择模板')); ?>
          <cite>选择不同的页面模板，查看对应栏目时可看到不同的主题风格</cite>
		</dd>
	  </dl>
	  <?php
	  }}
	  ?>
      <dl link <?php if($type==9) echo 'hide'; ?>>
		<dt>
		  <strong>栏目目录</strong>
		</dt>
		<dd>
		  <?php echo form::input('folder',aE('folder'),null,'text',array('width2',$type==9?'':'required','placeholder'=>'请输入目录名称')); ?>
          <cite>栏目的目录文件夹地址，目录只能使用英文或英文加数字；<br />选择上方栏目类型会自动添加默认栏目目录，可自行修改</cite>
		</dd>
	  </dl>
      <dl unlink <?php if($type!=9) echo 'hide'; ?>>
		<dt>
          <strong>链接地址</strong>
		</dt>
		<dd>
		  <?php echo form::input('link',aE('link'),null,'text',array('width8','placeholder'=>'请输入链接地址')); ?>
          <cite>指定该栏目跳转链接的地址；外部地址必须带上http://协议网址头部</cite>
		</dd>
	  </dl>
	  <dl bosscms <?php if(!arrExist($G['get'],'id')) echo 'hide'; ?>>
		<dt>
		  <strong>所属上级</strong>
		</dt>
		<dd>
		  <?php echo form::select('parent',aE('parent'),0,$data['subarr'],array('width'=>'50%','required','placeholder'=>'请选择所属的上级栏目')); ?>
          <cite>给该栏目重新选定所属上级栏目，让其作为所选栏目的下级栏目</cite>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>顶部显示</strong>
		</dt>
		<dd>
		  <?php echo form::radio('head',aE('head'),0,$G['option']['display'],array('color'=>'green')); ?>
          <cite>是否在页面头部导航显示</cite>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>底部显示</strong>
		</dt>
		<dd>
		  <?php echo form::radio('foot',aE('foot'),0,$G['option']['display']); ?>
          <cite>是否在页面底部导航显示</cite>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>目标窗口</strong>
		</dt>
		<dd>
		  <?php echo form::radio('target',aE('target'),0,$G['option']['target']); ?>
          <cite>是否新窗口新标签打开该栏目</cite>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>nofollow权重</strong>
		</dt>
		<dd>
		  <?php echo form::radio('nofollow',aE('nofollow'),0,$G['option']['open']); ?>
		  <cite>是否启用 rel='nofollow' 属性屏蔽权重传递</cite>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>是否显示</strong>
		</dt>
		<dd>
		  <?php echo form::radio('display',aE('display'),1,$G['option']['display'],array('color'=>'green')); ?>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>栏目排序</strong>
		</dt>
		<dd>
		  <?php echo form::input('sort',aE('sort'),0,'text',array('width1')); ?>
		</dd>
	  </dl>
      <?php if(arrExist($G,'config|rewrite_open')){ ?>
	  <dl>
		<dt>
		  <strong>静态名称</strong> 
		</dt>
		<dd>
		  <?php echo form::input('static',aE('static'),null,'text',array('width4','placeholder'=>'请输入静态页面名称')); ?>
          <cite>为该详情条目链接地址添加开启静态模式后所显示的文件名称</cite>
		</dd>
	  </dl>
      <?php } ?>
	</div>    
  </aside>
  
  <aside>
	<div>
	  <h2>
		<strong>内容设置</strong>
	  </h2>
	  <dl>
		<dt>
		  <strong data="请根据模板实际调用进行配置">栏目图标</strong>
		</dt>
		<dd>
		  <?php echo form::textarea('icon',aE('icon'),null,array('icon')); ?>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong data="请根据模板实际调用进行配置">栏目图片</strong>
		</dt>
		<dd>
		  <?php echo form::textarea('image',aE('image'),null,array('image')); ?>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong data="请根据模板实际调用进行配置">栏目描述</strong>
		</dt>
		<dd>
		  <?php echo form::textarea('text',aE('text'),null,array()); ?>
		</dd>
	  </dl>
      
      
	  <?php if($data['transfer']){ ?>
      <?php if(in_array('icon1',$data['transfer'])){ ?>
	  <dl>
		<dt>
		  <strong data="请根据模板实际调用进行配置">触发图标</strong>
		</dt>
		<dd>
		  <?php echo form::textarea('icon1',aE('icon1'),null,array('icon')); ?>
		</dd>
	  </dl>
      <?php }if(in_array('images',$data['transfer'])){ ?>
	  <dl>
		<dt>
		  <strong data="请根据模板实际调用进行配置">栏目图集</strong>
		</dt>
		<dd>
		  <?php echo form::textarea('images',aE('images'),null,array('images')); ?>
		</dd>
	  </dl>
      <?php }if(in_array('image1',$data['transfer'])){ ?>
	  <dl>
		<dt>
		  <strong data="请根据模板实际调用进行配置">附加图片一</strong>
		</dt>
		<dd>
		  <?php echo form::textarea('image1',aE('image1'),null,array('image')); ?>
		</dd>
	  </dl>
      <?php }if(in_array('text1',$data['transfer'])){ ?>
	  <dl>
		<dt>
		  <strong data="请根据模板实际调用进行配置">附加描述一</strong>
		</dt>
		<dd>
		  <?php echo form::textarea('text1',aE('text1'),null,array()); ?>
		</dd>
	  </dl>
      <?php }if(in_array('image2',$data['transfer'])){ ?>
	  <dl>
		<dt>
		  <strong data="请根据模板实际调用进行配置">附加图片二</strong>
		</dt>
		<dd>
		  <?php echo form::textarea('image2',aE('image2'),null,array('image')); ?>
		</dd>
	  </dl>
      <?php }if(in_array('text2',$data['transfer'])){ ?>
	  <dl>
		<dt>
		  <strong data="请根据模板实际调用进行配置">附加描述二</strong>
		</dt>
		<dd>
		  <?php echo form::textarea('text2',aE('text2'),null,array()); ?>
		</dd>
	  </dl>
      <?php }if(in_array('image3',$data['transfer'])){ ?>
	  <dl>
		<dt>
		  <strong data="请根据模板实际调用进行配置">附加图片三</strong>
		</dt>
		<dd>
		  <?php echo form::textarea('image3',aE('image3'),null,array('image')); ?>
		</dd>
	  </dl>
      <?php }if(in_array('text3',$data['transfer'])){ ?>
	  <dl>
		<dt>
		  <strong data="请根据模板实际调用进行配置">附加描述三</strong>
		</dt>
		<dd>
		  <?php echo form::textarea('text3',aE('text3'),null,array()); ?>
		</dd>
	  </dl>
      <?php }if(in_array('container',$data['transfer'])){ ?>
	  <dl>
		<dt>
		  <strong data="请根据模板实际调用进行配置">栏目附加内容</strong>
		</dt>
		<dd>
		  <?php echo form::textarea('container',aE('container'),null,array('ueditor')); ?>
		</dd>
	  </dl>
      <?php } ?>
      <?php } ?>
    </div>
  </aside>
  
  <aside>
	<div>
	  <h2>
		<strong>SEO设置</strong>
	  </h2>
	  <dl>
		<dt>
		  <strong>标题</strong>
		</dt>
		<dd>
		  <?php echo form::input('title',aE('title'),null,'text',array('width9','placeholder'=>'请输入网页标题')); ?>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>关键词</strong>
		</dt>
		<dd>
		  <?php echo form::textarea('keywords',aE('keywords'),null,array('param','row'=>6,'cut'=>':','off'=>'|','placeholder'=>'["请输入网页关键词"]')); ?>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>描述</strong>
		</dt>
		<dd>
		  <?php echo form::textarea('description',aE('description'),null,array('height2','placeholder'=>'请输入网页描述')); ?>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong data="页面的图片没有带alt属性的都显示设置好的标签名称">ALT标签</strong>
		</dt>
		<dd>
		  <?php echo form::input('alt',aE('alt'),null,'text',array('width4','placeholder'=>'请输入图片默认的ALT标签')); ?>
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