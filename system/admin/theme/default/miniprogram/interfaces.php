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
    <p>请配置好小程序内容及接口信息再进行发布；注：只能发布“使用中”的模板</p>
    <p>发布后将以您的<a href="./#mpf=site" target="_blank">站点域名</a>作为小程序的服务器域名；注：该域名必须支持https访问且不能为ip地址</p>
  </article>
  <div class="market">
    <aside>
      <div class="interfaces">
        <table>
          <thead>
            <tr>
              <th>名称</th>
              <th>操作</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>              
                <div class="vimg">
                  <img src="../system/admin/common/img/miniprogram_weixin.png" />
                  <span>
                    <b>微信小程序</b>
                    <p>登录<a href="https://mp.weixin.qq.com/" rel="nofollow" target="_blank">微信公众平台（mp.weixin.qq.com）</a>获取小程序的api信息</p>
                  </span>
                </div>
              </td>
              <td width="188">
                <a class="btnfa blue" name="配置接口" easy width="800" height="480" url="<?php echo url::mpf('miniprogram','interfaces','edit',array('type'=>'weixin')); ?>">
                  <em class="fa fa-pencil" title="配置"></em>
                </a>
                <a class="btnfa green" name="发布小程序" easy width="800" height="600" url="<?php echo url::mpf('miniprogram','interfaces','publish',array('type'=>'weixin')); ?>">
                  <em class="fa fa-cloud-upload" title="发布"></em>
                </a>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </aside>
</section>
<?php load::into('foot'); ?>