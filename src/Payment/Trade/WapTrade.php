<?php
/**
 * PrecreateTrade.php
 *
 * Created by PhpStorm.
 *
 * author: liuml  <liumenglei0211@163.com>
 * DateTime: 2019-04-09  15:57
 */

namespace WannanBigPig\Alipay\Payment\Trade;

use Symfony\Component\HttpFoundation\Response;
use WannanBigPig\Alipay\Kernel\Support\Support;
use WannanBigPig\Alipay\Payment\PayInterface;
use WannanBigPig\Supports\Exceptions;

class WapTrade implements PayInterface
{
    /**
     * alipay.trade.wap.pay (手机网站支付接口 2.0)
     * 外部商户创建订单并支付
     *
     * @var string
     */
    private $method = 'alipay.trade.wap.pay';

    /**
     * pay
     *
     * @param string $gatewayUrl
     * @param array  $payload
     *
     * @return Response
     *
     * @throws Exceptions\InvalidArgumentException
     *
     * @author   liuml  <liumenglei0211@163.com>
     * @DateTime 2019-04-10  12:03
     */
    public function pay(string $gatewayUrl, array $payload): Response
    {
        $payload['method'] = $this->method;

        $payload['sign'] = Support::generateSign($payload);

        return Support::pageExecute($gatewayUrl, $payload);
    }
}
