<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
defined('IS_OK') or exit('Access Forbidden');
?>
<?php if(!isset($G['no_copyright']) && $G['config']['admin_copyright_name']){ ?>
<section class="copyright">
  <p size15><?php echo $G['copyright']; ?></p>
</section>
<?php } ?>
<?php if(!isset($G['no_easy'])){ ?>
<section class="easy <?php if($G['get']['win']) echo 'active'; if($G['config']['window_full']) echo 'full'; ?>">
  <div class="window">
    <div class="icon">
      <span class="full <?php if($G['config']['window_full']) echo 'on'; ?>">
        <em class="fa fa-expand"></em>
        <em class="fa fa-compress"></em>
      </span>
      <span class="close <?php if($G['config']['window_full']) echo 'on'; ?>"><em class="fa fa-times"></em></span>
    </div>
    <div class="move"></div>
    <iframe></iframe>
  </div>
</section>
<?php } ?>
<script>
$.P = '<?php echo P; ?>';
$G = $ext = [];
$G['bosscms']=true;
$G['version']='<?php echo $G['config']['version']; ?>';
$G['host']='<?php echo $G['path']['host']; ?>';
$G['defaults']=<?php echo $G['language']['defaults']; ?>;
$G['lang']=<?php echo $G['language']['id']; ?>;
$G['relative']='<?php echo $G['path']['relative']; ?>';
$G['theme']='<?php echo $G['config']['web_theme']; ?>';
$G['upload']='<?php echo url::upload(); ?>';
$G['mold']='<?php echo $G['get']['mold']; ?>';
$G['part']='<?php echo $G['get']['part']; ?>';
$G['func']='<?php echo $G['get']['func']; ?>';
$G['items']=<?php echo isset($G['get']['items'])?$G['get']['items']:0; ?>;
$G['easy']='<?php if($G['config']['window_full']) echo 'full'; ?>';
<?php into::basic_json('extension'); ?>
<?php foreach($G['extension'] as $k=>$v){ ?>
$ext['<?php echo $k; ?>']=<?php echo json::encode($v); ?>;
<?php } ?>
</script>
<?php echo html::script(load::common('js/bosscms.js','admin',true)); ?>
<?php echo html::script(load::theme('js/'.BOSSCMS_MOLD.'.js','admin',true)); ?>
<?php echo html::script(load::theme('js/'.BOSSCMS_MOLD.'_'.BOSSCMS_PART.'.js','admin',true)); ?>
</body>
</html>