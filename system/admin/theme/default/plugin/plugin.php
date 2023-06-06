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
    <p>更多应用软件请到官网查看，如需插件定制请联系客服！</p>
  </article>
  <div class="market">
    <div class="cut">
      <span>应用分类：</span>
      <ul>
        <?php if($G['field']['app']){ ?>
        <li<?php if(!$G['get']['divide'] && $G['get']['part']!='plugin'){ ?> class="on"<?php } ?>><a href="<?php echo url::param(url::mpf('plugin','market','init'),'divide',null); ?>">全部</a></li>
        <?php } ?>
        <li<?php if($G['get']['part']=='plugin'){ ?> class="on"<?php } ?>><a href="<?php echo url::mpf('plugin','plugin','init'); ?>">已安装</a></li>
        <?php foreach($G['field']['app']['divide'] as $k=>$v){ ?>
        <li<?php if($G['get']['divide']==$k){ ?> class="on"<?php } ?>><a href="<?php echo url::param(url::mpf('plugin','market','init'),'divide',$k); ?>"><?php echo $v; ?></a></li>
        <?php } ?>
      </ul>
    </div>
    <?php if($G['field']['app']){ ?>
    <div class="filter">
      <?php foreach($G['field']['app']['complex'] as $v){ ?>
      <dl>
        <dt><?php echo $v['title']; ?>：</dt>
        <dd class="param">
          <a<?php if(!$G['get'][$v['name']]){ ?> class="on"<?php } ?> href="<?php echo url::param(url::param(url::param($G['path']['url'],'part','market'),'pages',null),$v['name'],null); ?>">全部</a>
          <?php foreach($v['param'] as $s){ ?>
          <a<?php if($G['get'][$v['name']]==$s){ ?> class="on"<?php } ?> href="<?php echo url::param(url::param(url::param($G['path']['url'],'part','market'),'pages',null),$v['name'],urlencode($s)); ?>"><?php echo $s; ?></a>
          <?php } ?>
        </dd>
      </dl>
      <?php } ?>
      <dl>
        <dt>搜索：</dt>
        <dd>
          <form method="get" action="./">
            <?php echo form::input('lang',$G['get']['lang'],null,'hidden',array(),false); ?>
            <?php echo form::input('mold','plugin',null,'hidden',array(),false); ?>
            <?php echo form::input('part','market',null,'hidden',array(),false); ?>
            <?php echo form::input('func','init',null,'hidden',array(),false); ?>
			<?php echo form::input('search',$G['get']['search'],null,'text',array('required','placeholder'=>'请输入应用名称搜索')); ?>
            <button class="fa fa-search"></button>
          </form>
          <a class="collect<?php if($G['get']['collect']=='list'){ ?> red<?php } ?>"
          <?php if($G['identity']){ ?>
            href="<?php echo url::mpf('plugin','market','init',array('collect'=>$G['get']['collect']=='list'?null:'list')); ?>"
          <?php }else{ ?>
            href="javascript:_alert('请先登录官方账号');"
          <?php } ?>><i class="fa fa-star"></i>我的收藏</a>
        </dd>
      </dl>
    </div>
    <?php } ?>
    <div class="list">
      <table>
        <thead>
          <tr>
            <th>应用名称</th>
            <th>开发商</th>
            <th>版本号</th>
            <th>价格</th>
            <th>导航</th>
            <th>状态</th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody>
		  <?php foreach($data['list'] as $v){ ?>
          <tr>
            <td>              
              <div class="vimg">
                <img src="<?php echo $v['image']; ?>" alt="<?php echo $v['title']; ?>" />
                <span>
                  <b name="<?php echo $v['name']; ?>">
                  <?php if($v['link']){ ?>
                  <a href="<?php echo $v['link']; ?>" target="_blank"><?php echo $v['title']; ?></a>
                  <?php }else echo $v['title']; ?>
                  </b>
                  <p><?php echo $v['description']; ?></p>
                </span>
              </div>
            </td>
            <td width="98"><?php echo $v['author']; ?></td>
            <td width="98"><?php echo $v['version']; ?></td>
            <td width="98" class="nowrap">
              <?php if($v['groups']==0){ ?>免费<?php }else{ ?>
              <span class="fa fa-rmb money"><?php echo $v['price']; ?></span> / <?php echo $v['buy_duration']; ?>
              <?php if($v['remark']){ ?>
              <a href="javascript:_alert('<?php echo $v['remark']; ?>','gold');" color="red" class="preferential">[优惠]</a>
              <?php } ?> &nbsp; &nbsp;
              <?php } ?>
            </td>
            <td width="98"><?php if(isset($v['display'])) echo form::radio("must",$v['must'],1,$G['option']['open'],array('id'=>$v['id'])); ?></td> 
            <td width="98"><?php if(isset($v['display'])) echo form::radio("display",$v['display'],1,$G['option']['open'],array('id'=>$v['id'],'color'=>'green')); ?></td> 
            <td width="188">
			  <?php if(isset($v['display']) || $G['get']['part']=='plugin'){ ?>
              
              <?php if($v['id']){ ?>
              <?php if($G['update'] && $G['update'][$v['name']]>$v['version']){ ?>
              <a class="btnfa green"
                <?php if($G['identity']){ ?>
                href="<?php echo url::mpf('plugin','market','install',array('name'=>$v['name'],'update'=>$G['update'][$v['name']])); ?>"
				<?php }else{ ?>
                href="javascript:_alert('请先登录官方账号');"
                <?php } ?>>
                <em class="fa fa-cloud-upload" title="升级"></em>
              </a>
              <?php } ?>
              <a class="btnfa blue" href="<?php echo url::mpf($v['name'],$v['name'],'init'); ?>" <?php echo $v['target']; ?>>
                <em class="fa fa-pencil" title="管理"></em>
              </a>
              <a class="btnfa red uninstall" url="<?php echo url::mpf($v['name'],'uninstall','init'); ?>">
                <em class="fa fa-trash-o" title="卸载"></em>
              </a>
              <?php }else{ ?>
              <a class="btnfa green" href="<?php echo url::mpf($v['name'],'install','init'); ?>" install="<?php echo $v['name']; ?>">
                <em class="fa fa-cog" title="安装"></em>
              </a>
              <a class="btnfa red delete" url="<?php echo url::mpf('plugin','plugin','delete',array('name'=>$v['name'])); ?>">
                <em class="fa fa-trash-o" title="删除"></em>
              </a>
              <?php } ?>
              
			  <?php }else{ ?>
			  
			  <?php if($v['groups']==0 || $v['buyed']){ ?>
              <a class="btnfa green"
                <?php if($G['identity']){ ?>
                url="<?php echo url::mpf('plugin','market','install',array('name'=>$v['name'])); ?>" install="<?php echo $v['name']; ?>" groups="<?php echo $v['groups']; ?>"
				<?php }else{ ?>
                href="javascript:_alert('请先登录官方账号');"
                <?php } ?>>
                <em class="fa fa-cloud-download" title="安装"></em>
              </a>
              <?php }else{ ?>
              <a class="btnfa green buy"
                <?php if($G['identity']){ ?>
                easy="nofull" width="580" height="420" name="购买 “<?php echo $v['title']; ?>”" url="<?php echo url::mpf('plugin','market','info',array('id'=>$v['id'],'name'=>$v['name'])); ?>"
                <?php }else{ ?>
                href="javascript:_alert('请先登录官方账号');"
                <?php } ?>><em class="fa fa-pencil" title="购买"></em></a>
              <?php } ?>
              <?php  if($v['collect']){ ?>
              <a class="btnfa red"
                <?php if($G['identity']){ ?>
                href="<?php echo url::mpf('plugin','market','collect',array('id'=>$v['id'])); ?>"
                <?php }else{ ?>
                href="javascript:_alert('请先登录官方账号');"
                <?php } ?>>
                <em class="fa fa-star" title="已收藏"></em>
              </a>
              <?php }else{ ?>
              <a class="btnfa blue"
                <?php if($G['identity']){ ?>
                href="<?php echo url::mpf('plugin','market','collect',array('id'=>$v['id'])); ?>"
                <?php }else{ ?>
                href="javascript:_alert('请先登录官方账号');"
                <?php } ?>>
                <em class="fa fa-star-o" title="收藏"></em>
              </a>
              <?php } ?>
              
              
              <?php } ?>
            </td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
    <div class="pages">
      <ol>
        <li><a href="<?php echo url::param($G['path']['url'],'pages',$data['pages']['first']['number']>1?$data['pages']['first']['number']:null); ?>"><i class="fa fa-angle-double-left"></i></a></li>
        <li><a href="<?php echo url::param($G['path']['url'],'pages',$data['pages']['prev']['number']>1?$data['pages']['prev']['number']:null); ?>"><i class="fa fa-angle-left"></i></a></li>
        <?php foreach($data['pages']['list'] as $v){ ?>
        <li><a href="<?php echo url::param($G['path']['url'],'pages',$v['number']>1?$v['number']:null); ?>" <?php echo $v['current']?' class="on"':''; ?>><?php echo $v['number']; ?></a></li>
        <?php } ?>
        <li><a href="<?php echo url::param($G['path']['url'],'pages',$data['pages']['next']['number']>1?$data['pages']['next']['number']:null); ?>"><i class="fa fa-angle-right"></i></a></li>
        <li><a href="<?php echo url::param($G['path']['url'],'pages',$data['pages']['last']['number']>1?$data['pages']['last']['number']:null); ?>"><i class="fa fa-angle-double-right"></i></a></li>
      </ol>
    </div>
  </div>
</section>
<?php load::into('foot'); ?>