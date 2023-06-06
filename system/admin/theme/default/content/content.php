<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');
?>
<section class="iframe content">
  <section class="navsub tree" tree="iframe" cookie="iframeContentTreeLi">
    <div>
      <h2 class="treecheck" tree="iframe">
        <em class="fa fa-expand"></em>
        <em class="fa fa-compress"></em>
        <span><u>展开</u><b>·</b><i>折叠</i></span>
      </h2>
      <ul>
      <?php
      foreach($data as $v){
      ?>
        <li class="<?php echo $v['on']; ?>" level="<?php echo $v['level']; ?>" items="<?php echo $v['id']; ?>" it="<?php echo $v['id']; ?>">
          <span lv><b></b></span>
          <a href="<?php echo $v['url']; ?>"><?php echo $v['name']; ?></a>
        </li>
      <?php
      }
      ?>
      </ul>
    </div>
  </section>
</section>