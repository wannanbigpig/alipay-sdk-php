# 资金授权冻结接口

## 调用示例

```php
$result = $alipay->fund->fundAuthFreeze([
    'auth_code' => '28763443825664394',
    // ...
]);

// 返回值 WannanBigPig\Supports\AccessData 实现了接口（IteratorAggregate, ArrayAccess, Serializable, Countable）
// 直接 echo 或者调用$result->toJson()方法则返回json字符串
// echo $result['code']; // 10000
echo $result;
```

### 传入参数说明

所有参数请参考[alipay.fund.auth.order.freeze\(资金授权冻结接口\)](https://docs.open.alipay.com/api_28/alipay.fund.auth.order.freeze/)，查看「请求参数」一栏。

### 返回参数

与支付宝返回参数一致\(经过签名验证，剔除了支付宝返回的签名，只保留支付宝接口返回的业务数据\)。

```text
{
    "code": "10000",
    "msg": "Success",
    ...
}
```

