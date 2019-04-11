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
     * @param array $params
     *
     * @return Response
     *
     * @throws Exceptions\BusinessException
     * @throws Exceptions\InvalidArgumentException
     * @throws SignException
     *
     * @author   liuml  <liumenglei0211@163.com>
     * @DateTime 2019-04-11  15:26
     */
    public function pay(array $params): Response
    {
        $payload = Support::setBizContent($params);
        return Support::execute($payload, $this->method, 'page');
    }
}
