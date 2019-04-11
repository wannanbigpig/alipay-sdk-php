<?php
/**
 * PosTrade.php
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

class FaceInitTrade implements PayInterface
{
    /**
     * zoloz.authentication.customer.smilepay.initialize (人脸初始化唤起 zim)
     * 人脸初始化刷脸付
     *
     * @var string
     */
    private $method = 'zoloz.authentication.customer.smilepay.initialize';

    /**
     * pay
     *
     * @param string $gatewayUrl
     * @param array  $payload
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
    public function pay(string $gatewayUrl, array $payload): AccessData
    {
        $payload['method'] = $this->method;

        $payload['sign'] = Support::generateSign($payload);

        return Support::requestApi($gatewayUrl, $payload);
    }
}