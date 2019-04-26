# 手机网站支付

### 调用方法

```php
$result = $alipay->wap([
    'out_trade_no' => Str::getRandomString(22),
    'total_amount' => 100,
    'subject'      => 'mac Xpro',
    'quit_url'     => 'http://wannanbigpig.com',
    'product_code' => 'QUICK_WAP_WAY',
    'http_method'  => 'get', // 'post'返回表单字符串 , 'get'返回url字符串,不传默认 post 返回表单字符串。
    // ...
]);

// 返回值 Symfony\Component\HttpFoundation\Response
// laravel 中直接 return $result;
$result->send();
```

#### 传入参数说明

所有参数请参考 [alipay.trade.wap.pay\(手机网站支付接口2.0\)](https://docs.open.alipay.com/api_1/alipay.trade.wap.pay/)，查看「请求参数」一栏。

#### 返回参数

根据传入的http_method返回url字符串或表单请求字符串，默认返回post表单请求字符串

```text

https://openapi.alipaydev.com/gateway.do?app_id=2016092600598145&biz_content=%7B%22out_trade_no%22%3A%22NCPImFf2RHSsxrzOVpGK9o%22%2C%22total_amount%22%3A100%2C%22subject%22%3A%22mac+Xpro%22%2C%22quit_url%22%3A%22http%3A%5C%2F%5C%2Fwannanbigpig.com%22%2C%22product_code%22%3A%22QUICK_WAP_WAY%22%7D&charset=utf-8&format=JSON&method=alipay.trade.wap.pay&notify_url=http%3A%2F%2Fliuml.com%2Fnotify.php&return_url=http%3A%2F%2Fliuml.com%2Freturn.php&sign=G5mvczfr5b1AmuZCl2Dg0AK55IhMg8zlFzl9b%2FTXT4e3oC9ZpA1DGLlA4NWYEtMGuX%2ByAmTWyuqPZfDcJMNIcFt%2BSMpJkdiwLkJ3f1lgSrH0VYmg1%2B8sOwn8IVcOPdItgeEv0KXfs%2FCrK6QmrbUGl3ttF7Khj5c1HY0KYfAdh5aEz4ViVkMA4ZhMab7G3M5JYe3JWEkSplhemWD%2BoL8qgdfVOLjOPlTRyyiAHbqNderuwFdcWDr6jlbfctCE2DpRBpDq%2BKR%2B67chxsNkHUgK0OJ23LkVpIiF1dBwWYVA97xEoA4ehoIaNy49rCwaCJrstP%2F2FpfKnNwCLrG8DCffrw%3D%3D&sign_type=RSA2&timestamp=2019-04-26+03%3A13%3A00&version=1.0
```

