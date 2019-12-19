## 注意
小米推送php SDK(2019年的SDK)存在很多bug,次依赖包修复了其中部分bug.如遇到问题可与我联系
* 邮箱: garen.goh@qq.com
* 主页: [wqiang.net](wqiang.net)


## 配置
```
'xmPushService' => [
     'class' => 'garengoh\xmpush\XiaoMiPush',
     'android_secret' => 'Your android secret.',
     'android_package' => 'Your android package name.',
     'ios_secret' => 'Your ios secret.',
     'ios_bundleId' => 'Your ios bundleId.'
 ]
 ```
 #### 例如
 
 ```
 'xmPushService' => [
      'class' => 'garengoh\xmpush\XiaoMiPush',
      'android_secret' => 'CXHodE6CbA+PKG1lEMgzvQ==',
      'android_package' => 'com.wqiang.an',
      'ios_secret' => 'CMHoGE9CbA+PK81lEMgzvQ==',
      'ios_bundleId' => 'cn.wqiang.ii'
  ]
  ```
  
  ## 如何使用
  #### 发送安卓消息
   
 ```
 public function sendAndroid()
 {
     $title = '来自小米的推送(安卓)';
     $description = '世界如此大,我想躺床上睡觉';
     $payload = '{"key":12,"name":"wqiang"}';
     
     // getAndroidSender()方法必须在getMessage()方法之前调用
     $sender =  Yii::$app->xmPushService->getAndroidSender();
     
     $message = Yii::$app->xmPushService->getMessage(XiaoMiPush::SYSTEM_ANDROID)
         ->notifyType('1,2,4')          //通知类型 可组合 (-1 Default,1 提示音,2 震动,4 呼吸灯)
         ->title($title)                // 通知栏的title
         ->description($description)    // 通知栏的descption
         ->passThrough(0)               // 这是一条通知栏消息，如果需要透传，把这个参数设置成1,同时去掉title和descption两个参数
         ->payload($payload)            // 携带的数据，点击后将会通过客户端的receiver中的onReceiveMessage方法传入。
         ->extra(\xmpush\Builder::notifyForeground, 1)  // 应用在前台是否展示通知，如果不希望应用在前台时候弹出通知，则设置这个参数为0
         //->extra(Builder::notifyEffect, 1)            // 此处设置预定义点击行为,1为打开app
         ->extra('payload', $payload)
         ->notifyId(0)                  // 通知类型。最多支持0-4 5个取值范围，同样的类型的通知会互相覆盖，不同类型可以在通知栏并存
         ->build();                     // build()方法必须放在最后,其他方法顺序可变化

     $result = $sender->sendToAliases($message, [22,11])->getRaw();

     return $result;
 }
```
  
  #### 发送IOS消息
     
```
public function sendIos()
{
    $title = '来自小米的推送(IOS)';
    $description = '世界如此大,我想躺床上睡觉';
    $payload = '{"key":12,"name":"wqiang"}';
    
    // getAndroidSender()方法必须在getMessage()方法之前调用
    // 生产环境需将XiaoMiPush::ENV_DEV改为XiaoMiPush::ENV_PROD
    $sender =  Yii::$app->xmPushService->getIosSender(XiaoMiPush::ENV_DEV);
    
    $message = Yii::$app->xmPushService->getMessage(XiaoMiPush::SYSTEM_IOS)
       ->parentTitle($title)          // 通知栏的title
       ->description($description)    // 通知栏的descption
       ->soundUrl('default')          // 携带的数据，点击后将会通过客户端的receiver中的onReceiveMessage方法传入。
       ->badge('1');//角标数字
       ->extra('payload', $payload);
       ->build();                     // build()方法必须放在最后,其他方法顺序可变化
    
    $aliases = [22,11]; // 别名
    // 通过别名发送
    $result = $sender->sendToAliases($message, $aliases)->getRaw();
    // 其他发送方式不再一一举例
    
    return $result;
}
```