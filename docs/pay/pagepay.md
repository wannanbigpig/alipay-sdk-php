# pc网站支付

### 调用方法

```php
$result = $alipay->pagePay([
    'out_trade_no' => Str::getRandomString(22),
    'total_amount' => 100,
    'subject'      => 'mac Xpro',
    'quit_url'     => 'http://wannanbigpig.com',
    'product_code' => 'FAST_INSTANT_TRADE_PAY',
    // ...
]);

// 返回值 Symfony\Component\HttpFoundation\Response
// laravel 中直接 return $result;
$result->send();
```

#### 传入参数说明

所有参数请参考 [alipay.trade.page.pay\(统一收单下单并支付页面接口\)](https://docs.open.alipay.com/api_1/alipay.trade.page.pay/) ，查看「请求参数」一栏。

#### 返回参数

根据传入的http_method返回url字符串或表单请求字符串，默认返回post表单请求字符串

```text
<form id='alipaysubmit' name='alipaysubmit' action='https://openapi.alipaydev.com/gateway.do' method='POST'><input type='hidden' name='app_id' value='2016092600598145'/><input type='hidden' name='method' value='alipay.trade.page.pay'/><input type='hidden' name='format' value='JSON'/><input type='hidden' name='charset' value='utf-8'/><input type='hidden' name='sign_type' value='RSA2'/><input type='hidden' name='version' value='1.0'/><input type='hidden' name='return_url' value='http://liuml.com/return.php'/><input type='hidden' name='notify_url' value='http://liuml.com/notify.php'/><input type='hidden' name='timestamp' value='2019-04-26 03:30:09'/><input type='hidden' name='biz_content' value='{"out_trade_no":"h0ycLW2jJKuSo1ZeXqbMAU","total_amount":100,"subject":"mac Xpro","quit_url":"http:\/\/wannanbigpig.com","product_code":"FAST_INSTANT_TRADE_PAY"}'/><input type='hidden' name='sign' value='uXxWeK8CKh7yhg/pU/CG/iY5sMNk2lCKEAWBFE3V3wThIZRUMQK8qSuzkEEtCWVaFNcCXKa+mUkvSslQ4y+UJYRPhV8AEon1yJ/vDJLMVAIkh4/+8kwXOcpH7ruu/i1qjPIlzYq+VaNPeuZrDXVF5iIqHE2cwU2sHNydxT2pSUCJvD0garmi35fZnDpMkEJgOShUPjng1qfpyOk3e3qftXgImIn0pZkyc7qsMbRD6AWAqjirwJj8IlUIcLRV9LyYrIK6YV2Js0+hG1sUk8xRGVNvEBRmsvCvOVFqAGMvgzDzpF3gRJ2+5YRmPFsE38yqDbMBrycNoJjK4lOJB88Qaw=='/><input type='submit' value='ok' style='display:none;'></form><script>document.forms['alipaysubmit'].submit();</script>
```

