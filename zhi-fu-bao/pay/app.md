# App支付

### 支付宝 API 文档



### 调用方法

```php
$result = $alipay->app([
    'out_trade_no' => time(),
    'total_amount' => '0.01',
    'subject'      => 'mac X pro 2080',
    // ...
]);

// 返回值 Symfony\Component\HttpFoundation\Response
// laravel 中直接 return $result;
$result->send();

```





## 的

