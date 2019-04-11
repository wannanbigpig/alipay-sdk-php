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

use Symfony\Component\HttpFoundation\Response;
use WannanBigPig\Supports\AccessData;

interface ApplicationInterface
{
    /**
     * pay
     *
     * @param $gateway
     * @param $params
     *
     * @return AccessData|Response
     *
     * @author   liuml  <liumenglei0211@163.com>
     *
     * @DateTime 2019-04-02  14:47
     */
    public function pay($gateway, $params = []);

    /**
     * refund
     *
     * @param $params
     *
     * @return AccessData
     *
     * @author   liuml  <liumenglei0211@163.com>
     *
     * @DateTime 2019-04-02  15:49
     */
    public function refund(array $params);

    /**
     * query
     *
     * @param array  $params
     * @param string $method
     *
     * @return AccessData
     *
     * @author   liuml  <liumenglei0211@163.com>
     * @DateTime 2019-04-10  16:28
     */
    public function query(array $params, string $method);

    /**
     * cancel
     *
     * @param array $params
     *
     * @return AccessData
     *
     * @author   liuml  <liumenglei0211@163.com>
     * @DateTime 2019-04-10  17:28
     */
    public function cancel(array $params);

    /**
     * close
     *
     * @param array $params
     *
     * @return AccessData
     *
     * @author   liuml  <liumenglei0211@163.com>
     * @DateTime 2019-04-10  17:28
     */
    public function close(array $params);
}