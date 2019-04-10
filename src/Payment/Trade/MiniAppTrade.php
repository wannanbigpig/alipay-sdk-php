<?php
/**
 * MiniAppTrade.php
 *
 * Created by PhpStorm.
 *
 * author: liuml  <liumenglei0211@163.com>
 * DateTime: 2019-04-09  09:59
 */

namespace WannanBigPig\Alipay\Payment\Trade;

use WannanBigPig\Alipay\Kernel\Support\Support;
use WannanBigPig\Alipay\Payment\PayInterface;
use WannanBigPig\Supports\Exceptions\InvalidArgumentException;

class MiniAppTrade implements PayInterface
{

    /**
     * 小程序支付 alipay.trade.create (统一收单交易创建接口)
     * 商户通过该接口进行交易的创建下单
     *
     * @var string
     */
    private $method = 'alipay.trade.create';

    /**
     * pay
     *
     * @param       $endpoint
     * @param array $payload
     *
     * @return mixed|\WannanBigPig\Supports\AccessData
     *
     * @throws InvalidArgumentException
     * @throws \WannanBigPig\Supports\Exceptions\ApplicationException
     * @throws \WannanBigPig\Supports\Exceptions\BusinessException
     *
     * @author   liuml  <liumenglei0211@163.com>
     * @DateTime 2019-04-09  17:21
     */
    public function pay($endpoint, array $payload)
    {
        $payload['method'] = $this->method;
        $payload['sign']   = Support::generateSign($payload);

        return Support::requestApi($payload);
    }
}