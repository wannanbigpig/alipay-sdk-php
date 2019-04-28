# 结算

## 调用示例

```php
$result = $alipay->settle([
    'out_trade_no'       => 'gpwKLbarfkdvC9A1SRjqFc',
    'trade_no'           => '2019041122001491681000007119',
    'royalty_parameters' => [
        [
            'trans_out'         => '2088101126765726',
            'trans_in'          => '2088101126708402',
            'amount'            => '0.01',
            'amount_percentage' => '100',
            'desc'              => '分账给2088101126708402',
        ],
        // ...
    ],
    // ...
]);

// 返回值 WannanBigPig\Supports\AccessData 实现了接口（IteratorAggregate, ArrayAccess, Serializable, Countable）
// 直接 echo 或者调用$result->toJson()方法则返回json字符串
// echo $result['code']; // 10000
echo $result;
```

### 传入参数说明

所有参数请参考[alipay.trade.order.settle\(统一收单交易结算接口\)](https://docs.open.alipay.com/api_1/alipay.trade.order.settle/)，查看「请求参数」一栏。

### 返回参数

与支付宝返回参数一致\(经过签名验证，剔除了支付宝返回的签名，只保留支付宝接口返回的业务数据\)。

```text
{
    "code": "10000",
    "msg": "Success",
    // ...
}
```

