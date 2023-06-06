<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');
?>
<?php load::into('head'); ?>
<form action="<?php echo url::mpf('template','params','add'); ?>" method="post" enctype="multipart/form-data">
<?php global $aE; $aE=$G['config']; ?>
<section class="main form tab">
  <aside>
	<div>
	  <h2>
		<strong>产品设置</strong>
	  </h2>
	  <dl>
		<dt>
		  <strong>编辑框数量</strong> 
		</dt>
		<dd>
		  <?php echo form::radio('product_content_number',aE('product_content_number'),1,array(1=>'1个',2=>'2个',3=>'3个',4=>'4个',5=>'5个')); ?>
          <cite>设置产品详情中开启调用多少个内容编辑框</cite>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>编辑框标题一</strong> 
		</dt>
		<dd>
		  <?php echo form::input('product_content_title',aE('product_content_title'),'内容详情','text',array('width3','placeholder'=>'请输入编辑框标题')); ?>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>编辑框标题二</strong> 
		</dt>
		<dd>
		  <?php echo form::input('product_content_title1',aE('product_content_title1'),'','text',array('width3','placeholder'=>'请输入编辑框标题')); ?>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>编辑框标题三</strong> 
		</dt>
		<dd>
		  <?php echo form::input('product_content_title2',aE('product_content_title2'),'','text',array('width3','placeholder'=>'请输入编辑框标题')); ?>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>编辑框标题四</strong> 
		</dt>
		<dd>
		  <?php echo form::input('product_content_title3',aE('product_content_title3'),'','text',array('width3','placeholder'=>'请输入编辑框标题')); ?>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>编辑框标题五</strong> 
		</dt>
		<dd>
		  <?php echo form::input('product_content_title4',aE('product_content_title4'),'','text',array('width3','placeholder'=>'请输入编辑框标题')); ?>
          <cite>设置产品模块编辑详情的内容编辑框标题</cite>
		</dd>
	  </dl>
	</div>
  </aside>
  
  
  <aside>
	<div>
	  <h2>
		<strong>列表数量</strong>
	  </h2>
	  <dl>
		<dt>
		  <strong>新闻展示数量</strong> 
		</dt>
		<dd>
		  <?php echo form::input('news_number',aE('news_number'),20,'text',array('width1','placeholder'=>'请输入新闻展示数量')); ?>
          <cite>设置前台新闻类型的栏目列表页每一页显示的数量</cite>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>产品展示数量</strong> 
		</dt>
		<dd>
		  <?php echo form::input('product_number',aE('product_number'),20,'text',array('width1','placeholder'=>'请输入产品展示数量')); ?>
          <cite>设置前台产品类型的栏目列表页每一页显示的数量</cite>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>图片展示数量</strong> 
		</dt>
		<dd>
		  <?php echo form::input('image_number',aE('image_number'),20,'text',array('width1','placeholder'=>'请输入图片展示数量')); ?>
          <cite>设置前台图片类型的栏目列表页每一页显示的数量</cite>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>下载展示数量</strong> 
		</dt>
		<dd>
		  <?php echo form::input('download_number',aE('download_number'),20,'text',array('width1','placeholder'=>'请输入下载展示数量')); ?>
          <cite>设置前台下载类型的栏目列表页每一页显示的数量</cite>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>反馈展示数量</strong> 
		</dt>
		<dd>
		  <?php echo form::input('feedback_number',aE('feedback_number'),10,'text',array('width1','placeholder'=>'请输入反馈展示数量')); ?>
          <cite>设置前台反馈类型的栏目列表页每一页显示的数量</cite>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>搜索展示数量</strong> 
		</dt>
		<dd>
		  <?php echo form::input('search_number',aE('search_number'),10,'text',array('width1','placeholder'=>'请输入搜索展示数量')); ?>
          <cite>设置前台搜索类型的栏目列表页每一页显示的数量</cite>
		</dd>
	  </dl>
      <dl>
		<dt>
		  <strong>详情页翻页</strong> 
		</dt>
		<dd>
		  <?php echo form::radio('both_type',aE('both_type'),1,array('按当前栏目','按上级栏目'),array('no')); ?>
          <cite>设置前台详情页的上下翻页规则，是按内容所属栏目分页；还是按所属同类型栏目的上级栏目分页</cite>
		</dd>
      </dl>
	</div>
  </aside>
    
  
  <aside>
	<div>
	  <h2>
		<strong>缩略图设置</strong>
	  </h2>
	  <dl>
		<dt>
		  <strong>新闻缩略图宽度</strong> 
		</dt>
		<dd>
		  <?php echo form::input('news_thumbnail_width',aE('news_thumbnail_width'),400,'text',array('width2','placeholder'=>'请输入缩略图宽度')); ?>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>新闻缩略图高度</strong> 
		</dt>
		<dd>
		  <?php echo form::input('news_thumbnail_height',aE('news_thumbnail_height'),300,'text',array('width2','placeholder'=>'请输入缩略图高度')); ?>
          <cite>设置前台新闻类型的栏目图片缩略图的宽度高度</cite>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>产品缩略图宽度</strong> 
		</dt>
		<dd>
		  <?php echo form::input('product_thumbnail_width',aE('product_thumbnail_width'),500,'text',array('width2','placeholder'=>'请输入缩略图宽度')); ?>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>产品缩略图高度</strong> 
		</dt>
		<dd>
		  <?php echo form::input('product_thumbnail_height',aE('product_thumbnail_height'),500,'text',array('width2','placeholder'=>'请输入缩略图高度')); ?>
          <cite>设置前台产品类型的栏目图片缩略图的宽度高度</cite>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>图片缩略图宽度</strong> 
		</dt>
		<dd>
		  <?php echo form::input('image_thumbnail_width',aE('image_thumbnail_width'),300,'text',array('width2','placeholder'=>'请输入缩略图宽度')); ?>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>图片缩略图高度</strong> 
		</dt>
		<dd>
		  <?php echo form::input('image_thumbnail_height',aE('image_thumbnail_height'),400,'text',array('width2','placeholder'=>'请输入缩略图高度')); ?>
          <cite>设置前台图片类型的栏目图片缩略图的宽度高度</cite>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>下载缩略图宽度</strong> 
		</dt>
		<dd>
		  <?php echo form::input('download_thumbnail_width',aE('download_thumbnail_width'),300,'text',array('width2','placeholder'=>'请输入缩略图宽度')); ?>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>下载缩略图高度</strong> 
		</dt>
		<dd>
		  <?php echo form::input('download_thumbnail_height',aE('download_thumbnail_height'),300,'text',array('width2','placeholder'=>'请输入缩略图高度')); ?>
          <cite>设置前台下载类型的栏目图片缩略图的宽度高度</cite>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>缩略图拉伸类型</strong> 
		</dt>
		<dd>
		  <?php echo form::select('thumbnail_size',aE('thumbnail_size'),'fill',array('fill'=>'铺满','cover'=>'裁剪','contain'=>'留白'),array('width'=>'15%')); ?>
          <cite>设置前台图片缩略图的拉伸类型</cite>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>缩略图横向对齐</strong> 
		</dt>
		<dd>
		  <?php echo form::select('thumbnail_horizontal',aE('thumbnail_horizontal'),'center',array('left'=>'左对齐','center'=>'中对齐','right'=>'右对齐'),array('width'=>'15%')); ?>
          <cite>设置前台图片缩略图的横向对齐</cite>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>缩略图纵向对齐</strong> 
		</dt>
		<dd>
		  <?php echo form::select('thumbnail_vertical',aE('thumbnail_vertical'),'center',array('top'=>'上对齐','center'=>'中对齐','bottom'=>'下对齐'),array('width'=>'15%')); ?>
          <cite>设置前台图片缩略图的纵向对齐</cite>
		</dd>
	  </dl>
	</div>
  </aside>
    
  <aside>
	<div>
	  <h2>
		<strong>文字设置</strong>
	  </h2>
	  <dl>
		<dt>
		  <strong>导航首页</strong> 
		</dt>
		<dd>
		  <?php echo form::input('home',aE('home'),'首页','text',array('width2','placeholder'=>'请输入文字')); ?>
          <cite>栏目导航栏中首页按钮的文字</cite>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>分页首页</strong> 
		</dt>
		<dd>
		  <?php echo form::input('page_first',aE('page_first'),'首页','text',array('width2','placeholder'=>'请输入文字')); ?>
          <cite>新闻、产品、图片、下载的列表页下方分页按钮中回到第一页按钮的文字</cite>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>分页末页</strong> 
		</dt>
		<dd>
		  <?php echo form::input('page_last',aE('page_last'),'末页','text',array('width3','placeholder'=>'请输入文字')); ?>
          <cite>新闻、产品、图片、下载的列表页分页的按钮文字</cite>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>分页上页</strong> 
		</dt>
		<dd>
		  <?php echo form::input('page_prev',aE('page_prev'),'上一页','text',array('width3','placeholder'=>'请输入文字')); ?>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>分页下页</strong> 
		</dt>
		<dd>
		  <?php echo form::input('page_next',aE('page_next'),'下一页','text',array('width3','placeholder'=>'请输入文字')); ?>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>分页第几页</strong> 
		</dt>
		<dd>
		  <?php echo form::input('page_number',aE('page_number'),'第[n]页','text',array('width3','placeholder'=>'请输入文字')); ?>
          <cite>新闻、产品、图片、下载的列表页下方分页按钮中回到第几页按钮的文字；注：请插入 [n] 替代页面数字</cite>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>翻页上篇</strong> 
		</dt>
		<dd>
		  <?php echo form::input('page_before',aE('page_before'),'上一篇','text',array('width3','placeholder'=>'请输入文字')); ?>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>翻页下篇</strong> 
		</dt>
		<dd>
		  <?php echo form::input('page_after',aE('page_after'),'下一篇','text',array('width3','placeholder'=>'请输入文字')); ?>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>翻页没有了</strong> 
		</dt>
		<dd>
		  <?php echo form::input('page_none',aE('page_none'),'没有了','text',array('width3','placeholder'=>'请输入文字')); ?>
          <cite>新闻、产品、图片、下载的详情页下方上下篇按钮中的按钮文字</cite>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>友链标题</strong> 
		</dt>
		<dd>
		  <?php echo form::input('link_title',aE('link_title'),'友情链接：','text',array('width4','placeholder'=>'请输入文字')); ?>
          <cite>网页底部友情链接的标题文字</cite>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>发布标题</strong> 
		</dt>
		<dd>
		  <?php echo form::input('group_time',aE('group_time'),'发布日期：','text',array('width4','placeholder'=>'请输入文字')); ?>
          <cite>列表类型时间所用到的标题文字</cite>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>阅读量标题</strong> 
		</dt>
		<dd>
		  <?php echo form::input('group_notice',aE('group_notice'),'阅读量：','text',array('width4','placeholder'=>'请输入文字')); ?>
          <cite>列表类型计算阅读量所用到的标题文字</cite>
		</dd>
	  </dl>
      
	  <dl>
		<dt>
		  <strong>下载按钮</strong> 
		</dt>
		<dd>
		  <?php echo form::input('download_file',aE('download_file'),'下载文件：','text',array('width3','placeholder'=>'请输入文字')); ?>
          <cite>下载类型页面提供下载附件的按钮文字</cite>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>文件大小</strong> 
		</dt>
		<dd>
		  <?php echo form::input('download_size',aE('download_size'),'文件大小：','text',array('width3','placeholder'=>'请输入文字')); ?>
          <cite>下载类型页面提示文件大小的标题文字</cite>
		</dd>
	  </dl>
      
	  <dl>
		<dt>
		  <strong>全部文字</strong> 
		</dt>
		<dd>
		  <?php echo form::input('all',aE('all'),'全部','text',array('width2','placeholder'=>'请输入文字')); ?>
          <cite>一般用于列表页筛选时的“全部”按钮文字</cite>
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