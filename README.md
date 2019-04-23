<h1 align="left"><a href="https://www.easywechat.com">WannanBibPig\Alipay</a></h1>

📦 对接支付宝最新接口，使用灵活方便，你只需要关注传入支付数据，其他都不用管，交给我就行

[![Build Status](https://travis-ci.org/wannanbigpig/alipay.svg?branch=master)](https://travis-ci.org/wannanbigpig/alipay)


# 简介

使用支付宝最新接口完成的扩展，简化对接支付宝接口的流程，方便在不同项目中快速上手使用。使用时只需要根据你所要对接的接口关注传递参数即可。

你在阅读本文之前确认你已经仔细阅读了：[**支付宝开放平台文档**](https://docs.open.alipay.com/)

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
        'app_id'         => '*********',
        // 服务商需要设置子商户的授权token，商户自调用不需要设置此参数
        'app_auth_token' => '',
        'notify_url'     => 'http://wannanbigpig.com/notify.php',
        'return_url'     => 'http://wannanbigpig.com/return.php',
        // 支付宝公钥，可以是绝对路径（/data/***.pem）或着一行秘钥字符串
        'ali_public_key' => '******',
        'sign_type'      => 'RSA2',
        // 商户私钥，可以是绝对路径（/data/***.pem）或着一行秘钥字符串
        'private_key'    => '**********',
        'log'            => [
            // optional
            'file'     => '/data/wwwroot/alipay.dev/logs/alipay.log',
            'level'    => 'debug', // 建议生产环境等级调整为 info，开发环境为 debug
            'type'     => 'daily', // optional, 可选 single.
            'max_file' => 30, // optional, 当 type 为 daily 时有效，默认 30 天
        ],
        'http'           => [
            // optional
            'timeout'         => 5.0,
            'connect_timeout' => 5.0,
            // 更多配置项请参考 [Guzzle](https://guzzle-cn.readthedocs.io/zh_CN/latest/request-options.html)
        ],
        'env'            => 'dev', // optional[normal,dev],设置此参数，将进入沙箱模式，不传默认正式环境
        /**
         * 业务返回处理
         * 设置true， 返回码 10000 则正常返回成功数据，其他的则抛出业务异常
         * 捕获 BusinessException 异常 获取 raw 元素查看完整数据并做处理
         * 不设置默认 false
         */
        'business_exception' => true
    ];

    /**
     * 当面付 统一收单交易支付接口 pos机扫码支付
     *
     */
    public function pos()
    {
        try{
            $result = Alipay::payment($this->config)->pos([
                'out_trade_no' => Str::getRandomInt('lml', 3),
                'total_amount' => 100,
                'scene'        => "bar_code",
                'auth_code'    => "287951669891795468",
                'product_code' => "FACE_TO_FACE_PAYMENT",
                'subject'      => '商品标题',
            ]);
            // ...
        }catch (BusinessException $e){
            // business_exception 配置项开启后需要捕获该异常处理请求失败的情况
            $res = $e->raw; // 获取支付宝返回数据
            // ...
        }
    }
}
```

## 支持的方法

| method | 描述 | 支付宝API文档 |
| :---: | :---: | :---: |
| App | App支付 | alipay.trade.app.pay \(app 支付接口 2.0\) |
| faceInit | 刷脸支付 | zoloz.authentication.customer.smilepay.initialize \(人脸初始化唤起 zim\) |
| pay | pos机支付 | alipay.trade.pay \(统一收单交易支付接口\) |
| precreate | 扫码支付 | alipay.trade.precreate \(统一收单线下交易预创建\) |
| wap | 手机网站支付 | alipay.trade.wap.pay \(手机网站支付接口 2.0\) |
| pagePay | pc网站支付 | alipay.trade.page.pay \(统一收单下单并支付页面接口\) |
| create | 小程序支付 | alipay.trade.create \(统一收单交易创建接口\) |

```php
// 支付方法调用示例
Alipay::payment($this->config)->{$method}([...]);
```

## 详细文档

[详细开发文档](https://docs.alipay.liuml.com/)

## 代码贡献

目前只对接各类支付，资金预授权等相关接口。如果您有其它支付宝相关接口的需求，或者发现本项目中需要改进的代码，_**欢迎 Fork 并提交 PR！**_

## LICENSE

MIT

