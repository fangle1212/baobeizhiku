<?php
/*
 * Copyright (c) Huyin Information Technology Co., Ltd. All Rights Reserved.
 * BOSSCMS Content Management System (https://www.bosscms.net/)
 */
define('IS_INSIDE',true);
$BOSSCMS_MOLD=isset($_GET['mold'])?$_GET['mold']:'iframe';
$BOSSCMS_PART=isset($_GET['part'])?$_GET['part']:'iframe';
$BOSSCMS_FUNC=isset($_GET['func'])?$_GET['func']:'init';
define('BOSSCMS_MOLD',$BOSSCMS_MOLD);
define('BOSSCMS_PART',$BOSSCMS_PART);
define('BOSSCMS_FUNC',$BOSSCMS_FUNC);
require_once '../system/enter.php';
?>