<?php
namespace garengoh\xmpush;

use xmpush\IOSBuilder;
use xmpush\Builder;
use xmpush\Sender;
use xmpush\Constants;
use xmpush\TargetedMessage;

include_once(dirname(__FILE__) . '/autoload.php');

class XiaoMiPush
{
//    public $secret;
//    public $package;   // Android
//    public $bundleId;  // IOS

    public $secret = 'CXHodE9CbA+PKp1lEMgzvQ==';
    public $package = 'com.yaohui.jike';   // Android
    public $bundleId = 'cn.alpha-car.ijk';  // IOS

    public function pushAndroid($aliasList, $title, $desc, $payload)
    {
        echo '<pre>';
        print_r(
            111111
        );
        echo '</pre>';
        echo '<pre>';
        print_r(
            222222
        );
        echo '</pre>';

        // 常量设置必须在new Sender()方法之前调用
        Constants::setPackage($this->package);
        Constants::setSecret($this->secret);

        $sender = new Sender();
        // $sender->setRegion(Region::China);// 支持海外
        // message1 演示自定义的点击行为
        $message1 = new Builder();
        $message1->title($title);  // 通知栏的title
        $message1->description($desc); // 通知栏的descption
        $message1->passThrough(0);  // 这是一条通知栏消息，如果需要透传，把这个参数设置成1,同时去掉title和descption两个参数
        $message1->payload($payload); // 携带的数据，点击后将会通过客户端的receiver中的onReceiveMessage方法传入。
        $message1->extra(Builder::notifyForeground, 1); // 应用在前台是否展示通知，如果不希望应用在前台时候弹出通知，则设置这个参数为0
        $message1->notifyId(2); // 通知类型。最多支持0-4 5个取值范围，同样的类型的通知会互相覆盖，不同类型可以在通知栏并存
        $message1->build();
        $targetMessage = new TargetedMessage();
        $targetMessage->setTarget('alias1', TargetedMessage::TARGET_TYPE_ALIAS); // 设置发送目标。可通过regID,alias和topic三种方式发送
        $targetMessage->setMessage($message1);

        print_r($sender->sendToAliases($message1, $aliasList)->getRaw());
    }

    public function pushIos(array $aliasList, $title, $desc, $payload)
    {
        echo '<pre>';
        print_r(
            "33333\n"
        );
        echo '</pre>';

        Constants::setBundleId($this->bundleId);
        Constants::setSecret($this->secret);

        $aliasList = array('2', 'alias2');
        $desc = '这是一条mipush推送消息';
        $payload = '{"test":1,"ok":"It\'s a string"}';

        $message = new IOSBuilder();

        $message->title($desc);         //（iOS10新特性）通知栏展示的标题，此选项不能和description共存。
        $message->subtitle('发一条消息如此难');      //（iOS10新特性）通知栏展示的子标题，此选项不能和description共存。
        $message->body('发一条消息如此难');          //（iOS10新特性）通知栏展示的内容，此选项不能和description共存。
        $message->description($desc);   // 设置在通知栏展示的通知描述，此方法不推荐使用，建议使用body。
        $message->soundUrl('default');
        $message->badge('4');
        $message->extra('payload', $payload);
        $message->build();

        $sender = new Sender();
// $sender->setRegion(Region::China);// 支持海外
        print_r($sender->sendToAliases($message, $aliasList)->getRaw());
    }


}