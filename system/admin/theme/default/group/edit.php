<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');
?>
<?php load::into('head'); ?>
<form action="<?php echo url::mpf('group','group','add'); ?>" method="post" enctype="multipart/form-data">
<?php global $aE; $aE=isset($data)?$data:null; $type=arrExist($G['get'],'type'); ?>
<section class="main form tab">

  <aside>
	<div class="lt70">
	  <h2>
		<strong>内容设置</strong>
	  </h2>
	  <dl>
		<dt>
		  <strong>所属栏目</strong>
		</dt>
		<dd>
		  <?php echo form::select('items',aE('items'),false,$data['subarr'],array('width'=>'40%')); ?>
          <cite>栏目所属栏目包含相同类型的父级栏目</cite>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>标题名称</strong>
		</dt>
		<dd>
		  <?php echo form::input('name',aE('name'),null,'text',array('required','placeholder'=>'请输入标题名称','width9')); ?>
          <cite>内容的标题名称</cite>
		</dd>
	  </dl>
	  <?php if($type==2 || $type==4 || $type==5){ ?>
	  <dl>
		<dt>
		  <strong data="请根据模板实际调用进行配置">内容编辑</strong>
		</dt>
		<dd>
		  <?php echo form::textarea('content',aE('content'),null,array('ueditor','请输入内容编辑')); ?>
		</dd>
	  </dl>
	  <?php }else if($type==3){ ?>
	  <dl>
		<dt>
		  <strong data="请根据模板实际调用进行配置">内容编辑</strong>
		</dt>
		<dd>
          <div class="cutover">
            <ol>
              <?php for($i=0; $i<$G['config']['product_content_number']; $i++){ ?>
              <li<?php echo $i?'':' class="on"';  ?>><?php echo $G['config']['product_content_title'.($i?$i:'')]; ?></li>
              <?php } ?>
            </ol>
            <ul>
              <?php for($i=0; $i<$G['config']['product_content_number']; $i++){ ?>
              <li<?php echo $i?'':' class="on"';  ?>>
			    <?php echo form::textarea('content'.($i?$i:''),aE('content'.($i?$i:'')),null,array('ueditor','placeholder'=>'请输入内容编辑')); ?>
              </li>
              <?php } ?>
            </ul>
          </dl>
		</dd>
	  </dl>
	  <?php } ?>
            
      <?php if($type==2){ ?>
	  <dl>
		<dt>
		  <strong data="请根据模板实际调用进行配置">缩略图</strong>
		</dt>
		<dd>
		  <?php echo form::textarea('image',aE('image'),null,array('image')); ?>
		</dd>
	  </dl>
	  <?php if($data['transfer']){ ?>
      <?php if(in_array('images',$data['transfer'])){ ?>
	  <dl>
		<dt>
		  <strong data="请根据模板实际调用进行配置">新闻图集</strong>
		</dt>
		<dd>
		  <?php echo form::textarea('images',aE('images'),null,array('images')); ?>
		</dd>
	  </dl>
	  <?php }} ?>
      <?php }else if($type==3){ ?>
	  <dl>
		<dt>
		  <strong data="请根据模板实际调用进行配置">缩略图</strong>
		</dt>
		<dd>
		  <?php echo form::textarea('image',aE('image'),null,array('image')); ?>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong data="请根据模板实际调用进行配置">产品图集</strong>
		</dt>
		<dd>
		  <?php echo form::textarea('images',aE('images'),null,array('images')); ?>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong data="请根据模板实际调用进行配置">产品价格</strong>
		</dt>
		<dd>
		  <?php echo form::input('price',aE('price'),null,'text',array('width2','placeholder'=>'请输入产品价格')); ?>
		</dd>
	  </dl>
	  <?php if($data['transfer']){ ?>
      <?php if(in_array('icon',$data['transfer'])){ ?>
	  <dl>
		<dt>
		  <strong data="请根据模板实际调用进行配置">产品图标</strong>
		</dt>
		<dd>
		  <?php echo form::textarea('icon',aE('icon'),null,array('icon')); ?>
		</dd>
	  </dl>
      <?php }if(in_array('video',$data['transfer'])){ ?>
	  <dl>
		<dt>
		  <strong data="请根据模板实际调用进行配置">产品视频</strong>
		</dt>
		<dd>
		  <?php echo form::textarea('video',aE('video'),null,array('video')); ?>
		</dd>
	  </dl>
	  <?php } ?>
      <?php } ?>
      <?php }else if($type==4){ ?>
	  <dl>
		<dt>
		  <strong data="请根据模板实际调用进行配置">缩略图</strong>
		</dt>
		<dd>
		  <?php echo form::textarea('image',aE('image'),null,array('image')); ?>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong data="请根据模板实际调用进行配置">详情图集</strong>
		</dt>
		<dd>
		  <?php echo form::textarea('images',aE('images'),null,array('images')); ?>
		</dd>
	  </dl>
      <?php }else if($type==5){ ?>
	  <dl>
		<dt>
		  <strong>上传附件</strong>
		</dt>
		<dd>
		  <?php echo form::textarea('file',aE('file'),null,array('file')); ?>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong data="该表单控件为空时，上传附件并保存，会自动计算该附件大小；单位：B">附件大小</strong>
		</dt>
		<dd>
		  <?php echo form::input('size',aE('size'),null,'text',array()); ?>
		</dd>
	  </dl>
	  <?php if($data['transfer']){ ?>
      <?php if(in_array('icon',$data['transfer'])){ ?>
	  <dl>
		<dt>
		  <strong data="请根据模板实际调用进行配置">类型图标</strong>
		</dt>
		<dd>
		  <?php echo form::textarea('icon',aE('icon'),'fa-file-text-o',array('icon')); ?>
		</dd>
	  </dl>
      <?php }if(in_array('image',$data['transfer'])){ ?>
	  <dl>
		<dt>
		  <strong data="请根据模板实际调用进行配置">附件图片</strong>
		</dt>
		<dd>
		  <?php echo form::textarea('image',aE('image'),null,array('image')); ?>
		</dd>
	  </dl>
      <?php } ?>
      <?php } ?>
      <?php } ?>
            
	  <dl>
		<dt>
		  <strong>简短描述</strong>
		</dt>
		<dd>
		  <?php echo form::textarea('text',aE('text'),null,array('placeholder'=>'请输入简短描述','height2')); ?>
          <cite>简单描述不填写时，在保存时自动对下方内容编辑截取前100个字</cite>
		</dd>
	  </dl>
	  <?php if(($type==2 || $type==3 || $type==4) && $data['transfer']){ ?>
      <?php if(in_array('image1',$data['transfer'])){ ?>
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
      <?php } ?>
      <?php } ?>
      
	  <?php if($data['transfer']){ ?>
      <?php if(in_array('container',$data['transfer'])){ ?>
	  <dl>
		<dt>
		  <strong data="请根据模板实际调用进行配置">附加内容</strong>
		</dt>
		<dd>
		  <?php echo form::textarea('container',aE('container'),null,array('ueditor')); ?>
		</dd>
	  </dl>
      <?php } ?>
      <?php } ?>
    </div>
	<div class="gt30">
	  <dl>
		<dt>
		  <strong>是否推荐</strong>
		</dt>
		<dd>
		  <?php echo form::radio('recommend',aE('recommend'),0,$G['option']['is']); ?>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>是否置顶</strong>
		</dt>
		<dd>
		  <?php echo form::radio('top',aE('top'),0,$G['option']['is']); ?>
          <cite>将该内容显示在列表最顶部，多个置顶内容按排序展示</cite>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>发布时间</strong>
		</dt>
		<dd>
		  <?php echo form::input('ctime',str_replace(' ','T',aE('ctime')),str_replace(' ','T',TIME),'datetime-local',array('required','placeholder'=>'请输入发布时间','step'=>1)); ?>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>更新时间</strong>
		</dt>
		<dd>
		  <?php echo form::input('mtime',str_replace(' ','T',aE('mtime')),str_replace(' ','T',TIME),'datetime-local',array('required','placeholder'=>'请输入更新时间','step'=>1)); ?>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>阅读次数</strong>
		</dt>
		<dd>
		  <?php echo form::input('notice',aE('notice'),0,'text',array('required','placeholder'=>'请输入阅读次数','width2')); ?>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>列表排序</strong>
		</dt>
		<dd>
		  <?php echo form::input('sort',aE('sort'),0,'text',array('required','placeholder'=>'请输入列表排序','width1')); ?>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>目标窗口</strong>
		</dt>
		<dd>
		  <?php echo form::radio('target',aE('target'),0,$G['option']['target'],array('no')); ?>
          <cite>点击该详情条目时是否需要浏览器新窗口打开</cite>
		</dd>
	  </dl>
	</div>
  </aside>
  
  <aside>
	<div>
	  <h2>
		<strong>参数配置</strong>
	  </h2>
  	  <?php if($type==3 || $type==4 || $type==5){ ?>
	  <dl>
		<dt>
		  <strong>设置参数</strong>
		</dt>
		<dd>
		  <?php echo ctrl::complex($type, null, array('style'=>30,'name'=>'params'), $G['get']['items'], $data, 0); ?>
		</dd>
	  </dl>
 	  <?php } ?>
	  <dl>
		<dt>
		  <strong>跳转地址</strong> 
		</dt>
		<dd>
		  <?php echo form::input('link',aE('link'),null,'text',array('width8','placeholder'=>'请输入自定义地址')); ?>
          <cite>点击该详情条目时跳转的自定义链接地址；为空则显示详情内容</cite>
		</dd>
	  </dl>
      <?php if(arrExist($G,'config|rewrite_open')){ ?>
	  <dl>
		<dt>
		  <strong>静态名称</strong> 
		</dt>
		<dd>
		  <?php echo form::input('static',aE('static'),null,'text',array('width4','placeholder'=>'请输入静态名称')); ?>
          <cite>该详情条目链接地址添加开启静态模式后所显示的文件名称</cite>
		</dd>
	  </dl>
      <?php } ?>
	  <dl <?php echo 'tm'.count($data['page']); ?>>
		<dt>
		  <strong>页面模板</strong>
		</dt>
		<dd>
		  <?php echo form::select("theme",aE('theme'),null,$data['page'],array('placeholder'=>'请选择页面模板')); ?>
          <cite>该内容页面是否使用独立的模板风格，不选则调用栏目所选详情页模板</cite>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>是否显示</strong>
		</dt>
		<dd>
		  <?php echo form::radio('display',aE('display'),1,$G['option']['display']); ?>
		</dd>
	  </dl>
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
		  <?php echo form::input('title',aE('title'),null,'text',array('placeholder'=>'请输入网页标题','width9')); ?>
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
		  <?php echo form::textarea('description',aE('description'),null,array('placeholder'=>'请输入网页描述','height2')); ?>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong data="页面的图片没有带alt属性的都显示设置好的标签名称">ALT标签</strong>
		</dt>
		<dd>
		  <?php echo form::input('alt',aE('alt'),null,'text',array('placeholder'=>'请输入ALT标签','width4')); ?>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong data="使用说明：单个页面建议添加2~3个标签。特别说明：批量增加标签路径调用默认值，如需修改单个标签路径到“SEO设置”>“TAG标签”中修改。">TAG标签</strong>
		</dt>
		<dd>
		  <?php echo form::textarea('tag',aE('tag'),null,array('param','row'=>4)); ?>
          <code class="tag">
            <div>
              <a class="button blue" url="<?php echo url::mpf('tag','tag','edit'); ?>">
                <em class="fa fa-tag"></em>
                <font>选择已设标签</font>
              </a>
              <span>TAG标签可以到“SEO设置”>“TAG标签”中管理</span>
            </div>
          </code>
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