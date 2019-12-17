<?php

include_once(dirname(__FILE__) . '/XiaoMiPush.php');

$p = new \garengoh\xmpush\XiaoMiPush();

//$p->pushAndroid(['1', '22'], 'From be to Android', '来自后端的测试', '1');
$p->pushIos(['1', '22'], 'From be to IOS.', '来自后端的测试', '1');
?>