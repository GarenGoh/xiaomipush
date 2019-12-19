<?php
namespace garengoh\xmpush;

use xmpush\IOSBuilder;
use xmpush\Builder;
use xmpush\Sender;
use xmpush\Constants;

include_once(dirname(__FILE__) . '/autoload.php');

class XiaoMiPush
{
    // Android 配置信息
    public $android_secret;
    public $android_package;
    // IOS 配置信息
    public $ios_secret ;
    public $ios_bundleId;

    const SYSTEM_ANDROID = 'android';
    const SYSTEM_IOS = 'ios';

    const ENV_DEV = 'dev';      // 开发环境
    const ENV_PROD = 'prod';    // 生产环境

    /**
     * @param $system
     * @return bool|Builder|IOSBuilder
     */
    public function getMessage($system)
    {
        switch ($system) {
            case self::SYSTEM_ANDROID:
                $message = new Builder();
                break;
            case self::SYSTEM_IOS:
                $message = new IOSBuilder();
                break;
            default:
                $message = false;
        }

        return $message;
    }

    public function getAndroidSender()
    {
        // 常量设置必须在new Sender()方法之前调用
        Constants::setPackage($this->android_package);
        Constants::setSecret($this->android_secret);
        $sender = new Sender();

        return $sender;
    }

    public function getIosSender($env)
    {
        // 常量设置必须在new Sender()方法之前调用
        Constants::setSecret($this->ios_secret);
        Constants::setBundleId($this->ios_bundleId);
        if($env == self::ENV_DEV){
            Constants::useSandbox();
        }elseif($env == self::ENV_PROD){
            Constants::useOfficial();
        }
        $sender = new Sender();

        return $sender;
    }
}