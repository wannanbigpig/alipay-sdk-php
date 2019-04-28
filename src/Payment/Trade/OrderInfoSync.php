<?php
/**
 * OrderInfoSync.php
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

class OrderInfoSync implements DoctorInterface
{
    /**
     * alipay.trade.orderinfo.sync(支付宝订单信息同步接口)
     * 该接口用于商户向支付宝同步该笔订单相关业务信息
     *
     * @var string
     */
    private $close = 'alipay.trade.orderinfo.sync';

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
