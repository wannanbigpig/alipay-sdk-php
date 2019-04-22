# 简介

使用支付宝最新接口完成的扩展，简化对接支付宝接口的流程，方便在不同项目中快速上手使用。使用时只需要根据你所要对接的接口关注传递参数即可。

**使用本扩展请先熟悉 支付宝 开发文档**

欢迎 Star，欢迎 PR！

## 运行环境

* PHP 7.0+
* composer

## 安装

```text
composer require wannanbigpig/alipay -vvv
```

## 使用

```php
use WannanBigPig\Alipay\Alipay;

class PayController
{
    // 配置（包含支付宝的公共配置，日志配置，http配置等）
    protected $config = [
        'app_id' => '************',
        'notify_url' => 'http://wannanbigpig.com/notify.php',
        'return_url' => 'http://wannanbigpig.com/return.php',
        // 支付宝公钥，验证签名使用。可以是一个绝对路径（/data/***.pem）,或者是一行字符串
        'ali_public_key' => '***',
        // 私钥钥，签名使用。可以是一个绝对路径（/data/***.pem）,或者是一行字符串
        'private_key' => '***',
        'log' => [ // optional
            'file' => '/data/wwwroot/alipay.packages.com/logs/alipay.log',
            'level' => 'info', // 建议生产环境等级调整为 info，开发环境为 debug
            'type' => 'daily', // optional, 可选 single.
            'max_file' => 30, // optional, 当 type 为 daily 时有效，默认 30 天
        ],
        'http' => [ // optional
            'timeout' => 5.0,
            'connect_timeout' => 5.0,
            // 更多配置项请参考 [Guzzle](https://guzzle-cn.readthedocs.io/zh_CN/latest/request-options.html)
        ],
        'env' => 'dev', // optional,设置此参数，将进入沙箱模式,不传默认normal
    ];
}
```

## 代码贡献

目前只对接各类支付，资金预授权等相关接口。如果您有其它支付宝相关接口的需求，或者发现本项目中需要改进的代码，_**欢迎 Fork 并提交 PR！**_

## LICENSE

MIT

