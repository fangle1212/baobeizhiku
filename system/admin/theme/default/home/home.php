<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');
?>
<?php load::into('head'); ?>
<section class="top">
  <div class="admin">
    <dl>
      <dt><img src="<?php echo $G['manager']['image']?$G['manager']['image']:load::common('img/use_img.jpg','admin',true); ?>" /></dt>
      <dd>
        <h2>欢迎您，<span><?php echo $G['manager']['alias']?$G['manager']['alias']:$G['manager']['username']; ?></span></h2>
        <p>角色类型：<?php echo $G['option']['level'][$G['manager']['level']]; ?> &nbsp; &nbsp; 所属部门：<?php echo $G['manager']['department']; ?></p>
        <p>上次登录时间：<?php echo date('Y.m.d H:i:s',$G['manager']['ltime']); ?> &nbsp; &nbsp; 当前IP地址：<?php echo $G['manager']['ip']; ?></p>
        <p>账户登陆次数：<?php echo $G['manager']['frequency']; ?></p>
      </dd>
    </dl>
  </div>
  <div class="connect">
    <div>
      <dl>
        <dt>
          <em class="fa fa-id-card"></em>
        </dt>
        <dd>
          <b><?php echo $G['config']['admin_contact_title']; ?></b>
          <p><?php echo $G['config']['admin_contact_description']; ?></p>
        </dd>
      </dl>
      <span>
        <p><?php echo strLineSpace($G['config']['admin_contact_content']); ?></p>
        <a class="button tfa green" href="<?php echo $G['config']['admin_contact_link']; ?>" target="_blank">
          <em class="fa fa-comment-o"></em>
          <font>立即咨询</font>
        </a>
      </span>
    </div>
  </div>
</section>
<section class="box boss_cms">
  <?php if(isset($data['feedback'])){ ?>
  <a href="<?php echo url::mpf('feedback','feedback','init'); ?>"><span><dl><dt>留言信息</dt><dd color="red"><?php echo $data['feedback']; ?></dd></dl></span></a>
  <?php } ?>
  <?php if(isset($data['content'])){ ?>
  <a href="<?php echo url::mpf('content','content','init',array('type'=>3)); ?>"><span><dl><dt>产品模块</dt><dd color="blue"><?php echo $data['product']; ?></dd></dl></span></a>
  <a href="<?php echo url::mpf('content','content','init',array('type'=>2)); ?>"><span><dl><dt>新闻模块</dt><dd color="blue"><?php echo $data['news']; ?></dd></dl></span></a>
  <a href="<?php echo url::mpf('content','content','init',array('type'=>4)); ?>"><span><dl><dt>图片模块</dt><dd color="blue"><?php echo $data['image']; ?></dd></dl></span></a>
  <a href="<?php echo url::mpf('content','content','init',array('type'=>5)); ?>"><span><dl><dt>下载模块</dt><dd color="blue"><?php echo $data['download']; ?></dd></dl></span></a>
  <?php } ?>
  <?php if(isset($data['items'])){ ?>
  <a href="<?php echo url::mpf('items','items','init'); ?>"><span><dl><dt>网站栏目</dt><dd color="green"><?php echo $data['items']; ?></dd></dl></span></a>
  <?php } ?>
</section>
<section class="main table news">
  <aside>
    <div>
      <table>
        <tbody>
          <tr>
            <th>系统信息</th>
          </tr>
          <tr>
            <td>授权信息：<em class="fa fa-id-card-o"></em><span class="authorize"<?php if($G['authorize']['oem']) echo ' oem="'.$G['authorize']['oem'].'"'; ?>></span></td>
          </tr>
          <tr>
            <td>网站域名：<?php echo $G['config']['domain']; ?></td>
          </tr>
          <tr>
            <td>程序框架：<a href="<?php echo $G['config']['admin_frame_link']; ?>" target="_blank"><?php echo $G['config']['admin_frame_title']; ?></a></td>
          </tr>
          <tr>
            <td>程序版本：<?php echo $G['config']['version']; ?></td>
          </tr>
          <tr>
            <td>服务系统：<?php echo php_uname('s').php_uname('r'); ?></td>
          </tr>
          <tr>
            <td>运行平台：<?php echo $_SERVER["SERVER_SOFTWARE"]; ?></td>
          </tr>
          <tr>
            <td>环境版本：PHP<?php echo PHP_VERSION; ?> + MYSQL<?php $res = mysql::select('SELECT VERSION() AS ver'); echo $res[0]['ver']; ?></td>
          </tr>
        </tbody>
      </table>
    </div>
  </aside>
  <aside>
    <div>
      <?php if($G['config']['admin_information']){
		  echo delHtmlspecial($G['config']['admin_information']); }else{ ?>
      <table>
        <tbody>
          <tr>
            <th>开发信息</th>
          </tr>
          <tr>
            <td>系统名称：BOSSCMS网站管理系统</td>
          </tr>
          <tr>
            <td>系统语言：PHP + MySQL</td>
          </tr>
          <tr>
            <td>源码下载：<a href="https://gitee.com/Greenpeas/BossCMS" target="_blank">Gitee</a></td>
          </tr>
          <tr>
            <td><span class="update">更新维护：<span></span></span></td>
          </tr>
          <tr>
            <td>开发者：温州互引信息技术有限公司</td>
          </tr>
          <tr>
            <td>官方网站：www.bosscms.net</td>
          </tr>
          <tr>
            <td><span class="qq">交流群：<span></span></span></td>
          </tr>
        </tbody>
      </table>
      <?php } ?>
    </div>
  </aside>
</section>
<?php if(into::load_class('admin','home','home','new')->cover('safe','R',true) && $G['path']['folder']=='admin' && TIME-$G['manager']['ltime']<5){ ?>
<section class="caring admin_folder">
  <em class="fa fa-times"></em>
  <aside>
    <h2>为您站点安全考虑，</h2>
    <h3>请及时修改网站后台登陆文件夹地址！</h3>
    <p>
      <span>前往安全设置修改：</span>
      <a class="button green" target="iframe" href="<?php echo url::mpf('safe','safe','init'); ?>">
        <em class="fa fa fa-get-pocket"></em>
        <font>立即修改</font>
      </a>
    </p>
  </aside>
</section>
<?php } ?>
<?php load::into('foot'); ?>