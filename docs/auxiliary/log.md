# 日志

### 使用的包

[monolg](https://github.com/Seldaek/monolog)

### 配置

```php
'log' => [
    // optional
    'file'     => '/data/wwwroot/alipay.dev/logs/alipay.log',
    'level'    => 'debug', // 建议生产环境等级调整为 info，开发环境为 debug
    'type'     => 'daily', // optional, 可选 single.
    'max_file' => 30, // optional, 当 type 为 daily 时有效，默认 30 天
]
```

### 示例

```php
use WannanBigPig\Supports\Logs\Log;
// 初始化日志，如果已经调用过Alipay::{method}($config)初始化，这一步可以省略
$logger = Log::createLogger(
    './newlog.log',
    'wannanbigpig.alipay',
    'debug',
    'daily',
    30
);
Log::setLogger($logger);
// 写入日志
Log::info('这是一个日志');
```

