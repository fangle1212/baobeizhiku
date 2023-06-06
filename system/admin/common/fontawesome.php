<?php
define('IS_INSIDE',true);
define('BOSSCMS_MOLD','clear');
define('BOSSCMS_PART','clear');
define('BOSSCMS_FUNC','init');
require('../../../system/enter.php');
into::basic_class('admin');
$body = arrExist($G,'get|body');
if(!$body){
?>
<!DOCTYPE html>
<html>
<head>
  <title>Fontawesome - <?php echo $G['config']['admin_title']; ?></title>
  <?php echo html::link($G['path']['relative']."system/admin/common/css/global.css"); ?>
  <?php echo html::link($G['path']['relative']."system/web/common/css/font-awesome.css"); ?>
</head>
<body>
<?php } ?>
<section class="fontawesome">
  <div>
    <h2>医疗类图标(12个)</h2>
    <ul>
      <li><a href="javascript:;" data-content="fa-ambulance" class="fa fa-ambulance"></a></li>
      <li><a href="javascript:;" data-content="fa-h-square" class="fa fa-h-square"></a></li>
      <li><a href="javascript:;" data-content="fa-heart" class="fa fa-heart"></a></li>
      <li><a href="javascript:;" data-content="fa-heart-o" class="fa fa-heart-o"></a></li>
      <li><a href="javascript:;" data-content="fa-heartbeat" class="fa fa-heartbeat"></a></li>
      <li><a href="javascript:;" data-content="fa-hospital-o" class="fa fa-hospital-o"></a></li>
      <li><a href="javascript:;" data-content="fa-medkit" class="fa fa-medkit"></a></li>
      <li><a href="javascript:;" data-content="fa-plus-square" class="fa fa-plus-square"></a></li>
      <li><a href="javascript:;" data-content="fa-stethoscope" class="fa fa-stethoscope"></a></li>
      <li><a href="javascript:;" data-content="fa-user-md" class="fa fa-user-md"></a></li>
      <li><a href="javascript:;" data-content="fa-wheelchair" class="fa fa-wheelchair"></a></li>
      <li><a href="javascript:;" data-content="fa-wheelchair-alt" class="fa fa-wheelchair-alt"></a></li>
    </ul>
  </div>
  <div>
    <h2>运输交通类图标(18个)</h2>
    <ul>
      <li><a href="javascript:;" data-content="fa-ambulance" class="fa fa-ambulance"></a></li>
      <li><a href="javascript:;" data-content="fa-automobile" class="fa fa-automobile"></a></li>
      <li><a href="javascript:;" data-content="fa-bicycle" class="fa fa-bicycle"></a></li>
      <li><a href="javascript:;" data-content="fa-bus" class="fa fa-bus"></a></li>
      <li><a href="javascript:;" data-content="fa-cab" class="fa fa-cab"></a></li>
      <li><a href="javascript:;" data-content="fa-car" class="fa fa-car"></a></li>
      <li><a href="javascript:;" data-content="fa-fighter-jet" class="fa fa-fighter-jet"></a></li>
      <li><a href="javascript:;" data-content="fa-motorcycle" class="fa fa-motorcycle"></a></li>
      <li><a href="javascript:;" data-content="fa-plane" class="fa fa-plane"></a></li>
      <li><a href="javascript:;" data-content="fa-rocket" class="fa fa-rocket"></a></li>
      <li><a href="javascript:;" data-content="fa-ship" class="fa fa-ship"></a></li>
      <li><a href="javascript:;" data-content="fa-space-shuttle" class="fa fa-space-shuttle"></a></li>
      <li><a href="javascript:;" data-content="fa-subway" class="fa fa-subway"></a></li>
      <li><a href="javascript:;" data-content="fa-taxi" class="fa fa-taxi"></a></li>
      <li><a href="javascript:;" data-content="fa-train" class="fa fa-train"></a></li>
      <li><a href="javascript:;" data-content="fa-truck" class="fa fa-truck"></a></li>
      <li><a href="javascript:;" data-content="fa-wheelchair" class="fa fa-wheelchair"></a></li>
      <li><a href="javascript:;" data-content="fa-wheelchair-alt" class="fa fa-wheelchair-alt"></a></li>
    </ul>
  </div>
  <div>
    <h2>网页常用图标(431个)</h2>
    <ul>
      <li><a href="javascript:;" data-content="fa-address-book" class="fa fa-address-book"></a></li>
      <li><a href="javascript:;" data-content="fa-address-book-o" class="fa fa-address-book-o"></a></li>
      <li><a href="javascript:;" data-content="fa-address-card" class="fa fa-address-card"></a></li>
      <li><a href="javascript:;" data-content="fa-address-card-o" class="fa fa-address-card-o"></a></li>
      <li><a href="javascript:;" data-content="fa-adjust" class="fa fa-adjust"></a></li>
      <li><a href="javascript:;" data-content="fa-american-sign-language-interpreting" class="fa fa-american-sign-language-interpreting"></a></li>
      <li><a href="javascript:;" data-content="fa-anchor" class="fa fa-anchor"></a></li>
      <li><a href="javascript:;" data-content="fa-archive" class="fa fa-archive"></a></li>
      <li><a href="javascript:;" data-content="fa-area-chart" class="fa fa-area-chart"></a></li>
      <li><a href="javascript:;" data-content="fa-arrows" class="fa fa-arrows"></a></li>
      <li><a href="javascript:;" data-content="fa-arrows-h" class="fa fa-arrows-h"></a></li>
      <li><a href="javascript:;" data-content="fa-arrows-v" class="fa fa-arrows-v"></a></li>
      <li><a href="javascript:;" data-content="fa-assistive-listening-systems" class="fa fa-assistive-listening-systems"></a></li>
      <li><a href="javascript:;" data-content="fa-asterisk" class="fa fa-asterisk"></a></li>
      <li><a href="javascript:;" data-content="fa-at" class="fa fa-at"></a></li>
      <li><a href="javascript:;" data-content="fa-audio-description" class="fa fa-audio-description"></a></li>
      <li><a href="javascript:;" data-content="fa-automobile" class="fa fa-automobile"></a></li>
      <li><a href="javascript:;" data-content="fa-balance-scale" class="fa fa-balance-scale"></a></li>
      <li><a href="javascript:;" data-content="fa-ban" class="fa fa-ban"></a></li>
      <li><a href="javascript:;" data-content="fa-bank" class="fa fa-bank"></a></li>
      <li><a href="javascript:;" data-content="fa-bar-chart" class="fa fa-bar-chart"></a></li>
      <li><a href="javascript:;" data-content="fa-bar-chart-o" class="fa fa-bar-chart-o"></a></li>
      <li><a href="javascript:;" data-content="fa-barcode" class="fa fa-barcode"></a></li>
      <li><a href="javascript:;" data-content="fa-bars" class="fa fa-bars"></a></li>
      <li><a href="javascript:;" data-content="fa-bath" class="fa fa-bath"></a></li>
      <li><a href="javascript:;" data-content="fa-battery-0" class="fa fa-battery-0"></a></li>
      <li><a href="javascript:;" data-content="fa-battery-1" class="fa fa-battery-1"></a></li>
      <li><a href="javascript:;" data-content="fa-battery-2" class="fa fa-battery-2"></a></li>
      <li><a href="javascript:;" data-content="fa-battery-3" class="fa fa-battery-3"></a></li>
      <li><a href="javascript:;" data-content="fa-battery-4" class="fa fa-battery-4"></a></li>
      <li><a href="javascript:;" data-content="fa-battery-empty" class="fa fa-battery-empty"></a></li>
      <li><a href="javascript:;" data-content="fa-battery-full" class="fa fa-battery-full"></a></li>
      <li><a href="javascript:;" data-content="fa-battery-half" class="fa fa-battery-half"></a></li>
      <li><a href="javascript:;" data-content="fa-battery-quarter" class="fa fa-battery-quarter"></a></li>
      <li><a href="javascript:;" data-content="fa-battery-three-quarters" class="fa fa-battery-three-quarters"></a></li>
      <li><a href="javascript:;" data-content="fa-bed" class="fa fa-bed"></a></li>
      <li><a href="javascript:;" data-content="fa-beer" class="fa fa-beer"></a></li>
      <li><a href="javascript:;" data-content="fa-bell" class="fa fa-bell"></a></li>
      <li><a href="javascript:;" data-content="fa-bell-o" class="fa fa-bell-o"></a></li>
      <li><a href="javascript:;" data-content="fa-bell-slash" class="fa fa-bell-slash"></a></li>
      <li><a href="javascript:;" data-content="fa-bell-slash-o" class="fa fa-bell-slash-o"></a></li>
      <li><a href="javascript:;" data-content="fa-bicycle" class="fa fa-bicycle"></a></li>
      <li><a href="javascript:;" data-content="fa-binoculars" class="fa fa-binoculars"></a></li>
      <li><a href="javascript:;" data-content="fa-birthday-cake" class="fa fa-birthday-cake"></a></li>
      <li><a href="javascript:;" data-content="fa-blind" class="fa fa-blind"></a></li>
      <li><a href="javascript:;" data-content="fa-bluetooth" class="fa fa-bluetooth"></a></li>
      <li><a href="javascript:;" data-content="fa-bluetooth-b" class="fa fa-bluetooth-b"></a></li>
      <li><a href="javascript:;" data-content="fa-bolt" class="fa fa-bolt"></a></li>
      <li><a href="javascript:;" data-content="fa-bomb" class="fa fa-bomb"></a></li>
      <li><a href="javascript:;" data-content="fa-book" class="fa fa-book"></a></li>
      <li><a href="javascript:;" data-content="fa-bookmark" class="fa fa-bookmark"></a></li>
      <li><a href="javascript:;" data-content="fa-bookmark-o" class="fa fa-bookmark-o"></a></li>
      <li><a href="javascript:;" data-content="fa-braille" class="fa fa-braille"></a></li>
      <li><a href="javascript:;" data-content="fa-briefcase" class="fa fa-briefcase"></a></li>
      <li><a href="javascript:;" data-content="fa-bug" class="fa fa-bug"></a></li>
      <li><a href="javascript:;" data-content="fa-building" class="fa fa-building"></a></li>
      <li><a href="javascript:;" data-content="fa-building-o" class="fa fa-building-o"></a></li>
      <li><a href="javascript:;" data-content="fa-bullhorn" class="fa fa-bullhorn"></a></li>
      <li><a href="javascript:;" data-content="fa-bullseye" class="fa fa-bullseye"></a></li>
      <li><a href="javascript:;" data-content="fa-bus" class="fa fa-bus"></a></li>
      <li><a href="javascript:;" data-content="fa-cab" class="fa fa-cab"></a></li>
      <li><a href="javascript:;" data-content="fa-calculator" class="fa fa-calculator"></a></li>
      <li><a href="javascript:;" data-content="fa-calendar" class="fa fa-calendar"></a></li>
      <li><a href="javascript:;" data-content="fa-calendar-check-o" class="fa fa-calendar-check-o"></a></li>
      <li><a href="javascript:;" data-content="fa-calendar-minus-o" class="fa fa-calendar-minus-o"></a></li>
      <li><a href="javascript:;" data-content="fa-calendar-o" class="fa fa-calendar-o"></a></li>
      <li><a href="javascript:;" data-content="fa-calendar-plus-o" class="fa fa-calendar-plus-o"></a></li>
      <li><a href="javascript:;" data-content="fa-calendar-times-o" class="fa fa-calendar-times-o"></a></li>
      <li><a href="javascript:;" data-content="fa-camera" class="fa fa-camera"></a></li>
      <li><a href="javascript:;" data-content="fa-camera-retro" class="fa fa-camera-retro"></a></li>
      <li><a href="javascript:;" data-content="fa-car" class="fa fa-car"></a></li>
      <li><a href="javascript:;" data-content="fa-caret-square-o-down" class="fa fa-caret-square-o-down"></a></li>
      <li><a href="javascript:;" data-content="fa-caret-square-o-left" class="fa fa-caret-square-o-left"></a></li>
      <li><a href="javascript:;" data-content="fa-caret-square-o-right" class="fa fa-caret-square-o-right"></a></li>
      <li><a href="javascript:;" data-content="fa-caret-square-o-up" class="fa fa-caret-square-o-up"></a></li>
      <li><a href="javascript:;" data-content="fa-cart-arrow-down" class="fa fa-cart-arrow-down"></a></li>
      <li><a href="javascript:;" data-content="fa-cart-plus" class="fa fa-cart-plus"></a></li>
      <li><a href="javascript:;" data-content="fa-cc" class="fa fa-cc"></a></li>
      <li><a href="javascript:;" data-content="fa-certificate" class="fa fa-certificate"></a></li>
      <li><a href="javascript:;" data-content="fa-check" class="fa fa-check"></a></li>
      <li><a href="javascript:;" data-content="fa-check-circle" class="fa fa-check-circle"></a></li>
      <li><a href="javascript:;" data-content="fa-check-circle-o" class="fa fa-check-circle-o"></a></li>
      <li><a href="javascript:;" data-content="fa-check-square" class="fa fa-check-square"></a></li>
      <li><a href="javascript:;" data-content="fa-check-square-o" class="fa fa-check-square-o"></a></li>
      <li><a href="javascript:;" data-content="fa-child" class="fa fa-child"></a></li>
      <li><a href="javascript:;" data-content="fa-circle" class="fa fa-circle"></a></li>
      <li><a href="javascript:;" data-content="fa-circle-o" class="fa fa-circle-o"></a></li>
      <li><a href="javascript:;" data-content="fa-circle-o-notch" class="fa fa-circle-o-notch"></a></li>
      <li><a href="javascript:;" data-content="fa-circle-thin" class="fa fa-circle-thin"></a></li>
      <li><a href="javascript:;" data-content="fa-clock-o" class="fa fa-clock-o"></a></li>
      <li><a href="javascript:;" data-content="fa-clone" class="fa fa-clone"></a></li>
      <li><a href="javascript:;" data-content="fa-close" class="fa fa-close"></a></li>
      <li><a href="javascript:;" data-content="fa-cloud" class="fa fa-cloud"></a></li>
      <li><a href="javascript:;" data-content="fa-cloud-download" class="fa fa-cloud-download"></a></li>
      <li><a href="javascript:;" data-content="fa-cloud-upload" class="fa fa-cloud-upload"></a></li>
      <li><a href="javascript:;" data-content="fa-code" class="fa fa-code"></a></li>
      <li><a href="javascript:;" data-content="fa-code-fork" class="fa fa-code-fork"></a></li>
      <li><a href="javascript:;" data-content="fa-coffee" class="fa fa-coffee"></a></li>
      <li><a href="javascript:;" data-content="fa-cog" class="fa fa-cog"></a></li>
      <li><a href="javascript:;" data-content="fa-cogs" class="fa fa-cogs"></a></li>
      <li><a href="javascript:;" data-content="fa-comment" class="fa fa-comment"></a></li>
      <li><a href="javascript:;" data-content="fa-comment-o" class="fa fa-comment-o"></a></li>
      <li><a href="javascript:;" data-content="fa-commenting" class="fa fa-commenting"></a></li>
      <li><a href="javascript:;" data-content="fa-commenting-o" class="fa fa-commenting-o"></a></li>
      <li><a href="javascript:;" data-content="fa-comments" class="fa fa-comments"></a></li>
      <li><a href="javascript:;" data-content="fa-comments-o" class="fa fa-comments-o"></a></li>
      <li><a href="javascript:;" data-content="fa-compass" class="fa fa-compass"></a></li>
      <li><a href="javascript:;" data-content="fa-copyright" class="fa fa-copyright"></a></li>
      <li><a href="javascript:;" data-content="fa-creative-commons" class="fa fa-creative-commons"></a></li>
      <li><a href="javascript:;" data-content="fa-credit-card" class="fa fa-credit-card"></a></li>
      <li><a href="javascript:;" data-content="fa-crop" class="fa fa-crop"></a></li>
      <li><a href="javascript:;" data-content="fa-crosshairs" class="fa fa-crosshairs"></a></li>
      <li><a href="javascript:;" data-content="fa-cube" class="fa fa-cube"></a></li>
      <li><a href="javascript:;" data-content="fa-cubes" class="fa fa-cubes"></a></li>
      <li><a href="javascript:;" data-content="fa-cutlery" class="fa fa-cutlery"></a></li>
      <li><a href="javascript:;" data-content="fa-dashboard" class="fa fa-dashboard"></a></li>
      <li><a href="javascript:;" data-content="fa-database" class="fa fa-database"></a></li>
      <li><a href="javascript:;" data-content="fa-deaf" class="fa fa-deaf"></a></li>
      <li><a href="javascript:;" data-content="fa-deaf" class="fa fa-deaf"></a></li>
      <li><a href="javascript:;" data-content="fa-desktop" class="fa fa-desktop"></a></li>
      <li><a href="javascript:;" data-content="fa-diamond" class="fa fa-diamond"></a></li>
      <li><a href="javascript:;" data-content="fa-dot-circle-o" class="fa fa-dot-circle-o"></a></li>
      <li><a href="javascript:;" data-content="fa-download" class="fa fa-download"></a></li>
      <li><a href="javascript:;" data-content="fa-edit" class="fa fa-edit"></a></li>
      <li><a href="javascript:;" data-content="fa-ellipsis-h" class="fa fa-ellipsis-h"></a></li>
      <li><a href="javascript:;" data-content="fa-ellipsis-v" class="fa fa-ellipsis-v"></a></li>
      <li><a href="javascript:;" data-content="fa-envelope" class="fa fa-envelope"></a></li>
      <li><a href="javascript:;" data-content="fa-envelope-o" class="fa fa-envelope-o"></a></li>
      <li><a href="javascript:;" data-content="fa-envelope-open" class="fa fa-envelope-open"></a></li>
      <li><a href="javascript:;" data-content="fa-envelope-open-o" class="fa fa-envelope-open-o"></a></li>
      <li><a href="javascript:;" data-content="fa-envelope-square" class="fa fa-envelope-square"></a></li>
      <li><a href="javascript:;" data-content="fa-eraser" class="fa fa-eraser"></a></li>
      <li><a href="javascript:;" data-content="fa-exchange" class="fa fa-exchange"></a></li>
      <li><a href="javascript:;" data-content="fa-exclamation" class="fa fa-exclamation"></a></li>
      <li><a href="javascript:;" data-content="fa-exclamation-circle" class="fa fa-exclamation-circle"></a></li>
      <li><a href="javascript:;" data-content="fa-exclamation-triangle" class="fa fa-exclamation-triangle"></a></li>
      <li><a href="javascript:;" data-content="fa-external-link" class="fa fa-external-link"></a></li>
      <li><a href="javascript:;" data-content="fa-external-link-square" class="fa fa-external-link-square"></a></li>
      <li><a href="javascript:;" data-content="fa-eye" class="fa fa-eye"></a></li>
      <li><a href="javascript:;" data-content="fa-eye-slash" class="fa fa-eye-slash"></a></li>
      <li><a href="javascript:;" data-content="fa-eyedropper" class="fa fa-eyedropper"></a></li>
      <li><a href="javascript:;" data-content="fa-fax" class="fa fa-fax"></a></li>
      <li><a href="javascript:;" data-content="fa-feed" class="fa fa-feed"></a></li>
      <li><a href="javascript:;" data-content="fa-female" class="fa fa-female"></a></li>
      <li><a href="javascript:;" data-content="fa-fighter-jet" class="fa fa-fighter-jet"></a></li>
      <li><a href="javascript:;" data-content="fa-file-archive-o" class="fa fa-file-archive-o"></a></li>
      <li><a href="javascript:;" data-content="fa-file-audio-o" class="fa fa-file-audio-o"></a></li>
      <li><a href="javascript:;" data-content="fa-file-code-o" class="fa fa-file-code-o"></a></li>
      <li><a href="javascript:;" data-content="fa-file-excel-o" class="fa fa-file-excel-o"></a></li>
      <li><a href="javascript:;" data-content="fa-file-image-o" class="fa fa-file-image-o"></a></li>
      <li><a href="javascript:;" data-content="fa-file-movie-o" class="fa fa-file-movie-o"></a></li>
      <li><a href="javascript:;" data-content="fa-file-pdf-o" class="fa fa-file-pdf-o"></a></li>
      <li><a href="javascript:;" data-content="fa-file-photo-o" class="fa fa-file-photo-o"></a></li>
      <li><a href="javascript:;" data-content="fa-file-picture-o" class="fa fa-file-picture-o"></a></li>
      <li><a href="javascript:;" data-content="fa-file-powerpoint-o" class="fa fa-file-powerpoint-o"></a></li>
      <li><a href="javascript:;" data-content="fa-file-sound-o" class="fa fa-file-sound-o"></a></li>
      <li><a href="javascript:;" data-content="fa-file-video-o" class="fa fa-file-video-o"></a></li>
      <li><a href="javascript:;" data-content="fa-file-word-o" class="fa fa-file-word-o"></a></li>
      <li><a href="javascript:;" data-content="fa-file-zip-o" class="fa fa-file-zip-o"></a></li>
      <li><a href="javascript:;" data-content="fa-film" class="fa fa-film"></a></li>
      <li><a href="javascript:;" data-content="fa-filter" class="fa fa-filter"></a></li>
      <li><a href="javascript:;" data-content="fa-fire" class="fa fa-fire"></a></li>
      <li><a href="javascript:;" data-content="fa-fire-extinguisher" class="fa fa-fire-extinguisher"></a></li>
      <li><a href="javascript:;" data-content="fa-flag" class="fa fa-flag"></a></li>
      <li><a href="javascript:;" data-content="fa-flag-checkered" class="fa fa-flag-checkered"></a></li>
      <li><a href="javascript:;" data-content="fa-flag-o" class="fa fa-flag-o"></a></li>
      <li><a href="javascript:;" data-content="fa-flash" class="fa fa-flash"></a></li>
      <li><a href="javascript:;" data-content="fa-flask" class="fa fa-flask"></a></li>
      <li><a href="javascript:;" data-content="fa-folder" class="fa fa-folder"></a></li>
      <li><a href="javascript:;" data-content="fa-folder-o" class="fa fa-folder-o"></a></li>
      <li><a href="javascript:;" data-content="fa-folder-open" class="fa fa-folder-open"></a></li>
      <li><a href="javascript:;" data-content="fa-folder-open-o" class="fa fa-folder-open-o"></a></li>
      <li><a href="javascript:;" data-content="fa-frown-o" class="fa fa-frown-o"></a></li>
      <li><a href="javascript:;" data-content="fa-futbol-o" class="fa fa-futbol-o"></a></li>
      <li><a href="javascript:;" data-content="fa-gamepad" class="fa fa-gamepad"></a></li>
      <li><a href="javascript:;" data-content="fa-gavel" class="fa fa-gavel"></a></li>
      <li><a href="javascript:;" data-content="fa-gear" class="fa fa-gear"></a></li>
      <li><a href="javascript:;" data-content="fa-gears" class="fa fa-gears"></a></li>
      <li><a href="javascript:;" data-content="fa-gift" class="fa fa-gift"></a></li>
      <li><a href="javascript:;" data-content="fa-glass" class="fa fa-glass"></a></li>
      <li><a href="javascript:;" data-content="fa-globe" class="fa fa-globe"></a></li>
      <li><a href="javascript:;" data-content="fa-graduation-cap" class="fa fa-graduation-cap"></a></li>
      <li><a href="javascript:;" data-content="fa-group" class="fa fa-group"></a></li>
      <li><a href="javascript:;" data-content="fa-hand-grab-o" class="fa fa-hand-grab-o"></a></li>
      <li><a href="javascript:;" data-content="fa-hand-lizard-o" class="fa fa-hand-lizard-o"></a></li>
      <li><a href="javascript:;" data-content="fa-hand-paper-o" class="fa fa-hand-paper-o"></a></li>
      <li><a href="javascript:;" data-content="fa-hand-peace-o" class="fa fa-hand-peace-o"></a></li>
      <li><a href="javascript:;" data-content="fa-hand-pointer-o" class="fa fa-hand-pointer-o"></a></li>
      <li><a href="javascript:;" data-content="fa-hand-rock-o" class="fa fa-hand-rock-o"></a></li>
      <li><a href="javascript:;" data-content="fa-hand-scissors-o" class="fa fa-hand-scissors-o"></a></li>
      <li><a href="javascript:;" data-content="fa-hand-spock-o" class="fa fa-hand-spock-o"></a></li>
      <li><a href="javascript:;" data-content="fa-hand-stop-o" class="fa fa-hand-stop-o"></a></li>
      <li><a href="javascript:;" data-content="fa-handshake-o" class="fa fa-handshake-o"></a></li>
      <li><a href="javascript:;" data-content="fa-hdd-o" class="fa fa-hdd-o"></a></li>
      <li><a href="javascript:;" data-content="fa-headphones" class="fa fa-headphones"></a></li>
      <li><a href="javascript:;" data-content="fa-heart" class="fa fa-heart"></a></li>
      <li><a href="javascript:;" data-content="fa-heart-o" class="fa fa-heart-o"></a></li>
      <li><a href="javascript:;" data-content="fa-heartbeat" class="fa fa-heartbeat"></a></li>
      <li><a href="javascript:;" data-content="fa-history" class="fa fa-history"></a></li>
      <li><a href="javascript:;" data-content="fa-home" class="fa fa-home"></a></li>
      <li><a href="javascript:;" data-content="fa-hotel" class="fa fa-hotel"></a></li>
      <li><a href="javascript:;" data-content="fa-hourglass" class="fa fa-hourglass"></a></li>
      <li><a href="javascript:;" data-content="fa-hourglass-1" class="fa fa-hourglass-1"></a></li>
      <li><a href="javascript:;" data-content="fa-hourglass-2" class="fa fa-hourglass-2"></a></li>
      <li><a href="javascript:;" data-content="fa-hourglass-3" class="fa fa-hourglass-3"></a></li>
      <li><a href="javascript:;" data-content="fa-hourglass-end" class="fa fa-hourglass-end"></a></li>
      <li><a href="javascript:;" data-content="fa-hourglass-half" class="fa fa-hourglass-half"></a></li>
      <li><a href="javascript:;" data-content="fa-hourglass-o" class="fa fa-hourglass-o"></a></li>
      <li><a href="javascript:;" data-content="fa-hourglass-start" class="fa fa-hourglass-start"></a></li>
      <li><a href="javascript:;" data-content="fa-i-cursor" class="fa fa-i-cursor"></a></li>
      <li><a href="javascript:;" data-content="fa-id-badge" class="fa fa-id-badge"></a></li>
      <li><a href="javascript:;" data-content="fa-id-card" class="fa fa-id-card"></a></li>
      <li><a href="javascript:;" data-content="fa-id-card-o" class="fa fa-id-card-o"></a></li>
      <li><a href="javascript:;" data-content="fa-image" class="fa fa-image"></a></li>
      <li><a href="javascript:;" data-content="fa-inbox" class="fa fa-inbox"></a></li>
      <li><a href="javascript:;" data-content="fa-industry" class="fa fa-industry"></a></li>
      <li><a href="javascript:;" data-content="fa-info" class="fa fa-info"></a></li>
      <li><a href="javascript:;" data-content="fa-info-circle" class="fa fa-info-circle"></a></li>
      <li><a href="javascript:;" data-content="fa-institution" class="fa fa-institution"></a></li>
      <li><a href="javascript:;" data-content="fa-key" class="fa fa-key"></a></li>
      <li><a href="javascript:;" data-content="fa-keyboard-o" class="fa fa-keyboard-o"></a></li>
      <li><a href="javascript:;" data-content="fa-language" class="fa fa-language"></a></li>
      <li><a href="javascript:;" data-content="fa-laptop" class="fa fa-laptop"></a></li>
      <li><a href="javascript:;" data-content="fa-leaf" class="fa fa-leaf"></a></li>
      <li><a href="javascript:;" data-content="fa-legal" class="fa fa-legal"></a></li>
      <li><a href="javascript:;" data-content="fa-lemon-o" class="fa fa-lemon-o"></a></li>
      <li><a href="javascript:;" data-content="fa-level-down" class="fa fa-level-down"></a></li>
      <li><a href="javascript:;" data-content="fa-level-up" class="fa fa-level-up"></a></li>
      <li><a href="javascript:;" data-content="fa-life-bouy" class="fa fa-life-bouy"></a></li>
      <li><a href="javascript:;" data-content="fa-life-buoy" class="fa fa-life-buoy"></a></li>
      <li><a href="javascript:;" data-content="fa-life-ring" class="fa fa-life-ring"></a></li>
      <li><a href="javascript:;" data-content="fa-life-saver" class="fa fa-life-saver"></a></li>
      <li><a href="javascript:;" data-content="fa-lightbulb-o" class="fa fa-lightbulb-o"></a></li>
      <li><a href="javascript:;" data-content="fa-line-chart" class="fa fa-line-chart"></a></li>
      <li><a href="javascript:;" data-content="fa-location-arrow" class="fa fa-location-arrow"></a></li>
      <li><a href="javascript:;" data-content="fa-lock" class="fa fa-lock"></a></li>
      <li><a href="javascript:;" data-content="fa-low-vision" class="fa fa-low-vision"></a></li>
      <li><a href="javascript:;" data-content="fa-magic" class="fa fa-magic"></a></li>
      <li><a href="javascript:;" data-content="fa-magnet" class="fa fa-magnet"></a></li>
      <li><a href="javascript:;" data-content="fa-mail-forward" class="fa fa-mail-forward"></a></li>
      <li><a href="javascript:;" data-content="fa-mail-reply" class="fa fa-mail-reply"></a></li>
      <li><a href="javascript:;" data-content="fa-mail-reply-all" class="fa fa-mail-reply-all"></a></li>
      <li><a href="javascript:;" data-content="fa-male" class="fa fa-male"></a></li>
      <li><a href="javascript:;" data-content="fa-map" class="fa fa-map"></a></li>
      <li><a href="javascript:;" data-content="fa-map-marker" class="fa fa-map-marker"></a></li>
      <li><a href="javascript:;" data-content="fa-map-o" class="fa fa-map-o"></a></li>
      <li><a href="javascript:;" data-content="fa-map-pin" class="fa fa-map-pin"></a></li>
      <li><a href="javascript:;" data-content="fa-map-signs" class="fa fa-map-signs"></a></li>
      <li><a href="javascript:;" data-content="fa-meetup" class="fa fa-meetup"></a></li>
      <li><a href="javascript:;" data-content="fa-meh-o" class="fa fa-meh-o"></a></li>
      <li><a href="javascript:;" data-content="fa-microchip" class="fa fa-microchip"></a></li>
      <li><a href="javascript:;" data-content="fa-microphone" class="fa fa-microphone"></a></li>
      <li><a href="javascript:;" data-content="fa-microphone-slash" class="fa fa-microphone-slash"></a></li>
      <li><a href="javascript:;" data-content="fa-minus" class="fa fa-minus"></a></li>
      <li><a href="javascript:;" data-content="fa-minus-circle" class="fa fa-minus-circle"></a></li>
      <li><a href="javascript:;" data-content="fa-minus-square" class="fa fa-minus-square"></a></li>
      <li><a href="javascript:;" data-content="fa-minus-square-o" class="fa fa-minus-square-o"></a></li>
      <li><a href="javascript:;" data-content="fa-mobile" class="fa fa-mobile"></a></li>
      <li><a href="javascript:;" data-content="fa-mobile-phone" class="fa fa-mobile-phone"></a></li>
      <li><a href="javascript:;" data-content="fa-money" class="fa fa-money"></a></li>
      <li><a href="javascript:;" data-content="fa-moon-o" class="fa fa-moon-o"></a></li>
      <li><a href="javascript:;" data-content="fa-mortar-board" class="fa fa-mortar-board"></a></li>
      <li><a href="javascript:;" data-content="fa-motorcycle" class="fa fa-motorcycle"></a></li>
      <li><a href="javascript:;" data-content="fa-mouse-pointer" class="fa fa-mouse-pointer"></a></li>
      <li><a href="javascript:;" data-content="fa-music" class="fa fa-music"></a></li>
      <li><a href="javascript:;" data-content="fa-navicon" class="fa fa-navicon"></a></li>
      <li><a href="javascript:;" data-content="fa-newspaper-o" class="fa fa-newspaper-o"></a></li>
      <li><a href="javascript:;" data-content="fa-object-group" class="fa fa-object-group"></a></li>
      <li><a href="javascript:;" data-content="fa-object-ungroup" class="fa fa-object-ungroup"></a></li>
      <li><a href="javascript:;" data-content="fa-paint-brush" class="fa fa-paint-brush"></a></li>
      <li><a href="javascript:;" data-content="fa-paper-plane" class="fa fa-paper-plane"></a></li>
      <li><a href="javascript:;" data-content="fa-paper-plane-o" class="fa fa-paper-plane-o"></a></li>
      <li><a href="javascript:;" data-content="fa-paw" class="fa fa-paw"></a></li>
      <li><a href="javascript:;" data-content="fa-pencil" class="fa fa-pencil"></a></li>
      <li><a href="javascript:;" data-content="fa-pencil-square" class="fa fa-pencil-square"></a></li>
      <li><a href="javascript:;" data-content="fa-pencil-square-o" class="fa fa-pencil-square-o"></a></li>
      <li><a href="javascript:;" data-content="fa-percent" class="fa fa-percent"></a></li>
      <li><a href="javascript:;" data-content="fa-phone" class="fa fa-phone"></a></li>
      <li><a href="javascript:;" data-content="fa-phone-square" class="fa fa-phone-square"></a></li>
      <li><a href="javascript:;" data-content="fa-photo" class="fa fa-photo"></a></li>
      <li><a href="javascript:;" data-content="fa-picture-o" class="fa fa-picture-o"></a></li>
      <li><a href="javascript:;" data-content="fa-pie-chart" class="fa fa-pie-chart"></a></li>
      <li><a href="javascript:;" data-content="fa-plane" class="fa fa-plane"></a></li>
      <li><a href="javascript:;" data-content="fa-plug" class="fa fa-plug"></a></li>
      <li><a href="javascript:;" data-content="fa-plus" class="fa fa-plus"></a></li>
      <li><a href="javascript:;" data-content="fa-plus-circle" class="fa fa-plus-circle"></a></li>
      <li><a href="javascript:;" data-content="fa-plus-square" class="fa fa-plus-square"></a></li>
      <li><a href="javascript:;" data-content="fa-plus-square-o" class="fa fa-plus-square-o"></a></li>
      <li><a href="javascript:;" data-content="fa-podcast" class="fa fa-podcast"></a></li>
      <li><a href="javascript:;" data-content="fa-power-off" class="fa fa-power-off"></a></li>
      <li><a href="javascript:;" data-content="fa-print" class="fa fa-print"></a></li>
      <li><a href="javascript:;" data-content="fa-puzzle-piece" class="fa fa-puzzle-piece"></a></li>
      <li><a href="javascript:;" data-content="fa-qrcode" class="fa fa-qrcode"></a></li>
      <li><a href="javascript:;" data-content="fa-question" class="fa fa-question"></a></li>
      <li><a href="javascript:;" data-content="fa-question-circle" class="fa fa-question-circle"></a></li>
      <li><a href="javascript:;" data-content="fa-question-circle-o" class="fa fa-question-circle-o"></a></li>
      <li><a href="javascript:;" data-content="fa-quote-left" class="fa fa-quote-left"></a></li>
      <li><a href="javascript:;" data-content="fa-quote-right" class="fa fa-quote-right"></a></li>
      <li><a href="javascript:;" data-content="fa-random" class="fa fa-random"></a></li>
      <li><a href="javascript:;" data-content="fa-recycle" class="fa fa-recycle"></a></li>
      <li><a href="javascript:;" data-content="fa-refresh" class="fa fa-refresh"></a></li>
      <li><a href="javascript:;" data-content="fa-registered" class="fa fa-registered"></a></li>
      <li><a href="javascript:;" data-content="fa-remove" class="fa fa-remove"></a></li>
      <li><a href="javascript:;" data-content="fa-reorder" class="fa fa-reorder"></a></li>
      <li><a href="javascript:;" data-content="fa-reply" class="fa fa-reply"></a></li>
      <li><a href="javascript:;" data-content="fa-reply-all" class="fa fa-reply-all"></a></li>
      <li><a href="javascript:;" data-content="fa-retweet" class="fa fa-retweet"></a></li>
      <li><a href="javascript:;" data-content="fa-road" class="fa fa-road"></a></li>
      <li><a href="javascript:;" data-content="fa-rocket" class="fa fa-rocket"></a></li>
      <li><a href="javascript:;" data-content="fa-rss" class="fa fa-rss"></a></li>
      <li><a href="javascript:;" data-content="fa-rss-square" class="fa fa-rss-square"></a></li>
      <li><a href="javascript:;" data-content="fa-search" class="fa fa-search"></a></li>
      <li><a href="javascript:;" data-content="fa-search-minus" class="fa fa-search-minus"></a></li>
      <li><a href="javascript:;" data-content="fa-search-plus" class="fa fa-search-plus"></a></li>
      <li><a href="javascript:;" data-content="fa-send" class="fa fa-send"></a></li>
      <li><a href="javascript:;" data-content="fa-send-o" class="fa fa-send-o"></a></li>
      <li><a href="javascript:;" data-content="fa-server" class="fa fa-server"></a></li>
      <li><a href="javascript:;" data-content="fa-share" class="fa fa-share"></a></li>
      <li><a href="javascript:;" data-content="fa-share-alt" class="fa fa-share-alt"></a></li>
      <li><a href="javascript:;" data-content="fa-share-alt-square" class="fa fa-share-alt-square"></a></li>
      <li><a href="javascript:;" data-content="fa-share-square" class="fa fa-share-square"></a></li>
      <li><a href="javascript:;" data-content="fa-share-square-o" class="fa fa-share-square-o"></a></li>
      <li><a href="javascript:;" data-content="fa-shield" class="fa fa-shield"></a></li>
      <li><a href="javascript:;" data-content="fa-ship" class="fa fa-ship"></a></li>
      <li><a href="javascript:;" data-content="fa-shopping-bag" class="fa fa-shopping-bag"></a></li>
      <li><a href="javascript:;" data-content="fa-shopping-basket" class="fa fa-shopping-basket"></a></li>
      <li><a href="javascript:;" data-content="fa-shopping-cart" class="fa fa-shopping-cart"></a></li>
      <li><a href="javascript:;" data-content="fa-shower" class="fa fa-shower"></a></li>
      <li><a href="javascript:;" data-content="fa-sign-in" class="fa fa-sign-in"></a></li>
      <li><a href="javascript:;" data-content="fa-sign-out" class="fa fa-sign-out"></a></li>
      <li><a href="javascript:;" data-content="fa-signal" class="fa fa-signal"></a></li>
      <li><a href="javascript:;" data-content="fa-sitemap" class="fa fa-sitemap"></a></li>
      <li><a href="javascript:;" data-content="fa-sliders" class="fa fa-sliders"></a></li>
      <li><a href="javascript:;" data-content="fa-smile-o" class="fa fa-smile-o"></a></li>
      <li><a href="javascript:;" data-content="fa-snowflake-o" class="fa fa-snowflake-o"></a></li>
      <li><a href="javascript:;" data-content="fa-soccer-ball-o" class="fa fa-soccer-ball-o"></a></li>
      <li><a href="javascript:;" data-content="fa-sort" class="fa fa-sort"></a></li>
      <li><a href="javascript:;" data-content="fa-sort-alpha-asc" class="fa fa-sort-alpha-asc"></a></li>
      <li><a href="javascript:;" data-content="fa-sort-alpha-desc" class="fa fa-sort-alpha-desc"></a></li>
      <li><a href="javascript:;" data-content="fa-sort-amount-asc" class="fa fa-sort-amount-asc"></a></li>
      <li><a href="javascript:;" data-content="fa-sort-amount-desc" class="fa fa-sort-amount-desc"></a></li>
      <li><a href="javascript:;" data-content="fa-sort-asc" class="fa fa-sort-asc"></a></li>
      <li><a href="javascript:;" data-content="fa-sort-desc" class="fa fa-sort-desc"></a></li>
      <li><a href="javascript:;" data-content="fa-sort-down" class="fa fa-sort-down"></a></li>
      <li><a href="javascript:;" data-content="fa-sort-numeric-asc" class="fa fa-sort-numeric-asc"></a></li>
      <li><a href="javascript:;" data-content="fa-sort-numeric-desc" class="fa fa-sort-numeric-desc"></a></li>
      <li><a href="javascript:;" data-content="fa-sort-up" class="fa fa-sort-up"></a></li>
      <li><a href="javascript:;" data-content="fa-space-shuttle" class="fa fa-space-shuttle"></a></li>
      <li><a href="javascript:;" data-content="fa-spinner" class="fa fa-spinner"></a></li>
      <li><a href="javascript:;" data-content="fa-spoon" class="fa fa-spoon"></a></li>
      <li><a href="javascript:;" data-content="fa-square" class="fa fa-square"></a></li>
      <li><a href="javascript:;" data-content="fa-square-o" class="fa fa-square-o"></a></li>
      <li><a href="javascript:;" data-content="fa-star" class="fa fa-star"></a></li>
      <li><a href="javascript:;" data-content="fa-star-half" class="fa fa-star-half"></a></li>
      <li><a href="javascript:;" data-content="fa-star-half-empty" class="fa fa-star-half-empty"></a></li>
      <li><a href="javascript:;" data-content="fa-star-half-full" class="fa fa-star-half-full"></a></li>
      <li><a href="javascript:;" data-content="fa-star-half-o" class="fa fa-star-half-o"></a></li>
      <li><a href="javascript:;" data-content="fa-star-o" class="fa fa-star-o"></a></li>
      <li><a href="javascript:;" data-content="fa-sticky-note" class="fa fa-sticky-note"></a></li>
      <li><a href="javascript:;" data-content="fa-sticky-note-o" class="fa fa-sticky-note-o"></a></li>
      <li><a href="javascript:;" data-content="fa-street-view" class="fa fa-street-view"></a></li>
      <li><a href="javascript:;" data-content="fa-suitcase" class="fa fa-suitcase"></a></li>
      <li><a href="javascript:;" data-content="fa-sun-o" class="fa fa-sun-o"></a></li>
      <li><a href="javascript:;" data-content="fa-support" class="fa fa-support"></a></li>
      <li><a href="javascript:;" data-content="fa-tablet" class="fa fa-tablet"></a></li>
      <li><a href="javascript:;" data-content="fa-tachometer" class="fa fa-tachometer"></a></li>
      <li><a href="javascript:;" data-content="fa-tag" class="fa fa-tag"></a></li>
      <li><a href="javascript:;" data-content="fa-tags" class="fa fa-tags"></a></li>
      <li><a href="javascript:;" data-content="fa-tasks" class="fa fa-tasks"></a></li>
      <li><a href="javascript:;" data-content="fa-taxi" class="fa fa-taxi"></a></li>
      <li><a href="javascript:;" data-content="fa-television" class="fa fa-television"></a></li>
      <li><a href="javascript:;" data-content="fa-terminal" class="fa fa-terminal"></a></li>
      <li><a href="javascript:;" data-content="fa-thermometer-empty" class="fa fa-thermometer-empty"></a></li>
      <li><a href="javascript:;" data-content="fa-thermometer-full" class="fa fa-thermometer-full"></a></li>
      <li><a href="javascript:;" data-content="fa-thermometer-half" class="fa fa-thermometer-half"></a></li>
      <li><a href="javascript:;" data-content="fa-thermometer-quarter" class="fa fa-thermometer-quarter"></a></li>
      <li><a href="javascript:;" data-content="fa-thermometer-three-quarters" class="fa fa-thermometer-three-quarters"></a></li>
      <li><a href="javascript:;" data-content="fa-thumb-tack" class="fa fa-thumb-tack"></a></li>
      <li><a href="javascript:;" data-content="fa-thumbs-down" class="fa fa-thumbs-down"></a></li>
      <li><a href="javascript:;" data-content="fa-thumbs-o-down" class="fa fa-thumbs-o-down"></a></li>
      <li><a href="javascript:;" data-content="fa-thumbs-o-up" class="fa fa-thumbs-o-up"></a></li>
      <li><a href="javascript:;" data-content="fa-thumbs-up" class="fa fa-thumbs-up"></a></li>
      <li><a href="javascript:;" data-content="fa-ticket" class="fa fa-ticket"></a></li>
      <li><a href="javascript:;" data-content="fa-times" class="fa fa-times"></a></li>
      <li><a href="javascript:;" data-content="fa-times-circle" class="fa fa-times-circle"></a></li>
      <li><a href="javascript:;" data-content="fa-times-circle-o" class="fa fa-times-circle-o"></a></li>
      <li><a href="javascript:;" data-content="fa-tint" class="fa fa-tint"></a></li>
      <li><a href="javascript:;" data-content="fa-toggle-down" class="fa fa-toggle-down"></a></li>
      <li><a href="javascript:;" data-content="fa-toggle-left" class="fa fa-toggle-left"></a></li>
      <li><a href="javascript:;" data-content="fa-toggle-off" class="fa fa-toggle-off"></a></li>
      <li><a href="javascript:;" data-content="fa-toggle-on" class="fa fa-toggle-on"></a></li>
      <li><a href="javascript:;" data-content="fa-toggle-right" class="fa fa-toggle-right"></a></li>
      <li><a href="javascript:;" data-content="fa-toggle-up" class="fa fa-toggle-up"></a></li>
      <li><a href="javascript:;" data-content="fa-trademark" class="fa fa-trademark"></a></li>
      <li><a href="javascript:;" data-content="fa-trash" class="fa fa-trash"></a></li>
      <li><a href="javascript:;" data-content="fa-trash-o" class="fa fa-trash-o"></a></li>
      <li><a href="javascript:;" data-content="fa-tree" class="fa fa-tree"></a></li>
      <li><a href="javascript:;" data-content="fa-trophy" class="fa fa-trophy"></a></li>
      <li><a href="javascript:;" data-content="fa-truck" class="fa fa-truck"></a></li>
      <li><a href="javascript:;" data-content="fa-tty" class="fa fa-tty"></a></li>
      <li><a href="javascript:;" data-content="fa-tv" class="fa fa-tv"></a></li>
      <li><a href="javascript:;" data-content="fa-umbrella" class="fa fa-umbrella"></a></li>
      <li><a href="javascript:;" data-content="fa-universal-access" class="fa fa-universal-access"></a></li>
      <li><a href="javascript:;" data-content="fa-university" class="fa fa-university"></a></li>
      <li><a href="javascript:;" data-content="fa-unlock" class="fa fa-unlock"></a></li>
      <li><a href="javascript:;" data-content="fa-unlock-alt" class="fa fa-unlock-alt"></a></li>
      <li><a href="javascript:;" data-content="fa-unsorted" class="fa fa-unsorted"></a></li>
      <li><a href="javascript:;" data-content="fa-upload" class="fa fa-upload"></a></li>
      <li><a href="javascript:;" data-content="fa-user" class="fa fa-user"></a></li>
      <li><a href="javascript:;" data-content="fa-user-circle" class="fa fa-user-circle"></a></li>
      <li><a href="javascript:;" data-content="fa-user-circle-o" class="fa fa-user-circle-o"></a></li>
      <li><a href="javascript:;" data-content="fa-user-o" class="fa fa-user-o"></a></li>
      <li><a href="javascript:;" data-content="fa-user-plus" class="fa fa-user-plus"></a></li>
      <li><a href="javascript:;" data-content="fa-user-secret" class="fa fa-user-secret"></a></li>
      <li><a href="javascript:;" data-content="fa-user-times" class="fa fa-user-times"></a></li>
      <li><a href="javascript:;" data-content="fa-users" class="fa fa-users"></a></li>
      <li><a href="javascript:;" data-content="fa-video-camera" class="fa fa-video-camera"></a></li>
      <li><a href="javascript:;" data-content="fa-volume-control-phone" class="fa fa-volume-control-phone"></a></li>
      <li><a href="javascript:;" data-content="fa-volume-down" class="fa fa-volume-down"></a></li>
      <li><a href="javascript:;" data-content="fa-volume-off" class="fa fa-volume-off"></a></li>
      <li><a href="javascript:;" data-content="fa-volume-up" class="fa fa-volume-up"></a></li>
      <li><a href="javascript:;" data-content="fa-warning" class="fa fa-warning"></a></li>
      <li><a href="javascript:;" data-content="fa-wheelchair" class="fa fa-wheelchair"></a></li>
      <li><a href="javascript:;" data-content="fa-wheelchair-alt" class="fa fa-wheelchair-alt"></a></li>
      <li><a href="javascript:;" data-content="fa-wifi" class="fa fa-wifi"></a></li>
      <li><a href="javascript:;" data-content="fa-window-close" class="fa fa-window-close"></a></li>
      <li><a href="javascript:;" data-content="fa-window-close-o" class="fa fa-window-close-o"></a></li>
      <li><a href="javascript:;" data-content="fa-window-maximize" class="fa fa-window-maximize"></a></li>
      <li><a href="javascript:;" data-content="fa-window-minimize" class="fa fa-window-minimize"></a></li>
      <li><a href="javascript:;" data-content="fa-window-restore" class="fa fa-window-restore"></a></li>
      <li><a href="javascript:;" data-content="fa-wrench" class="fa fa-wrench"></a></li>
    </ul>
  </div>
  <div>
    <h2>表单控制类图标(11个)</h2>
    <ul>
      <li><a href="javascript:;" data-content="fa-check-square" class="fa fa-check-square"></a></li>
      <li><a href="javascript:;" data-content="fa-check-square-o" class="fa fa-check-square-o"></a></li>
      <li><a href="javascript:;" data-content="fa-circle" class="fa fa-circle"></a></li>
      <li><a href="javascript:;" data-content="fa-circle-o" class="fa fa-circle-o"></a></li>
      <li><a href="javascript:;" data-content="fa-dot-circle-o" class="fa fa-dot-circle-o"></a></li>
      <li><a href="javascript:;" data-content="fa-minus-square" class="fa fa-minus-square"></a></li>
      <li><a href="javascript:;" data-content="fa-minus-square-o" class="fa fa-minus-square-o"></a></li>
      <li><a href="javascript:;" data-content="fa-plus-square" class="fa fa-plus-square"></a></li>
      <li><a href="javascript:;" data-content="fa-plus-square-o" class="fa fa-plus-square-o"></a></li>
      <li><a href="javascript:;" data-content="fa-square" class="fa fa-square"></a></li>
      <li><a href="javascript:;" data-content="fa-square-o" class="fa fa-square-o"></a></li>
    </ul>
  </div>
  <div>
    <h2>方向箭头图标(53个)</h2>
    <ul>
      <li><a href="javascript:;" data-content="fa-angle-double-down" class="fa fa-angle-double-down"></a></li>
      <li><a href="javascript:;" data-content="fa-angle-double-left" class="fa fa-angle-double-left"></a></li>
      <li><a href="javascript:;" data-content="fa-angle-double-right" class="fa fa-angle-double-right"></a></li>
      <li><a href="javascript:;" data-content="fa-angle-double-up" class="fa fa-angle-double-up"></a></li>
      <li><a href="javascript:;" data-content="fa-angle-down" class="fa fa-angle-down"></a></li>
      <li><a href="javascript:;" data-content="fa-angle-left" class="fa fa-angle-left"></a></li>
      <li><a href="javascript:;" data-content="fa-angle-right" class="fa fa-angle-right"></a></li>
      <li><a href="javascript:;" data-content="fa-angle-up" class="fa fa-angle-up"></a></li>
      <li><a href="javascript:;" data-content="fa-arrow-circle-down" class="fa fa-arrow-circle-down"></a></li>
      <li><a href="javascript:;" data-content="fa-arrow-circle-left" class="fa fa-arrow-circle-left"></a></li>
      <li><a href="javascript:;" data-content="fa-arrow-circle-o-down" class="fa fa-arrow-circle-o-down"></a></li>
      <li><a href="javascript:;" data-content="fa-arrow-circle-o-left" class="fa fa-arrow-circle-o-left"></a></li>
      <li><a href="javascript:;" data-content="fa-arrow-circle-o-right" class="fa fa-arrow-circle-o-right"></a></li>
      <li><a href="javascript:;" data-content="fa-arrow-circle-o-up" class="fa fa-arrow-circle-o-up"></a></li>
      <li><a href="javascript:;" data-content="fa-arrow-circle-right" class="fa fa-arrow-circle-right"></a></li>
      <li><a href="javascript:;" data-content="fa-arrow-circle-up" class="fa fa-arrow-circle-up"></a></li>
      <li><a href="javascript:;" data-content="fa-arrow-down" class="fa fa-arrow-down"></a></li>
      <li><a href="javascript:;" data-content="fa-arrow-left" class="fa fa-arrow-left"></a></li>
      <li><a href="javascript:;" data-content="fa-arrow-right" class="fa fa-arrow-right"></a></li>
      <li><a href="javascript:;" data-content="fa-arrow-up" class="fa fa-arrow-up"></a></li>
      <li><a href="javascript:;" data-content="fa-arrows" class="fa fa-arrows"></a></li>
      <li><a href="javascript:;" data-content="fa-arrows-alt" class="fa fa-arrows-alt"></a></li>
      <li><a href="javascript:;" data-content="fa-arrows-h" class="fa fa-arrows-h"></a></li>
      <li><a href="javascript:;" data-content="fa-arrows-v" class="fa fa-arrows-v"></a></li>
      <li><a href="javascript:;" data-content="fa-caret-down" class="fa fa-caret-down"></a></li>
      <li><a href="javascript:;" data-content="fa-caret-left" class="fa fa-caret-left"></a></li>
      <li><a href="javascript:;" data-content="fa-caret-right" class="fa fa-caret-right"></a></li>
      <li><a href="javascript:;" data-content="fa-caret-square-o-down" class="fa fa-caret-square-o-down"></a></li>
      <li><a href="javascript:;" data-content="fa-caret-square-o-left" class="fa fa-caret-square-o-left"></a></li>
      <li><a href="javascript:;" data-content="fa-caret-square-o-right" class="fa fa-caret-square-o-right"></a></li>
      <li><a href="javascript:;" data-content="fa-caret-square-o-up" class="fa fa-caret-square-o-up"></a></li>
      <li><a href="javascript:;" data-content="fa-caret-up" class="fa fa-caret-up"></a></li>
      <li><a href="javascript:;" data-content="fa-chevron-circle-down" class="fa fa-chevron-circle-down"></a></li>
      <li><a href="javascript:;" data-content="fa-chevron-circle-left" class="fa fa-chevron-circle-left"></a></li>
      <li><a href="javascript:;" data-content="fa-chevron-circle-right" class="fa fa-chevron-circle-right"></a></li>
      <li><a href="javascript:;" data-content="fa-chevron-circle-up" class="fa fa-chevron-circle-up"></a></li>
      <li><a href="javascript:;" data-content="fa-chevron-down" class="fa fa-chevron-down"></a></li>
      <li><a href="javascript:;" data-content="fa-chevron-left" class="fa fa-chevron-left"></a></li>
      <li><a href="javascript:;" data-content="fa-chevron-right" class="fa fa-chevron-right"></a></li>
      <li><a href="javascript:;" data-content="fa-chevron-up" class="fa fa-chevron-up"></a></li>
      <li><a href="javascript:;" data-content="fa-exchange" class="fa fa-exchange"></a></li>
      <li><a href="javascript:;" data-content="fa-hand-o-down" class="fa fa-hand-o-down"></a></li>
      <li><a href="javascript:;" data-content="fa-hand-o-left" class="fa fa-hand-o-left"></a></li>
      <li><a href="javascript:;" data-content="fa-hand-o-right" class="fa fa-hand-o-right"></a></li>
      <li><a href="javascript:;" data-content="fa-hand-o-up" class="fa fa-hand-o-up"></a></li>
      <li><a href="javascript:;" data-content="fa-long-arrow-down" class="fa fa-long-arrow-down"></a></li>
      <li><a href="javascript:;" data-content="fa-long-arrow-left" class="fa fa-long-arrow-left"></a></li>
      <li><a href="javascript:;" data-content="fa-long-arrow-right" class="fa fa-long-arrow-right"></a></li>
      <li><a href="javascript:;" data-content="fa-long-arrow-up" class="fa fa-long-arrow-up"></a></li>
      <li><a href="javascript:;" data-content="fa-toggle-down" class="fa fa-toggle-down"></a></li>
      <li><a href="javascript:;" data-content="fa-toggle-left" class="fa fa-toggle-left"></a></li>
      <li><a href="javascript:;" data-content="fa-toggle-right" class="fa fa-toggle-right"></a></li>
      <li><a href="javascript:;" data-content="fa-toggle-up" class="fa fa-toggle-up"></a></li>
    </ul>
  </div>
  <div>
    <h2>视频播放器图标(21个)</h2>
    <ul>
      <li><a href="javascript:;" data-content="fa-arrows-alt" class="fa fa-arrows-alt"></a></li>
      <li><a href="javascript:;" data-content="fa-backward" class="fa fa-backward"></a></li>
      <li><a href="javascript:;" data-content="fa-compress" class="fa fa-compress"></a></li>
      <li><a href="javascript:;" data-content="fa-eject" class="fa fa-eject"></a></li>
      <li><a href="javascript:;" data-content="fa-expand" class="fa fa-expand"></a></li>
      <li><a href="javascript:;" data-content="fa-fast-backward" class="fa fa-fast-backward"></a></li>
      <li><a href="javascript:;" data-content="fa-fast-forward" class="fa fa-fast-forward"></a></li>
      <li><a href="javascript:;" data-content="fa-forward" class="fa fa-forward"></a></li>
      <li><a href="javascript:;" data-content="fa-pause" class="fa fa-pause"></a></li>
      <li><a href="javascript:;" data-content="fa-pause-circle" class="fa fa-pause-circle"></a></li>
      <li><a href="javascript:;" data-content="fa-pause-circle-o" class="fa fa-pause-circle-o"></a></li>
      <li><a href="javascript:;" data-content="fa-play" class="fa fa-play"></a></li>
      <li><a href="javascript:;" data-content="fa-play-circle" class="fa fa-play-circle"></a></li>
      <li><a href="javascript:;" data-content="fa-play-circle-o" class="fa fa-play-circle-o"></a></li>
      <li><a href="javascript:;" data-content="fa-random" class="fa fa-random"></a></li>
      <li><a href="javascript:;" data-content="fa-step-backward" class="fa fa-step-backward"></a></li>
      <li><a href="javascript:;" data-content="fa-step-forward" class="fa fa-step-forward"></a></li>
      <li><a href="javascript:;" data-content="fa-stop" class="fa fa-stop"></a></li>
      <li><a href="javascript:;" data-content="fa-stop-circle" class="fa fa-stop-circle"></a></li>
      <li><a href="javascript:;" data-content="fa-stop-circle-o" class="fa fa-stop-circle-o"></a></li>
      <li><a href="javascript:;" data-content="fa-youtube-play" class="fa fa-youtube-play"></a></li>
    </ul>
  </div>
  <div>
    <h2>品牌类图标(190个)</h2>
    <ul>
      <li><a href="javascript:;" data-content="fa-500px" class="fa fa-500px"></a></li>
      <li><a href="javascript:;" data-content="fa-adn" class="fa fa-adn"></a></li>
      <li><a href="javascript:;" data-content="fa-amazon" class="fa fa-amazon"></a></li>
      <li><a href="javascript:;" data-content="fa-android" class="fa fa-android"></a></li>
      <li><a href="javascript:;" data-content="fa-angellist" class="fa fa-angellist"></a></li>
      <li><a href="javascript:;" data-content="fa-apple" class="fa fa-apple"></a></li>
      <li><a href="javascript:;" data-content="fa-bandcamp" class="fa fa-bandcamp"></a></li>
      <li><a href="javascript:;" data-content="fa-behance" class="fa fa-behance"></a></li>
      <li><a href="javascript:;" data-content="fa-behance-square" class="fa fa-behance-square"></a></li>
      <li><a href="javascript:;" data-content="fa-bitbucket" class="fa fa-bitbucket"></a></li>
      <li><a href="javascript:;" data-content="fa-bitbucket-square" class="fa fa-bitbucket-square"></a></li>
      <li><a href="javascript:;" data-content="fa-bitcoin" class="fa fa-bitcoin"></a></li>
      <li><a href="javascript:;" data-content="fa-black-tie" class="fa fa-black-tie"></a></li>
      <li><a href="javascript:;" data-content="fa-bluetooth" class="fa fa-bluetooth"></a></li>
      <li><a href="javascript:;" data-content="fa-bluetooth-b" class="fa fa-bluetooth-b"></a></li>
      <li><a href="javascript:;" data-content="fa-btc" class="fa fa-btc"></a></li>
      <li><a href="javascript:;" data-content="fa-buysellads" class="fa fa-buysellads"></a></li>
      <li><a href="javascript:;" data-content="fa-cc-amex" class="fa fa-cc-amex"></a></li>
      <li><a href="javascript:;" data-content="fa-cc-diners-club" class="fa fa-cc-diners-club"></a></li>
      <li><a href="javascript:;" data-content="fa-cc-discover" class="fa fa-cc-discover"></a></li>
      <li><a href="javascript:;" data-content="fa-cc-jcb" class="fa fa-cc-jcb"></a></li>
      <li><a href="javascript:;" data-content="fa-cc-mastercard" class="fa fa-cc-mastercard"></a></li>
      <li><a href="javascript:;" data-content="fa-cc-paypal" class="fa fa-cc-paypal"></a></li>
      <li><a href="javascript:;" data-content="fa-cc-stripe" class="fa fa-cc-stripe"></a></li>
      <li><a href="javascript:;" data-content="fa-cc-visa" class="fa fa-cc-visa"></a></li>
      <li><a href="javascript:;" data-content="fa-chrome" class="fa fa-chrome"></a></li>
      <li><a href="javascript:;" data-content="fa-codepen" class="fa fa-codepen"></a></li>
      <li><a href="javascript:;" data-content="fa-codiepie" class="fa fa-codiepie"></a></li>
      <li><a href="javascript:;" data-content="fa-connectdevelop" class="fa fa-connectdevelop"></a></li>
      <li><a href="javascript:;" data-content="fa-contao" class="fa fa-contao"></a></li>
      <li><a href="javascript:;" data-content="fa-credit-card-alt" class="fa fa-credit-card-alt"></a></li>
      <li><a href="javascript:;" data-content="fa-css3" class="fa fa-css3"></a></li>
      <li><a href="javascript:;" data-content="fa-dashcube" class="fa fa-dashcube"></a></li>
      <li><a href="javascript:;" data-content="fa-delicious" class="fa fa-delicious"></a></li>
      <li><a href="javascript:;" data-content="fa-deviantart" class="fa fa-deviantart"></a></li>
      <li><a href="javascript:;" data-content="fa-digg" class="fa fa-digg"></a></li>
      <li><a href="javascript:;" data-content="fa-dribbble" class="fa fa-dribbble"></a></li>
      <li><a href="javascript:;" data-content="fa-dropbox" class="fa fa-dropbox"></a></li>
      <li><a href="javascript:;" data-content="fa-drupal" class="fa fa-drupal"></a></li>
      <li><a href="javascript:;" data-content="fa-edge" class="fa fa-edge"></a></li>
      <li><a href="javascript:;" data-content="fa-eercast" class="fa fa-eercast"></a></li>
      <li><a href="javascript:;" data-content="fa-empire" class="fa fa-empire"></a></li>
      <li><a href="javascript:;" data-content="fa-envira" class="fa fa-envira"></a></li>
      <li><a href="javascript:;" data-content="fa-etsy" class="fa fa-etsy"></a></li>
      <li><a href="javascript:;" data-content="fa-expeditedssl" class="fa fa-expeditedssl"></a></li>
      <li><a href="javascript:;" data-content="fa-facebook" class="fa fa-facebook"></a></li>
      <li><a href="javascript:;" data-content="fa-facebook-f" class="fa fa-facebook-f"></a></li>
      <li><a href="javascript:;" data-content="fa-facebook-official" class="fa fa-facebook-official"></a></li>
      <li><a href="javascript:;" data-content="fa-facebook-square" class="fa fa-facebook-square"></a></li>
      <li><a href="javascript:;" data-content="fa-firefox" class="fa fa-firefox"></a></li>
      <li><a href="javascript:;" data-content="fa-first-order" class="fa fa-first-order"></a></li>
      <li><a href="javascript:;" data-content="fa-flickr" class="fa fa-flickr"></a></li>
      <li><a href="javascript:;" data-content="fa-font-awesome" class="fa fa-font-awesome"></a></li>
      <li><a href="javascript:;" data-content="fa-fonticons" class="fa fa-fonticons"></a></li>
      <li><a href="javascript:;" data-content="fa-fort-awesome" class="fa fa-fort-awesome"></a></li>
      <li><a href="javascript:;" data-content="fa-forumbee" class="fa fa-forumbee"></a></li>
      <li><a href="javascript:;" data-content="fa-foursquare" class="fa fa-foursquare"></a></li>
      <li><a href="javascript:;" data-content="fa-free-code-camp" class="fa fa-free-code-camp"></a></li>
      <li><a href="javascript:;" data-content="fa-ge" class="fa fa-ge"></a></li>
      <li><a href="javascript:;" data-content="fa-get-pocket" class="fa fa-get-pocket"></a></li>
      <li><a href="javascript:;" data-content="fa-gg" class="fa fa-gg"></a></li>
      <li><a href="javascript:;" data-content="fa-gg-circle" class="fa fa-gg-circle"></a></li>
      <li><a href="javascript:;" data-content="fa-git" class="fa fa-git"></a></li>
      <li><a href="javascript:;" data-content="fa-git-square" class="fa fa-git-square"></a></li>
      <li><a href="javascript:;" data-content="fa-github" class="fa fa-github"></a></li>
      <li><a href="javascript:;" data-content="fa-github-alt" class="fa fa-github-alt"></a></li>
      <li><a href="javascript:;" data-content="fa-github-square" class="fa fa-github-square"></a></li>
      <li><a href="javascript:;" data-content="fa-gitlab" class="fa fa-gitlab"></a></li>
      <li><a href="javascript:;" data-content="fa-gittip" class="fa fa-gittip"></a></li>
      <li><a href="javascript:;" data-content="fa-glide" class="fa fa-glide"></a></li>
      <li><a href="javascript:;" data-content="fa-glide-g" class="fa fa-glide-g"></a></li>
      <li><a href="javascript:;" data-content="fa-google" class="fa fa-google"></a></li>
      <li><a href="javascript:;" data-content="fa-google-plus" class="fa fa-google-plus"></a></li>
      <li><a href="javascript:;" data-content="fa-google-plus-official" class="fa fa-google-plus-official"></a></li>
      <li><a href="javascript:;" data-content="fa-google-plus-official" class="fa fa-google-plus-official"></a></li>
      <li><a href="javascript:;" data-content="fa-google-plus-square" class="fa fa-google-plus-square"></a></li>
      <li><a href="javascript:;" data-content="fa-google-wallet" class="fa fa-google-wallet"></a></li>
      <li><a href="javascript:;" data-content="fa-gratipay" class="fa fa-gratipay"></a></li>
      <li><a href="javascript:;" data-content="fa-grav" class="fa fa-grav"></a></li>
      <li><a href="javascript:;" data-content="fa-hacker-news" class="fa fa-hacker-news"></a></li>
      <li><a href="javascript:;" data-content="fa-hashtag" class="fa fa-hashtag"></a></li>
      <li><a href="javascript:;" data-content="fa-houzz" class="fa fa-houzz"></a></li>
      <li><a href="javascript:;" data-content="fa-html5" class="fa fa-html5"></a></li>
      <li><a href="javascript:;" data-content="fa-imdb" class="fa fa-imdb"></a></li>
      <li><a href="javascript:;" data-content="fa-instagram" class="fa fa-instagram"></a></li>
      <li><a href="javascript:;" data-content="fa-instagram" class="fa fa-instagram"></a></li>
      <li><a href="javascript:;" data-content="fa-internet-explorer" class="fa fa-internet-explorer"></a></li>
      <li><a href="javascript:;" data-content="fa-ioxhost" class="fa fa-ioxhost"></a></li>
      <li><a href="javascript:;" data-content="fa-joomla" class="fa fa-joomla"></a></li>
      <li><a href="javascript:;" data-content="fa-jsfiddle" class="fa fa-jsfiddle"></a></li>
      <li><a href="javascript:;" data-content="fa-lastfm" class="fa fa-lastfm"></a></li>
      <li><a href="javascript:;" data-content="fa-lastfm-square" class="fa fa-lastfm-square"></a></li>
      <li><a href="javascript:;" data-content="fa-leanpub" class="fa fa-leanpub"></a></li>
      <li><a href="javascript:;" data-content="fa-linkedin" class="fa fa-linkedin"></a></li>
      <li><a href="javascript:;" data-content="fa-linkedin-square" class="fa fa-linkedin-square"></a></li>
      <li><a href="javascript:;" data-content="fa-linode" class="fa fa-linode"></a></li>
      <li><a href="javascript:;" data-content="fa-linux" class="fa fa-linux"></a></li>
      <li><a href="javascript:;" data-content="fa-maxcdn" class="fa fa-maxcdn"></a></li>
      <li><a href="javascript:;" data-content="fa-meanpath" class="fa fa-meanpath"></a></li>
      <li><a href="javascript:;" data-content="fa-medium" class="fa fa-medium"></a></li>
      <li><a href="javascript:;" data-content="fa-mixcloud" class="fa fa-mixcloud"></a></li>
      <li><a href="javascript:;" data-content="fa-modx" class="fa fa-modx"></a></li>
      <li><a href="javascript:;" data-content="fa-odnoklassniki" class="fa fa-odnoklassniki"></a></li>
      <li><a href="javascript:;" data-content="fa-odnoklassniki-square" class="fa fa-odnoklassniki-square"></a></li>
      <li><a href="javascript:;" data-content="fa-opencart" class="fa fa-opencart"></a></li>
      <li><a href="javascript:;" data-content="fa-openid" class="fa fa-openid"></a></li>
      <li><a href="javascript:;" data-content="fa-opera" class="fa fa-opera"></a></li>
      <li><a href="javascript:;" data-content="fa-optin-monster" class="fa fa-optin-monster"></a></li>
      <li><a href="javascript:;" data-content="fa-pagelines" class="fa fa-pagelines"></a></li>
      <li><a href="javascript:;" data-content="fa-paypal" class="fa fa-paypal"></a></li>
      <li><a href="javascript:;" data-content="fa-pied-piper" class="fa fa-pied-piper"></a></li>
      <li><a href="javascript:;" data-content="fa-pied-piper" class="fa fa-pied-piper"></a></li>
      <li><a href="javascript:;" data-content="fa-pied-piper-alt" class="fa fa-pied-piper-alt"></a></li>
      <li><a href="javascript:;" data-content="fa-pinterest" class="fa fa-pinterest"></a></li>
      <li><a href="javascript:;" data-content="fa-pinterest-p" class="fa fa-pinterest-p"></a></li>
      <li><a href="javascript:;" data-content="fa-pinterest-square" class="fa fa-pinterest-square"></a></li>
      <li><a href="javascript:;" data-content="fa-product-hunt" class="fa fa-product-hunt"></a></li>
      <li><a href="javascript:;" data-content="fa-qq" class="fa fa-qq"></a></li>
      <li><a href="javascript:;" data-content="fa-quora" class="fa fa-quora"></a></li>
      <li><a href="javascript:;" data-content="fa-ra" class="fa fa-ra"></a></li>
      <li><a href="javascript:;" data-content="fa-ravelry" class="fa fa-ravelry"></a></li>
      <li><a href="javascript:;" data-content="fa-rebel" class="fa fa-rebel"></a></li>
      <li><a href="javascript:;" data-content="fa-reddit" class="fa fa-reddit"></a></li>
      <li><a href="javascript:;" data-content="fa-reddit-alien" class="fa fa-reddit-alien"></a></li>
      <li><a href="javascript:;" data-content="fa-reddit-square" class="fa fa-reddit-square"></a></li>
      <li><a href="javascript:;" data-content="fa-renren" class="fa fa-renren"></a></li>
      <li><a href="javascript:;" data-content="fa-safari" class="fa fa-safari"></a></li>
      <li><a href="javascript:;" data-content="fa-scribd" class="fa fa-scribd"></a></li>
      <li><a href="javascript:;" data-content="fa-sellsy" class="fa fa-sellsy"></a></li>
      <li><a href="javascript:;" data-content="fa-share-alt" class="fa fa-share-alt"></a></li>
      <li><a href="javascript:;" data-content="fa-share-alt-square" class="fa fa-share-alt-square"></a></li>
      <li><a href="javascript:;" data-content="fa-shirtsinbulk" class="fa fa-shirtsinbulk"></a></li>
      <li><a href="javascript:;" data-content="fa-sign-language" class="fa fa-sign-language"></a></li>
      <li><a href="javascript:;" data-content="fa-simplybuilt" class="fa fa-simplybuilt"></a></li>
      <li><a href="javascript:;" data-content="fa-skyatlas" class="fa fa-skyatlas"></a></li>
      <li><a href="javascript:;" data-content="fa-skype" class="fa fa-skype"></a></li>
      <li><a href="javascript:;" data-content="fa-slack" class="fa fa-slack"></a></li>
      <li><a href="javascript:;" data-content="fa-slideshare" class="fa fa-slideshare"></a></li>
      <li><a href="javascript:;" data-content="fa-snapchat" class="fa fa-snapchat"></a></li>
      <li><a href="javascript:;" data-content="fa-snapchat-ghost" class="fa fa-snapchat-ghost"></a></li>
      <li><a href="javascript:;" data-content="fa-snapchat-square" class="fa fa-snapchat-square"></a></li>
      <li><a href="javascript:;" data-content="fa-soundcloud" class="fa fa-soundcloud"></a></li>
      <li><a href="javascript:;" data-content="fa-spotify" class="fa fa-spotify"></a></li>
      <li><a href="javascript:;" data-content="fa-stack-exchange" class="fa fa-stack-exchange"></a></li>
      <li><a href="javascript:;" data-content="fa-stack-overflow" class="fa fa-stack-overflow"></a></li>
      <li><a href="javascript:;" data-content="fa-steam" class="fa fa-steam"></a></li>
      <li><a href="javascript:;" data-content="fa-steam-square" class="fa fa-steam-square"></a></li>
      <li><a href="javascript:;" data-content="fa-stumbleupon" class="fa fa-stumbleupon"></a></li>
      <li><a href="javascript:;" data-content="fa-stumbleupon-circle" class="fa fa-stumbleupon-circle"></a></li>
      <li><a href="javascript:;" data-content="fa-superpowers" class="fa fa-superpowers"></a></li>
      <li><a href="javascript:;" data-content="fa-telegram" class="fa fa-telegram"></a></li>
      <li><a href="javascript:;" data-content="fa-tencent-weibo" class="fa fa-tencent-weibo"></a></li>
      <li><a href="javascript:;" data-content="fa-themeisle" class="fa fa-themeisle"></a></li>
      <li><a href="javascript:;" data-content="fa-trello" class="fa fa-trello"></a></li>
      <li><a href="javascript:;" data-content="fa-tripadvisor" class="fa fa-tripadvisor"></a></li>
      <li><a href="javascript:;" data-content="fa-tumblr" class="fa fa-tumblr"></a></li>
      <li><a href="javascript:;" data-content="fa-tumblr-square" class="fa fa-tumblr-square"></a></li>
      <li><a href="javascript:;" data-content="fa-twitch" class="fa fa-twitch"></a></li>
      <li><a href="javascript:;" data-content="fa-twitter" class="fa fa-twitter"></a></li>
      <li><a href="javascript:;" data-content="fa-twitter-square" class="fa fa-twitter-square"></a></li>
      <li><a href="javascript:;" data-content="fa-usb" class="fa fa-usb"></a></li>
      <li><a href="javascript:;" data-content="fa-viacoin" class="fa fa-viacoin"></a></li>
      <li><a href="javascript:;" data-content="fa-viadeo" class="fa fa-viadeo"></a></li>
      <li><a href="javascript:;" data-content="fa-viadeo-square" class="fa fa-viadeo-square"></a></li>
      <li><a href="javascript:;" data-content="fa-vimeo" class="fa fa-vimeo"></a></li>
      <li><a href="javascript:;" data-content="fa-vimeo-square" class="fa fa-vimeo-square"></a></li>
      <li><a href="javascript:;" data-content="fa-vine" class="fa fa-vine"></a></li>
      <li><a href="javascript:;" data-content="fa-vk" class="fa fa-vk"></a></li>
      <li><a href="javascript:;" data-content="fa-wechat" class="fa fa-wechat"></a></li>
      <li><a href="javascript:;" data-content="fa-weibo" class="fa fa-weibo"></a></li>
      <li><a href="javascript:;" data-content="fa-weixin" class="fa fa-weixin"></a></li>
      <li><a href="javascript:;" data-content="fa-whatsapp" class="fa fa-whatsapp"></a></li>
      <li><a href="javascript:;" data-content="fa-wikipedia-w" class="fa fa-wikipedia-w"></a></li>
      <li><a href="javascript:;" data-content="fa-windows" class="fa fa-windows"></a></li>
      <li><a href="javascript:;" data-content="fa-wordpress" class="fa fa-wordpress"></a></li>
      <li><a href="javascript:;" data-content="fa-wpbeginner" class="fa fa-wpbeginner"></a></li>
      <li><a href="javascript:;" data-content="fa-wpexplorer" class="fa fa-wpexplorer"></a></li>
      <li><a href="javascript:;" data-content="fa-wpforms" class="fa fa-wpforms"></a></li>
      <li><a href="javascript:;" data-content="fa-xing" class="fa fa-xing"></a></li>
      <li><a href="javascript:;" data-content="fa-xing-square" class="fa fa-xing-square"></a></li>
      <li><a href="javascript:;" data-content="fa-y-combinator" class="fa fa-y-combinator"></a></li>
      <li><a href="javascript:;" data-content="fa-y-combinator-square" class="fa fa-y-combinator-square"></a></li>
      <li><a href="javascript:;" data-content="fa-yahoo" class="fa fa-yahoo"></a></li>
      <li><a href="javascript:;" data-content="fa-yc" class="fa fa-yc"></a></li>
      <li><a href="javascript:;" data-content="fa-yc-square" class="fa fa-yc-square"></a></li>
      <li><a href="javascript:;" data-content="fa-yelp" class="fa fa-yelp"></a></li>
      <li><a href="javascript:;" data-content="fa-yoast" class="fa fa-yoast"></a></li>
      <li><a href="javascript:;" data-content="fa-youtube" class="fa fa-youtube"></a></li>
      <li><a href="javascript:;" data-content="fa-youtube-play" class="fa fa-youtube-play"></a></li>
      <li><a href="javascript:;" data-content="fa-youtube-square" class="fa fa-youtube-square"></a></li>
    </ul>
  </div>
  <div>
    <h2>网银支付类图标(11个)</h2>
    <ul>
      <li><a href="javascript:;" data-content="fa-cc-amex" class="fa fa-cc-amex"></a></li>
      <li><a href="javascript:;" data-content="fa-cc-diners-club" class="fa fa-cc-diners-club"></a></li>
      <li><a href="javascript:;" data-content="fa-cc-discover" class="fa fa-cc-discover"></a></li>
      <li><a href="javascript:;" data-content="fa-cc-jcb" class="fa fa-cc-jcb"></a></li>
      <li><a href="javascript:;" data-content="fa-cc-mastercard" class="fa fa-cc-mastercard"></a></li>
      <li><a href="javascript:;" data-content="fa-cc-paypal" class="fa fa-cc-paypal"></a></li>
      <li><a href="javascript:;" data-content="fa-cc-stripe" class="fa fa-cc-stripe"></a></li>
      <li><a href="javascript:;" data-content="fa-cc-visa" class="fa fa-cc-visa"></a></li>
      <li><a href="javascript:;" data-content="fa-credit-card" class="fa fa-credit-card"></a></li>
      <li><a href="javascript:;" data-content="fa-google-wallet" class="fa fa-google-wallet"></a></li>
      <li><a href="javascript:;" data-content="fa-paypal" class="fa fa-paypal"></a></li>
    </ul>
  </div>
  <div>
    <h2>图表类图标(5个)</h2>
    <ul>
      <li><a href="javascript:;" data-content="fa-area-chart" class="fa fa-area-chart"></a></li>
      <li><a href="javascript:;" data-content="fa-bar-chart" class="fa fa-bar-chart"></a></li>
      <li><a href="javascript:;" data-content="fa-bar-chart-o" class="fa fa-bar-chart-o"></a></li>
      <li><a href="javascript:;" data-content="fa-line-chart" class="fa fa-line-chart"></a></li>
      <li><a href="javascript:;" data-content="fa-pie-chart" class="fa fa-pie-chart"></a></li>
    </ul>
  </div>
  <div>
    <h2>旋转类图标(5个)</h2>
    <ul>
      <li><a href="javascript:;" data-content="fa-circle-o-notch" class="fa fa-circle-o-notch"></a></li>
      <li><a href="javascript:;" data-content="fa-cog" class="fa fa-cog"></a></li>
      <li><a href="javascript:;" data-content="fa-gear" class="fa fa-gear"></a></li>
      <li><a href="javascript:;" data-content="fa-refresh" class="fa fa-refresh"></a></li>
      <li><a href="javascript:;" data-content="fa-spinner" class="fa fa-spinner"></a></li>
    </ul>
  </div>
  <div>
    <h2>货币类图标(27个)</h2>
    <ul>
      <li><a href="javascript:;" data-content="fa-bitcoin" class="fa fa-bitcoin"></a></li>
      <li><a href="javascript:;" data-content="fa-btc" class="fa fa-btc"></a></li>
      <li><a href="javascript:;" data-content="fa-cny" class="fa fa-cny"></a></li>
      <li><a href="javascript:;" data-content="fa-credit-card-alt" class="fa fa-credit-card-alt"></a></li>
      <li><a href="javascript:;" data-content="fa-dollar" class="fa fa-dollar"></a></li>
      <li><a href="javascript:;" data-content="fa-eur" class="fa fa-eur"></a></li>
      <li><a href="javascript:;" data-content="fa-euro" class="fa fa-euro"></a></li>
      <li><a href="javascript:;" data-content="fa-gbp" class="fa fa-gbp"></a></li>
      <li><a href="javascript:;" data-content="fa-gg" class="fa fa-gg"></a></li>
      <li><a href="javascript:;" data-content="fa-gg-circle" class="fa fa-gg-circle"></a></li>
      <li><a href="javascript:;" data-content="fa-ils" class="fa fa-ils"></a></li>
      <li><a href="javascript:;" data-content="fa-inr" class="fa fa-inr"></a></li>
      <li><a href="javascript:;" data-content="fa-jpy" class="fa fa-jpy"></a></li>
      <li><a href="javascript:;" data-content="fa-krw" class="fa fa-krw"></a></li>
      <li><a href="javascript:;" data-content="fa-money" class="fa fa-money"></a></li>
      <li><a href="javascript:;" data-content="fa-rmb" class="fa fa-rmb"></a></li>
      <li><a href="javascript:;" data-content="fa-rouble" class="fa fa-rouble"></a></li>
      <li><a href="javascript:;" data-content="fa-rub" class="fa fa-rub"></a></li>
      <li><a href="javascript:;" data-content="fa-ruble" class="fa fa-ruble"></a></li>
      <li><a href="javascript:;" data-content="fa-rupee" class="fa fa-rupee"></a></li>
      <li><a href="javascript:;" data-content="fa-shekel" class="fa fa-shekel"></a></li>
      <li><a href="javascript:;" data-content="fa-sheqel" class="fa fa-sheqel"></a></li>
      <li><a href="javascript:;" data-content="fa-try" class="fa fa-try"></a></li>
      <li><a href="javascript:;" data-content="fa-turkish-lira" class="fa fa-turkish-lira"></a></li>
      <li><a href="javascript:;" data-content="fa-usd" class="fa fa-usd"></a></li>
      <li><a href="javascript:;" data-content="fa-won" class="fa fa-won"></a></li>
      <li><a href="javascript:;" data-content="fa-yen" class="fa fa-yen"></a></li>
    </ul>
  </div>
  <div>
    <h2>手势动作图标(17个)</h2>
    <ul>
      <li><a href="javascript:;" data-content="fa-hand-grab-o" class="fa fa-hand-grab-o"></a></li>
      <li><a href="javascript:;" data-content="fa-hand-lizard-o" class="fa fa-hand-lizard-o"></a></li>
      <li><a href="javascript:;" data-content="fa-hand-o-down" class="fa fa-hand-o-down"></a></li>
      <li><a href="javascript:;" data-content="fa-hand-o-left" class="fa fa-hand-o-left"></a></li>
      <li><a href="javascript:;" data-content="fa-hand-o-right" class="fa fa-hand-o-right"></a></li>
      <li><a href="javascript:;" data-content="fa-hand-o-up" class="fa fa-hand-o-up"></a></li>
      <li><a href="javascript:;" data-content="fa-hand-paper-o" class="fa fa-hand-paper-o"></a></li>
      <li><a href="javascript:;" data-content="fa-hand-peace-o" class="fa fa-hand-peace-o"></a></li>
      <li><a href="javascript:;" data-content="fa-hand-pointer-o" class="fa fa-hand-pointer-o"></a></li>
      <li><a href="javascript:;" data-content="fa-hand-rock-o" class="fa fa-hand-rock-o"></a></li>
      <li><a href="javascript:;" data-content="fa-hand-scissors-o" class="fa fa-hand-scissors-o"></a></li>
      <li><a href="javascript:;" data-content="fa-hand-spock-o" class="fa fa-hand-spock-o"></a></li>
      <li><a href="javascript:;" data-content="fa-hand-stop-o" class="fa fa-hand-stop-o"></a></li>
      <li><a href="javascript:;" data-content="fa-thumbs-down" class="fa fa-thumbs-down"></a></li>
      <li><a href="javascript:;" data-content="fa-thumbs-o-down" class="fa fa-thumbs-o-down"></a></li>
      <li><a href="javascript:;" data-content="fa-thumbs-o-up" class="fa fa-thumbs-o-up"></a></li>
      <li><a href="javascript:;" data-content="fa-thumbs-up" class="fa fa-thumbs-up"></a></li>
    </ul>
  </div>
  <div>
    <h2>性别类图标(14个)</h2>
    <ul>
      <li><a href="javascript:;" data-content="fa-genderless" class="fa fa-genderless"></a></li>
      <li><a href="javascript:;" data-content="fa-intersex" class="fa fa-intersex"></a></li>
      <li><a href="javascript:;" data-content="fa-mars" class="fa fa-mars"></a></li>
      <li><a href="javascript:;" data-content="fa-mars-double" class="fa fa-mars-double"></a></li>
      <li><a href="javascript:;" data-content="fa-mars-stroke" class="fa fa-mars-stroke"></a></li>
      <li><a href="javascript:;" data-content="fa-mars-stroke-h" class="fa fa-mars-stroke-h"></a></li>
      <li><a href="javascript:;" data-content="fa-mars-stroke-v" class="fa fa-mars-stroke-v"></a></li>
      <li><a href="javascript:;" data-content="fa-mercury" class="fa fa-mercury"></a></li>
      <li><a href="javascript:;" data-content="fa-neuter" class="fa fa-neuter"></a></li>
      <li><a href="javascript:;" data-content="fa-transgender" class="fa fa-transgender"></a></li>
      <li><a href="javascript:;" data-content="fa-transgender-alt" class="fa fa-transgender-alt"></a></li>
      <li><a href="javascript:;" data-content="fa-venus" class="fa fa-venus"></a></li>
      <li><a href="javascript:;" data-content="fa-venus-double" class="fa fa-venus-double"></a></li>
      <li><a href="javascript:;" data-content="fa-venus-mars" class="fa fa-venus-mars"></a></li>
    </ul>
  </div>
  <div>
    <h2>文件类型图标(18个)</h2>
    <ul>
      <li><a href="javascript:;" data-content="fa-file" class="fa fa-file"></a></li>
      <li><a href="javascript:;" data-content="fa-file-archive-o" class="fa fa-file-archive-o"></a></li>
      <li><a href="javascript:;" data-content="fa-file-audio-o" class="fa fa-file-audio-o"></a></li>
      <li><a href="javascript:;" data-content="fa-file-code-o" class="fa fa-file-code-o"></a></li>
      <li><a href="javascript:;" data-content="fa-file-excel-o" class="fa fa-file-excel-o"></a></li>
      <li><a href="javascript:;" data-content="fa-file-image-o" class="fa fa-file-image-o"></a></li>
      <li><a href="javascript:;" data-content="fa-file-movie-o" class="fa fa-file-movie-o"></a></li>
      <li><a href="javascript:;" data-content="fa-file-o" class="fa fa-file-o"></a></li>
      <li><a href="javascript:;" data-content="fa-file-pdf-o" class="fa fa-file-pdf-o"></a></li>
      <li><a href="javascript:;" data-content="fa-file-photo-o" class="fa fa-file-photo-o"></a></li>
      <li><a href="javascript:;" data-content="fa-file-picture-o" class="fa fa-file-picture-o"></a></li>
      <li><a href="javascript:;" data-content="fa-file-powerpoint-o" class="fa fa-file-powerpoint-o"></a></li>
      <li><a href="javascript:;" data-content="fa-file-sound-o" class="fa fa-file-sound-o"></a></li>
      <li><a href="javascript:;" data-content="fa-file-text" class="fa fa-file-text"></a></li>
      <li><a href="javascript:;" data-content="fa-file-text-o" class="fa fa-file-text-o"></a></li>
      <li><a href="javascript:;" data-content="fa-file-video-o" class="fa fa-file-video-o"></a></li>
      <li><a href="javascript:;" data-content="fa-file-word-o" class="fa fa-file-word-o"></a></li>
      <li><a href="javascript:;" data-content="fa-file-zip-o" class="fa fa-file-zip-o"></a></li>
    </ul>
  </div>
  <div>
    <h2>文字编辑器图标(49个)</h2>
    <ul>
      <li><a href="javascript:;" data-content="fa-align-center" class="fa fa-align-center"></a></li>
      <li><a href="javascript:;" data-content="fa-align-justify" class="fa fa-align-justify"></a></li>
      <li><a href="javascript:;" data-content="fa-align-left" class="fa fa-align-left"></a></li>
      <li><a href="javascript:;" data-content="fa-align-right" class="fa fa-align-right"></a></li>
      <li><a href="javascript:;" data-content="fa-bold" class="fa fa-bold"></a></li>
      <li><a href="javascript:;" data-content="fa-chain" class="fa fa-chain"></a></li>
      <li><a href="javascript:;" data-content="fa-chain-broken" class="fa fa-chain-broken"></a></li>
      <li><a href="javascript:;" data-content="fa-clipboard" class="fa fa-clipboard"></a></li>
      <li><a href="javascript:;" data-content="fa-columns" class="fa fa-columns"></a></li>
      <li><a href="javascript:;" data-content="fa-copy" class="fa fa-copy"></a></li>
      <li><a href="javascript:;" data-content="fa-cut" class="fa fa-cut"></a></li>
      <li><a href="javascript:;" data-content="fa-dedent" class="fa fa-dedent"></a></li>
      <li><a href="javascript:;" data-content="fa-eraser" class="fa fa-eraser"></a></li>
      <li><a href="javascript:;" data-content="fa-file" class="fa fa-file"></a></li>
      <li><a href="javascript:;" data-content="fa-file-o" class="fa fa-file-o"></a></li>
      <li><a href="javascript:;" data-content="fa-file-text" class="fa fa-file-text"></a></li>
      <li><a href="javascript:;" data-content="fa-file-text-o" class="fa fa-file-text-o"></a></li>
      <li><a href="javascript:;" data-content="fa-files-o" class="fa fa-files-o"></a></li>
      <li><a href="javascript:;" data-content="fa-floppy-o" class="fa fa-floppy-o"></a></li>
      <li><a href="javascript:;" data-content="fa-font" class="fa fa-font"></a></li>
      <li><a href="javascript:;" data-content="fa-header" class="fa fa-header"></a></li>
      <li><a href="javascript:;" data-content="fa-indent" class="fa fa-indent"></a></li>
      <li><a href="javascript:;" data-content="fa-italic" class="fa fa-italic"></a></li>
      <li><a href="javascript:;" data-content="fa-link" class="fa fa-link"></a></li>
      <li><a href="javascript:;" data-content="fa-list" class="fa fa-list"></a></li>
      <li><a href="javascript:;" data-content="fa-list-alt" class="fa fa-list-alt"></a></li>
      <li><a href="javascript:;" data-content="fa-list-ol" class="fa fa-list-ol"></a></li>
      <li><a href="javascript:;" data-content="fa-list-ul" class="fa fa-list-ul"></a></li>
      <li><a href="javascript:;" data-content="fa-outdent" class="fa fa-outdent"></a></li>
      <li><a href="javascript:;" data-content="fa-paperclip" class="fa fa-paperclip"></a></li>
      <li><a href="javascript:;" data-content="fa-paragraph" class="fa fa-paragraph"></a></li>
      <li><a href="javascript:;" data-content="fa-paste" class="fa fa-paste"></a></li>
      <li><a href="javascript:;" data-content="fa-repeat" class="fa fa-repeat"></a></li>
      <li><a href="javascript:;" data-content="fa-rotate-left" class="fa fa-rotate-left"></a></li>
      <li><a href="javascript:;" data-content="fa-rotate-right" class="fa fa-rotate-right"></a></li>
      <li><a href="javascript:;" data-content="fa-save" class="fa fa-save"></a></li>
      <li><a href="javascript:;" data-content="fa-scissors" class="fa fa-scissors"></a></li>
      <li><a href="javascript:;" data-content="fa-strikethrough" class="fa fa-strikethrough"></a></li>
      <li><a href="javascript:;" data-content="fa-subscript" class="fa fa-subscript"></a></li>
      <li><a href="javascript:;" data-content="fa-superscript" class="fa fa-superscript"></a></li>
      <li><a href="javascript:;" data-content="fa-table" class="fa fa-table"></a></li>
      <li><a href="javascript:;" data-content="fa-text-height" class="fa fa-text-height"></a></li>
      <li><a href="javascript:;" data-content="fa-text-width" class="fa fa-text-width"></a></li>
      <li><a href="javascript:;" data-content="fa-th" class="fa fa-th"></a></li>
      <li><a href="javascript:;" data-content="fa-th-large" class="fa fa-th-large"></a></li>
      <li><a href="javascript:;" data-content="fa-th-list" class="fa fa-th-list"></a></li>
      <li><a href="javascript:;" data-content="fa-underline" class="fa fa-underline"></a></li>
      <li><a href="javascript:;" data-content="fa-undo" class="fa fa-undo"></a></li>
      <li><a href="javascript:;" data-content="fa-unlink" class="fa fa-unlink"></a></li>
    </ul>
  </div>
  <div>
    <h2>可访问图标(12个)</h2>
    <ul>
      <li><a href="javascript:;" data-content="fa-american-sign-language-interpreting" class="fa fa-american-sign-language-interpreting"></a></li>
      <li><a href="javascript:;" data-content="fa-assistive-listening-systems" class="fa fa-assistive-listening-systems"></a></li>
      <li><a href="javascript:;" data-content="fa-audio-description" class="fa fa-audio-description"></a></li>
      <li><a href="javascript:;" data-content="fa-blind" class="fa fa-blind"></a></li>
      <li><a href="javascript:;" data-content="fa-braille" class="fa fa-braille"></a></li>
      <li><a href="javascript:;" data-content="fa-deaf" class="fa fa-deaf"></a></li>
      <li><a href="javascript:;" data-content="fa-deaf" class="fa fa-deaf"></a></li>
      <li><a href="javascript:;" data-content="fa-low-vision" class="fa fa-low-vision"></a></li>
      <li><a href="javascript:;" data-content="fa-question-circle-o" class="fa fa-question-circle-o"></a></li>
      <li><a href="javascript:;" data-content="fa-universal-access" class="fa fa-universal-access"></a></li>
      <li><a href="javascript:;" data-content="fa-volume-control-phone" class="fa fa-volume-control-phone"></a></li>
      <li><a href="javascript:;" data-content="fa-wheelchair-alt" class="fa fa-wheelchair-alt"></a></li>
    </ul>
  </div>
</section>
<?php if(!$body){ ?>
</body>
</html>
<?php } ?>