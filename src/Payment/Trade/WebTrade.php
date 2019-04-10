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

class WebTrade implements PayInterface
{
    /**
     * alipay.trade.page.pay (统一收单下单并支付页面接口)
     * PC 场景下单并支付
     *
     * @var string
     */
    private $method = 'alipay.trade.page.pay';

    /**
     * pay
     *
     * @param       $endpoint
     * @param array $payload
     *
     * @return Response
     *
     * @throws Exceptions\InvalidArgumentException
     *
     * @author   liuml  <liumenglei0211@163.com>
     * @DateTime 2019-04-10  12:03
     */
    public function pay($endpoint, array $payload): Response
    {
        $payload['method'] = $this->method;

        $payload['sign'] = Support::generateSign($payload);

        return Support::pageExecute($payload);
    }
}
