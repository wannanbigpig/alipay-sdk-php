# 异步通知

## 通知说明

在用户成功支付后，支付宝服务器会向该 **订单中设置的回调 URL** 发起一个 POST 请求，里面包含了所有的详细信息，具体请参考：[关于支付宝异步通知的那些事](https://openclub.alipay.com/read.php?tid=1314&fid=46&page=1)，[支付宝通知机制](https://docs.open.alipay.com/58/103594/) 

而对于用户的退款操作，在退款成功之后也会有一个异步回调通知。

本 SDK 内预置了通知处理方法，以方便开发者处理这些通知，具体用法如下：

在其中对自己的业务进行处理并向支付宝服务器发送一个响应。

## 调用示例

### 配置

```php
$config = [
    'ali_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEApN8Lzs5UAIel8MJRFCgxPf0fZIjkT+qAdodHvxSeXba7Dy5DKFScG2Tre2Cvr99H3Jf516X3n1N+BxRgq3lgnG6q79rGZjRWSeOWwkDUmJ4/cVgw6G5Y+JesAbYdGKxQESXUIA0/xEQm8klt2SE7gazm4O1jduKhfy53PCImRVrLW5jXlUykyblOIXQy4gzVo7UhSeBafRBR3DhO979yztcJJc7JWXui/bHm3Axm68Da4C1Fk44OMgD4VEU0kS8aeE3nrWX/JBMhduZZx4JTSs2299uMncEI6NsNKLgovuffspcAqUO6hwU3J7ygSdVpBjbULLkiL6DSOVopZOn6FQIDAQAB',
    'log'            => [
        // optional
        'file'     => './logs/alipay.log',
        'level'    => 'error', // 建议生产环境等级调整为 info，开发环境为 debug
        'type'     => 'daily', // optional, 可选 daily.
        'max_file' => 30, // optional, 当 type 为 daily 时有效，默认 30 天
    ],
    'env'            => 'dev', // optional,设置此参数，将进入沙箱模式,默认为正式环境
];

$notify = Alipay::notify($config);

```

### 方法

```php
$response = $notify->handle(function(WannanBigPig\Supports\AccessData $request, WannanBigPig\Alipay\Notify\Application $notify) {
    // 进入此代码块则表示签名已经验证通过，如果需要验证notify_id则调用如下方法:
    if (!$notify->notifyIdVerify($request->seller_id, $request->notify_id)) {
        // 返回给支付宝一个错误消息
        return $notify->fail();
    }
    
    // 在下面直接写业务逻辑，以支付异步通知为例
    // 使用通知里的 "外部交易号" 去自己的数据库找到订单
    $order = Order::query(['out_tarde_no', $request->out_trade_no]);
    
    if (!$order || $order->paid) { // 如果订单不存在 或者 订单已经支付过了
        return $notify->success(); // 告诉支付宝，我已经处理完了，或者是本地没有这个订单，不用再次通知我
    }
    
    if ($request->trade_status === 'TRADE_SUCCESS') {
        // 标记订单支付成功
        $order->pay_status = 'TRADE_SUCCESS';
        // ...
    }
    
    // 在这可以调用查询订单接口去查询支付状态
    // 然后可以执行其他操作，例如取消支付订单等
    // ...
    
    // 保存订单
    $order->save();

    // 返回给支付宝确认收到通知消息
    return $notify->success();
});
$response->send();

```

#### **需要注意的地方**

1. 退款结果通知和支付通知等均可使用此方法，只需要里面业务处理逻辑改变就行。
2. handle接收一个 [`Closure`](http://php.net/manual/zh/class.closure.php) 匿名函数，第二个参数为支付宝post的数据可传$\_POST, 不传则自动使用 Symfony\Component\HttpFoundation\Request 获取。
3. 该匿名函数接收两个参数，这两个参数分别为：

   > * `$request` 为支付宝推送过来的通知信息，为`WannanBigPig\Supports\AccessData`对象，可以以数组方式获取其中元素
   > * `$notify`为一个WannanBigPig\Alipay\Notify\Application对象，调用`success`方法向支付宝服务器返回成功信息，`fail`返回错误信息支付宝会稍后重新通知，具体间隔时间请查看支付宝相关文档

4. `handle` 返回值 `$response` 是一个 Response 对象，如果你要直接输出，使用 `$response->send()`, 在一些框架里（如 Laravel）不是输出而是返回：`return $response。`

### 不调用handle方法想直接验证支付宝通知参数的签名

示例：

```php
$response = $notify->verify($_POST);
```

