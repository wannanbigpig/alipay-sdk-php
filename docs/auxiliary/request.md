# 请求

### 使用的包

[guzzlehttp/guzzle](https://github.com/guzzle/guzzle)

### 配置

```php
'http' => [
    'timeout' => 5.0,
    'connect_timeout' => 5.0,
    // ...
]
```

更多配置参考 [Guzzle中文文档](https://guzzle-cn.readthedocs.io/zh_CN/latest/request-options.html)

### 示例

```php
use WannanBigPig\Alipay\Kernel\Support\Support;

Support::getInstance()->post($uri, $data);

Support::getInstance()->get($uri);
```

ps：目前只支持 get，post 方法

