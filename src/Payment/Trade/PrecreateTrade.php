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

use WannanBigPig\Alipay\Kernel\Support\Support;
use WannanBigPig\Alipay\Payment\PayInterface;
use WannanBigPig\Supports\AccessData;
use WannanBigPig\Supports\Exceptions;

class PrecreateTrade implements PayInterface
{
    /**
     * method
     *
     * @var string
     */
    private $method = 'alipay.trade.precreate';

    /**
     * pay
     *
     * @param       $endpoint
     * @param array $payload
     *
     * @return AccessData
     *
     * @throws Exceptions\ApplicationException
     * @throws Exceptions\BusinessException
     * @throws Exceptions\InvalidArgumentException
     *
     * @author   liuml  <liumenglei0211@163.com>
     * @DateTime 2019-04-10  09:26
     */
    public function pay($endpoint, array $payload): AccessData
    {
        $payload['method'] = $this->method;

        $payload['sign'] = Support::generateSign($payload);

        return Support::requestApi($payload);
    }
}
