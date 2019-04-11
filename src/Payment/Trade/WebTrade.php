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
use WannanBigPig\Alipay\Kernel\Exceptions\SignException;
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
     * @param array $params
     *
     * @return Response
     *
     * @throws Exceptions\BusinessException
     * @throws Exceptions\InvalidArgumentException
     * @throws SignException
     *
     * @author   liuml  <liumenglei0211@163.com>
     * @DateTime 2019-04-11  15:27
     */
    public function pay(array $params): Response
    {
        $payload = Support::setBizContent($params);
        return Support::execute($payload, $this->method, 'page');
    }
}
