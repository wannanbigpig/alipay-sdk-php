<?php
/**
 * GatewaysInterface.php
 *
 * Created by PhpStorm.
 *
 * author: liuml  <liumenglei0211@163.com>
 *
 * DateTime: 2019-04-01  15:02
 */

namespace WannanBigPig\Alipay\Payment;


interface GatewaysInterface
{
    /**
     * pay
     *
     * @param $gateway
     * @param $params
     *
     * @return mixed
     *
     * @author   liuml  <liumenglei0211@163.com>
     *
     * @DateTime 2019-04-02  14:47
     */
    public function pay($gateway, $params = []);

    /**
     * refund
     *
     * @param $order
     *
     * @return mixed
     *
     * @author   liuml  <liumenglei0211@163.com>
     *
     * @DateTime 2019-04-02  15:49
     */
    public function refund($order);
}