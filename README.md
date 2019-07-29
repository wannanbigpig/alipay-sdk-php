<h1 align="center">Alipay SDK for PHP</h1>


[![Build Status](https://travis-ci.org/wannanbigpig/alipay-sdk-php.svg?branch=master)](https://travis-ci.org/wannanbigpig/alipay-sdk-php) [![StyleCI](https://github.styleci.io/repos/179242516/shield?branch=master)](https://github.styleci.io/repos/179242516) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/wannanbigpig/alipay-sdk-php/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/wannanbigpig/alipay-sdk-php/?branch=master) [![Code Coverage](https://scrutinizer-ci.com/g/wannanbigpig/alipay-sdk-php/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/wannanbigpig/alipay-sdk-php/?branch=master) [![Latest Stable Version](https://poser.pugx.org/wannanbigpig/alipay-sdk-php/v/stable)](https://packagist.org/packages/wannanbigpig/alipay-sdk-php) [![Latest Unstable Version](https://poser.pugx.org/wannanbigpig/alipay-sdk-php/v/unstable)](https://packagist.org/packages/wannanbigpig/alipay-sdk-php) [![Total Downloads](https://poser.pugx.org/wannanbigpig/alipay-sdk-php/downloads)](https://packagist.org/packages/wannanbigpig/alipay-sdk-php) [![License](https://poser.pugx.org/wannanbigpig/alipay-sdk-php/license)](https://packagist.org/packages/wannanbigpig/alipay-sdk-php) [![FOSSA Status](https://app.fossa.com/api/projects/git%2Bgithub.com%2Fwannanbigpig%2Falipay-sdk-php.svg?type=shield)](https://app.fossa.com/projects/git%2Bgithub.com%2Fwannanbigpig%2Falipay-sdk-php?ref=badge_shield)

📦 接入支付宝最新接口完成的扩展包，简化对接支付宝接口的操作，让代码看起更清晰。sdk还会自动记录每次请求支付宝网关的request和response的参数日志。自动校验返回值等...
## 说明

* 在使用SDK之前请确认你已经仔细阅读了：[**支付宝开放平台文档**](https://docs.open.alipay.com/)

* 在使用中出现问题，那么可以在这里提问 [Issues](https://github.com/wannanbigpig/alipay-sdk-php/issues)
* 欢迎 Star，欢迎 PR！

### 运行环境

* PHP 7.0+
* composer
* openssl 拓展

### 安装

```text
composer require wannanbigpig/alipay-sdk-php
```

### 使用

```php
use EasyAlipay\Alipay;

// 配置（包含支付宝的公共配置，日志配置，http配置等）
$config = [
    'sys_params' => [
        'app_id' => '888888888888888',
        'notify_url' => 'http://alipay.docs.wannanbigpig.com/',
        'return_url' => 'http://alipay.docs.wannanbigpig.com/',
    ],
    'private_key_path' => STORAGE_ROOT.'private_key.pem',
    'alipay_public_Key_path' => STORAGE_ROOT.'alipay_public_key.pem',
];

$app = Alipay::payment($config);

// 当面付 统一收单交易支付接口
$response = $app->pay([
    'out_trade_no' => \WannanBigPig\Supports\Str::getRandomInt(),
    'scene' => 'bar_code',
    'auth_code' => '283867319836385922',
    'subject' => 'ceshiapi',
    'total_amount' => '100',
]);

if($response['code'] === '10000'){
    echo $response['trade_no'];    // 2019072722001491681000180973
}
```

更多请参考：[详细开发文档](https://alipay.docs.wannanbigpig.com/)

### 代码贡献

目前只对接各类支付，资金预授权等相关接口。如果您有其它支付宝相关接口的需求，或者发现本项目中需要改进的代码，_**欢迎 Fork 并提交 PR！**_

### LICENSE

MIT

[![FOSSA Status](https://app.fossa.com/api/projects/git%2Bgithub.com%2Fwannanbigpig%2Falipay-sdk-php.svg?type=large)](https://app.fossa.com/projects/git%2Bgithub.com%2Fwannanbigpig%2Falipay-sdk-php?ref=badge_large)