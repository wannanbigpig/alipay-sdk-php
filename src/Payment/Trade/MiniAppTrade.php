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

use WannanBigPig\Alipay\Kernel\Exceptions\SignException;
use WannanBigPig\Alipay\Kernel\Support\Support;
use WannanBigPig\Alipay\Payment\PayInterface;
use WannanBigPig\Supports\AccessData;
use WannanBigPig\Supports\Exceptions;

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
     * @param array $params
     *
     * @return AccessData
     *
     * @throws Exceptions\BusinessException
     * @throws Exceptions\InvalidArgumentException
     * @throws SignException
     *
     * @author   liuml  <liumenglei0211@163.com>
     * @DateTime 2019-04-11  10:42
     */
    public function pay(array $params): AccessData
    {
        return Support::executeApi($params, $this->method);
    }
}
