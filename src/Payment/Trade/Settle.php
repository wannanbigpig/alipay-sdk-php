<?php
/**
 * Settle.php
 *
 * Created by PhpStorm.
 *
 * author: liuml  <liumenglei0211@163.com>
 * DateTime: 2019-04-09  15:57
 */

namespace WannanBigPig\Alipay\Payment\Trade;

use WannanBigPig\Alipay\Kernel\Exceptions\SignException;
use WannanBigPig\Alipay\Kernel\Support\Support;
use WannanBigPig\Alipay\Payment\DoctorInterface;
use WannanBigPig\Supports\AccessData;
use WannanBigPig\Supports\Exceptions;

class Settle implements DoctorInterface
{
    /**
     * alipay.trade.order.settle(统一收单交易结算接口)
     * 用于在线下场景交易支付后，进行结算
     *
     * @var string
     */
    private $close = 'alipay.trade.order.settle';

    /**
     * exec
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
     * @DateTime 2019-04-12  11:36
     */
    public function exec(array $params): AccessData
    {
        return Support::executeApi($params, $this->close);
    }
}
