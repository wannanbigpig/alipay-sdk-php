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

$logger = Log::createLogger(
    Support::$config->get('log.file'),
    'wannanbigpig.alipay',
    Support::$config->get('log.level', 'warning'),
    Support::$config->get('log.type', 'daily'),
    Support::$config->get('log.max_file', 30)
);
Log::setLogger($logger);

Log::info('这是一个日志');
```

