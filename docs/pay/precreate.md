# 扫码支付

## 调用方法

```php
$result = $alipay->precreate([
    'out_trade_no' => Str::getRandomInt('lml', 3),
    'total_amount' => 100,
    // ...
]);

// 返回值 WannanBigPig\Supports\AccessData 实现了接口（IteratorAggregate, ArrayAccess, Serializable, Countable）
// 直接 echo 或者调用$result->toJson()方法则返回json字符串
// echo $result['code']; // 10000
// echo $result->qr_code; // https://qr.alipay.com/bax4678qbyurtqubhnl0024
echo $result;
```

### 传入参数说明

所有参数请参考[ alipay.trade.precreate\(统一收单线下交易预创建\)](https://docs.open.alipay.com/api_1/alipay.trade.precreate/) ，查看「请求参数」一栏。

### 返回参数

与支付宝返回参数一致\(经过签名验证，剔除了支付宝返回的签名，只保留支付宝接口返回的业务数据\)。

```text
{
    "code": "10000",
    "msg": "Success",
    "out_trade_no": "lml20190424072734580650134",
    "qr_code": "https://qr.alipay.com/bax4678qbyurtqubhnl0024"
}
```

