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
     * @param array $params
     *
     * @return Response
     *
     * @throws InvalidArgumentException
     */
    public function pay(array $params): Response
    {
        return Support::executePage($params, $this->method);
    }
}