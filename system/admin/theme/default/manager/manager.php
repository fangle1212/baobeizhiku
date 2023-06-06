<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');
?>
<?php load::into('head'); ?>
<section class="main table">
  <aside>
    <div>
      <?php if($G['manager']['level']==1 || $data['add']){ ?>
      <div class="head">
        <a class="button green" easy width="780" height="510" url="<?php echo url::mpf('manager','manager','edit'); ?>">
          <em class="fa fa-plus"></em>
          <font>添加管理员</font>
        </a>
      </div>
      <?php } ?>
      <table>
        <tbody>
          <tr> 
            <th>管理员账号</th>
            <th>管理员角色</th>
            <th>别名</th>
            <th>部门</th>
            <th>最后登陆时间</th>
            <th>最后登陆IP</th>
            <th>操作</th>
          </tr>
          <?php
          foreach($data['list'] as $v){
          ?>
          <tr>
            <td><?php echo $v['username']; ?></td>
            <td><?php echo $G['option']['level'][$v['level']]; ?></td>
            <td><?php echo $v['alias']; ?></td>
            <td><?php echo $v['department']; ?></td>
            <td><?php echo $v['ltime']?date('Y-m-d H:i:s',$v['ltime']):''; ?></td>
            <td><?php echo $v['ip']; ?></td>
            <td width="228">
              <a class="btnfa blue" <?php if($G['get']['edit']==$v['id']) echo 'auto="click"'; ?> easy width="780" height="510" name="修改管理员" url="<?php echo url::mpf('manager','manager','edit',array('id'=>$v['id'])); ?>">
                <em class="fa fa-pencil" title="修改"></em>
              </a>
              <?php if($v['level']!=1 && ($G['manager']['level']==1 || ($data['add'] && $v['level']!=$G['manager']['level']))){ ?>
              <a class="btnfa green" easy name="管理员权限" url="<?php echo url::mpf('manager','manager','check',array('id'=>$v['id'])); ?>">
                <em class="fa fa-check" title="权限"></em>
              </a>
              <a class="btnfa red delete" url="<?php echo url::mpf('manager','manager','delete',array('id'=>$v['id'])); ?>">
                <em class="fa fa-trash-o" title="删除"></em>
              </a>
              <?php } ?>
            </td>
          </tr>
          <?php
          }
          ?>
        </tbody>
      </table>
    </div>
  </aside>
</section>
<?php load::into('foot'); ?>