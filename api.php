<?php
include("./includes/common.php");
include_once(SYSTEM_ROOT."theme.php");
$loadfile = Template::load('api');
include $loadfile;
