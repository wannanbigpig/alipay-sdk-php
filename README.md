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
    
    protected $alipay;
    
    public function __construct()
    {
        $this->payment();
    }
    
    public function payment()
    {
        $this->alipay = Alipay::payment($this->config);
    }
    
    /**
     * 当面付 统一收单交易支付接口 pos机扫码支付
     *
     */
    public function pos()
    {
        $result = $this->alipay->pos([
            'out_trade_no' => Str::getRandomInt('lml', 3),
            'total_amount' => 100,
            'scene'        => "bar_code",
            'auth_code'    => "287951669891795468",
            'product_code' => "FACE_TO_FACE_PAYMENT",
            'subject'      => '商品标题',
        ]);
        echo $result->code;
        // {"code":"10000","msg":"Success","buyer_logon_id":"arl***@sandbox.com","buyer_pay_amount":"100.00","buyer_user_id":"2088102177891684","buyer_user_type":"PRIVATE","fund_bill_list":[{"amount":"100.00","fund_channel":"ALIPAYACCOUNT"}],"gmt_payment":"2019-04-22 16:56:05","invoice_amount":"100.00","out_trade_no":"lml20190422085602165540142","point_amount":"0.00","receipt_amount":"100.00","total_amount":"100.00","trade_no":"2019042222001491681000029208"}
    }
}
```

## 代码贡献

目前只对接各类支付，资金预授权等相关接口。如果您有其它支付宝相关接口的需求，或者发现本项目中需要改进的代码，_**欢迎 Fork 并提交 PR！**_

## LICENSE

MIT

