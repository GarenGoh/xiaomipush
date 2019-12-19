<?php

    include_once(dirname(__FILE__) . '/XiaoMiPush.php');

    $p = new \garengoh\xmpush\XiaoMiPush();

// 测试安卓
    $title = '这是Android标题'.rand(1,99999);
    $description = rand(1,99999).'来自后端的测试(简介)';
    $payload = 1;

    // 获取sender,该方法必须在getMessage之前调用
    $sender = $p->getAndroidSender();

    $msg = $p->getAndroidMessage($sender)
        ->notifyType('1,2,4')          //通知类型 可组合 (-1 Default,1 提示音,2 震动,4 呼吸灯)
        ->title($title)                // 通知栏的title
        ->description($description)    // 通知栏的descption
        ->passThrough(0)               // 这是一条通知栏消息，如果需要透传，把这个参数设置成1,同时去掉title和descption两个参数
        ->payload($payload)            // 携带的数据，点击后将会通过客户端的receiver中的onReceiveMessage方法传入。
        ->extra(\xmpush\Builder::notifyForeground, 1)  // 应用在前台是否展示通知，如果不希望应用在前台时候弹出通知，则设置这个参数为0
        //->extra(Builder::notifyEffect, 1)      // 此处设置预定义点击行为,1为打开app
        ->extra('payload', $payload)
        ->notifyId(0)                  // 通知类型。最多支持0-4 5个取值范围，同样的类型的通知会互相覆盖，不同类型可以在通知栏并存
        ->build();  // build()方法必须放在最后,其他方法顺序可变化

    // $result = $sender->sendToAliases($msg, ['22', '90'])->getRaw();
    // $result = $sender->sendToUserAccounts($msg, ['22', '90'])->getRaw();
    // $result = $sender->broadcastAll($msg)->getRaw();
    // print_r($result);


// 测试IOS
    $title = '这是Ios标题'.rand(1,99999);
    $description = rand(1,99999).'来自后端的测试(简介)';
    $payload = 1;

    // 获取sender,该方法必须在getMessage之前调用
    $sender = $p->getIosSender(\garengoh\xmpush\XiaoMiPush::ENV_DEV);

    $msg = $p->getIOSMessage($sender)
        ->parentTitle($title)
        ->description($description)
        ->soundUrl('default')
        ->badge('1')//角标数字
        ->extra('payload', $payload)
        ->build();  // build()方法必须放在最后,其他方法顺序可变化

    $result = $sender->broadcastAll($msg)->getRaw();
    print_r($result);

?>