# 下载对账单

## 调用示例

```php
$result = $alipay->download([
    'bill_type' => 'trade',
    'bill_date' => '2019-04-09',
]);

// 返回值 WannanBigPig\Supports\AccessData 实现了接口（IteratorAggregate, ArrayAccess, Serializable, Countable）
// 直接 echo 或者调用$result->toJson()方法则返回json字符串
// echo $result['code']; // 10000
echo $result;
```

### 传入参数说明

所有参数请参考[alipay.data.dataservice.bill.downloadurl.query\(查询对账单下载地址\)](https://docs.open.alipay.com/api_15/alipay.data.dataservice.bill.downloadurl.query)，查看「请求参数」一栏。

### 返回参数

与支付宝返回参数一致\(经过签名验证，剔除了支付宝返回的签名，只保留支付宝接口返回的业务数据\)。

```text
{
    "code": "10000",
    "msg": "Success",
    // ...
}
```

