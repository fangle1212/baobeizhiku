<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');
?>
<?php load::into('head'); ?>
<form id="buy" action="<?php echo url::mpf('plugin','market','buy'); ?>" method="post" enctype="multipart/form-data">
<?php global $aE; $aE=$G['config']; ?>
<section class="main form">
  <article class="hint">
    <i class="fa fa-info-circle"></i>
    <p>应用软件为源码交易，不支持退款。请谨慎购买！</p>
  </article>
  <aside>
	<div>
	  <dl>
		<dt>
		  <strong>应用名称</strong> 
		</dt>
		<dd>
		  <?php echo form::radio('id',$data['id'],null,array($data['id']=>$data['title'])); ?> 
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>使用期限</strong> 
		</dt>
		<dd>
          <code class="radio">
			<?php foreach($data['pr'] as $k=>$v){ ?>
            <label class="radio  <?php if($v['defaults']){ ?><?php $price=$v['price'] ; ?> checked<?php } ?>">
              <input name="pi" no <?php if($v['defaults']){ ?>checked<?php } ?> type="radio" value="<?php echo $v['id']; ?>" price="<?php echo $v['price']; ?>"/>
              <ins><?php echo $v['buy_duration']; ?></ins>
            </label>
            <?php } ?>
          </code>
		</dd>
	  </dl>
	  <dl>
		<dt>
		  <strong>支付金额</strong> 
		</dt>
		<dd>
          <code>
            <label class="price">
              <i class="fa fa-rmb money" color="red"><?php echo $price; ?></i>
              <?php echo form::input('price',$price,null,'hidden',array(),false); ?>
            </label>
          </code>
		</dd>
	  </dl> 
	  <dl>
		<dt>
		  <strong>支付方式</strong> 
		</dt>
		<dd>
		  <?php echo form::radio('pay','alipay',null,array(
			  'alipay'=>'<i class="alipayimg" title="支付宝"></i>',
			  'balance'=>'<b class="balance">账号余额 <i class="fa fa-rmb money" color="red">'.$data['balance'].'</i></b>'
		  ),array('no')); ?>
          <cite></cite>
		</dd>
	  </dl>
      
	  <dl class="password" hide>
		<dt>
		  <strong>账号密码</strong> 
		</dt>
		<dd>
		  <?php echo form::input('password',null,null,'password',array('placeholder'=>'请输入官方账号密码','width6')); ?>
          <cite>验证官方账号密码，才能进行账号余额消费</cite>
		</dd>
	  </dl>
       
	</div>
  </aside>
</section>
<section class="refer">
  <button class="button green" type="submit">
    <font>立即购买</font>
  </button>
  <span>
    <label class="protocol">
      <code class="checkbox">
      <label class="checkbox">
        <?php echo form::input('protocol','1',null,'checkbox',array(),false); ?>
        <ins>已阅读并同意《<a href="https://www.bosscms.net/unifyagreement/" target="_blank">软件许可及服务协议</a>》</ins>
      </label>
	  </code>
    </label>
  </span>
</section>
</form>
<?php load::into('foot'); ?>