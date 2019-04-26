<?php
/**
 * App.php
 *
 * Created by PhpStorm.
 *
 * author: liuml  <liumenglei0211@163.com>
 * DateTime: 2019-04-04  16:36
 */

namespace WannanBigPig\Alipay\Payment\Trade;

use Symfony\Component\HttpFoundation\Response;
use WannanBigPig\Alipay\Kernel;
use WannanBigPig\Alipay\Kernel\Support\Support;
use WannanBigPig\Alipay\Payment\DoctorInterface;

class App implements DoctorInterface
{

    /**
     * alipay.trade.app.pay (app 支付接口 2.0)
     * 外部商户 APP 唤起快捷 SDK 创建订单并支付
     *
     * @var string
     */
    private $method = 'alipay.trade.app.pay';

    /**
     * exec
     *
     * @param  array  $params
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function exec(array $params): Response
    {
        return Support::executeSdk($params, $this->method);
    }
}
