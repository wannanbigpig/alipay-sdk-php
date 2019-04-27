# App支付

## 调用示例

```php
$result = $alipay->app([
    'out_trade_no' => Str::getRandomInt('lml', 3),
    'total_amount' => '0.01',
    'subject'      => 'mac X pro 2080',
    // ...
]);

// 返回值 Symfony\Component\HttpFoundation\Response
// laravel 中直接 return $result;
$result->send();
```

### 传入参数说明

所有参数请参考 [alipay.trade.app.pay\(app支付接口2.0\)](https://docs.open.alipay.com/api_1/alipay.trade.app.pay/) ，查看「请求参数」一栏。

### 返回参数

返回签名后的订单信息字符串，[详情点我](https://docs.open.alipay.com/204/105465/)

```text
app_id=2015052600090779&biz_content=%7B%22timeout_express%22%3A%2230m%22%2C%22product_code%22%3A%22QUICK_MSECURITY_PAY%22%2C%22total_amount%22%3A%220.01%22%2C%22subject%22%3A%221%22%2C%22body%22%3A%22%E6%88%91%E6%98%AF%E6%B5%8B%E8%AF%95%E6%95%B0%E6%8D%AE%22%2C%22out_trade_no%22%3A%22IQJZSRC1YMQB5HU%22%7D&charset=utf-8&format=json&method=alipay.trade.app.pay&notify_url=http%3A%2F%2Fdomain.merchant.com%2Fpayment_notify&sign_type=RSA2&timestamp=2016-08-25%2020%3A26%3A31&version=1.0&sign=cYmuUnKi5QdBsoZEAbMXVMmRWjsuUj%2By48A2DvWAVVBuYkiBj13CFDHu2vZQvmOfkjE0YqCUQE04kqm9Xg3tIX8tPeIGIFtsIyp%2FM45w1ZsDOiduBbduGfRo1XRsvAyVAv2hCrBLLrDI5Vi7uZZ77Lo5J0PpUUWwyQGt0M4cj8g%3D
```

