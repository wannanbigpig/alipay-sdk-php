<?php
/**
 * Pos.php
 *
 * Created by PhpStorm.
 *
 * author: liuml  <liumenglei0211@163.com>
 * DateTime: 2019-04-09  15:57
 */

namespace WannanBigPig\Alipay\Payment\Trade;

use WannanBigPig\Alipay\Kernel\Exceptions\SignException;
use WannanBigPig\Alipay\Kernel\Support\Support;
use WannanBigPig\Alipay\Payment\PayInterface;
use WannanBigPig\Supports\AccessData;
use WannanBigPig\Supports\Exceptions;

class Pos implements PayInterface
{
    /**
     * alipay.trade.pay (统一收单交易支付接口) 商户主扫
     * 收银员使用扫码设备读取用户手机支付宝 “付款码”/ 声波获取设备（如麦克风）读取用户手机支付宝的声波信息后，
     * 将二维码或条码信息 / 声波信息通过本接口上送至支付宝发起支付。
     *
     * @var string
     */
    private $method = 'alipay.trade.pay';

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