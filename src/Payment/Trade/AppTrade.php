<?php
/**
 * AppTrade.php
 *
 * Created by PhpStorm.
 *
 * author: liuml  <liumenglei0211@163.com>
 * DateTime: 2019-04-04  16:36
 */

namespace WannanBigPig\Alipay\Payment\Trade;

use Symfony\Component\HttpFoundation\Response;
use WannanBigPig\Alipay\Kernel\Support\Support;
use WannanBigPig\Alipay\Payment\PayInterface;
use WannanBigPig\Alipay\Kernel;
use WannanBigPig\Supports\Exceptions\InvalidArgumentException;

class AppTrade implements PayInterface
{

    /**
     * alipay.trade.app.pay (app 支付接口 2.0)
     * 外部商户 APP 唤起快捷 SDK 创建订单并支付
     *
     * @var string
     */
    private $method = 'alipay.trade.app.pay';

    /**
     * pay
     *
     * @param string $gatewayUrl
     * @param array  $payload
     *
     * @return Response
     *
     * @throws InvalidArgumentException
     *
     * @link     https://docs.open.alipay.com/api_1/alipay.trade.app.pay/
     *
     * @author   liuml  <liumenglei0211@163.com>
     * @DateTime 2019-04-11  10:41
     */
    public function pay(string $gatewayUrl, array $payload): Response
    {
        $payload['method'] = $this->method;

        $payload['sign'] = Support::generateSign($payload);

        return Support::pageExecute($gatewayUrl, $payload);
    }
}