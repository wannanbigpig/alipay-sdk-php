<?php
/*
 * This file is part of the wannanbigpig/alipay.
 *
 * (c) wannanbigpig <liuml0211@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace WannanBigPig\Alipay\Payment;

use Closure;
use WannanBigPig\Alipay\Kernel\ServiceContainer;
use WannanBigPig\Alipay\Payment\Notify\Handle;

/**
 * Class Application
 *
 * @author   liuml  <liumenglei0211@163.com>
 * @DateTime 2019-07-18  16:13
 *
 * @property Pay\Client    $pay
 * @property Refund\Client $refund
 * @property Bill\Client   $bill
 *
 * @method mixed pay(array $params)
 * @method mixed create(array $params)
 * @method mixed preCreate(array $params)
 * @method mixed close(string $tradeNo, string $outTradeNo = null, string $operatorId = null)
 * @method mixed refund(string $tradeNo, $amount, string $outTradeNo = null, array $params = [])
 * @method mixed query(string $tradeNo, string $outTradeNo = null, string $orgPid = null)
 * @method mixed cancel(string $tradeNo, string $outTradeNo = null)
 * @method mixed orderSettle(string $outRequestNo, string $tradeNo, array $royaltyParameters, string $operatorId = null)
 * @method mixed orderInfoSync(string $tradeNo, string $outRequestNo, string $bizType, string $origRequestNo = null, string $orderBizInfo = null)
 */
class Application extends ServiceContainer
{

    /**
     * @var array
     */
    protected $providers = [
        'base' => Base\Client::class,
        'pay' => Pay\Client::class,
        'refund' => Refund\Client::class,
        'bill' => Bill\Client::class,
    ];

    /**
     * @param string $name
     * @param array  $arguments
     *
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return call_user_func_array([$this['base'], $name], $arguments);
    }

    /**
     * handleNotify.
     *
     * @param \Closure $closure
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handleNotify(Closure $closure)
    {
        return (new Handle($this))->run($closure);
    }
}
