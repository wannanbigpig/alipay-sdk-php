<?php
/**
 * PayInterface.php
 *
 * Created by PhpStorm.
 *
 * author: liuml  <liumenglei0211@163.com>
 *
 * DateTime: 2019-04-01  15:04
 */

namespace WannanBigPig\Alipay\Payment;


Interface PayInterface
{
    /**
     * pay
     *
     * @param string $gatewayUrl
     * @param array  $payload
     *
     * @return mixed
     *
     * @author   liuml  <liumenglei0211@163.com>
     * @DateTime 2019-04-10  15:10
     */
    public function pay(string $gatewayUrl, array $payload);
}