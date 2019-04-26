# 刷脸支付

## 调用示例

```php
$result = $alipay->faceInit([
    'zimmetainfo' => '{"apdidToken": "设备指纹", "appName": "应用名称", "appVersion": "应用版本", "bioMetaInfo": "生物信息如 2.3.0:3,-4"}',
]);

// 返回值 WannanBigPig\Supports\AccessData 实现了接口（IteratorAggregate, ArrayAccess, Serializable, Countable）
// 直接 echo 或者调用$result->toJson()方法则返回json字符串
// echo $result['code']; // 10000
echo $result;
```

### 传入参数说明

所有参数请参考[zoloz.authentication.customer.smilepay.initialize\(人脸初始化唤起zim\)](https://docs.open.alipay.com/api_46/zoloz.authentication.customer.smilepay.initialize) ，查看「请求参数」一栏。

### 返回参数

与支付宝返回参数一致\(经过签名验证，剔除了支付宝返回的签名，只保留支付宝接口返回的业务数据\)。

```text
{
    "code": "10000",
    "msg": "Success",
    ...
}
```

ps:刷脸流程请查看 [刷脸付接入指引](https://docs.open.alipay.com/20180402104715814204/quickstart/)

