<?php
/*
 * This file is part of the wannanbigpig/alipay-sdk-php.
 *
 * (c) wannanbigpig <liuml0211@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyAlipay\Payment;

use EasyAlipay\Kernel\ServiceContainer;

/**
 * Class Application
 *
 * @author   liuml  <liumenglei0211@163.com>
 * @DateTime 2019-07-18  16:13
 *
 * @property Pay\Client          $pay
 * @property Refund\Client       $refund
 * @property Bill\Client         $bill
 * @property FundAccredit\Client $fundAccredit
 *
 * @method mixed pay(array $params)
 * @method mixed create(array $params)
 * @method mixed preCreate(array $params)
 * @method mixed close(string $outTradeNo, string $tradeNo = null, string $operatorId = null)
 * @method mixed refund(string $tradeNo, $amount, string $outTradeNo = null, array $params = [])
 * @method mixed query(string $outTradeNo, string $tradeNo = null, string $orgPid = null)
 * @method mixed cancel(string $outTradeNo, string $tradeNo = null)
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
        'fundAccredit' => FundAccredit\Client::class,
    ];

    /**
     * __call.
     *
     * @param $name
     * @param $arguments
     *
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return call_user_func_array([$this['base'], $name], $arguments);
    }

    /**
     * setNotifyUrl.
     *
     * @param string $notifyUrl
     *
     * @return $this
     */
    public function setNotifyUrl(string $notifyUrl)
    {
        $this->config->set('notify_url', $notifyUrl);

        return $this;
    }

    /**
     * setReturnUrl.
     *
     * @param string $returnUrl
     *
     * @return $this
     */
    public function setReturnUrl(string $returnUrl)
    {
        $this->config->set('return_url', $returnUrl);

        return $this;
    }
}
