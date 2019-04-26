# 线上资金授权冻结接口

## 调用示例

```php
$result = $alipay->fund->fundAuthAppFreeze([
    'out_order_no' => '8077735255938023',
    // ...
]);

// 返回值 Symfony\Component\HttpFoundation\Response
// laravel 中直接 return $result;
$result->send();

```

### 传入参数说明

所有参数请参考[alipay.fund.auth.order.app.freeze\(线上资金授权冻结接口\)](https://docs.open.alipay.com/api_28/alipay.fund.auth.order.app.freeze/)，查看「请求参数」一栏。

### 返回参数

返回签名后的订单信息字符串，[详情点我](https://docs.open.alipay.com/20180417160701241302/vo4kv7)

```text
app_id=2016092600598145&biz_content=%7B%22out_order_no%22%3A%228077735255938023%22%7D&charset=utf-8&format=JSON&method=alipay.fund.auth.order.app.freeze&notify_url=http%3A%2F%2Fliuml.com%2Fnotify.php&return_url=http%3A%2F%2Fliuml.com%2Freturn.php&sign_type=RSA2&timestamp=2019-04-26+09%3A52%3A59&version=1.0&sign=XhqRPXwUFmBF4Zrj1xtPYFmVaMV9t3HGRxkCjS43VGRDNhJGNLtfajmVkEZdtrCB1IKa2FKI%2BhjqwBsncywFTdoCIzNSWSWVQQn1KdzUGUzzfgQG8ZK2LWcFGY5YtHuP%2BBpPWR25I4Uu%2BcKKKluVRbjfISxkOEpzl4LaSc1MVX6z3dG1aVXpSIzg0H0PkLIBFYP5vZC%2BEdwMVJzfk5lj9YX2owKbN3c%2BepwhQe6r%2FBPj8J90%2BM71rrXPnQilNuG4foOqjEBGz3RDN9%2B7d2pDJz8jK70VmCKIIldt%2FBVwhl7mII4evLCCHtn2fhG75k0WuDsspx63efN6gK0sZ3Bcxw%3D%3D
```

