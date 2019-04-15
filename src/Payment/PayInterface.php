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

interface PayInterface
{
    /**
     * pay
     *
     * @param array $params
     *
     * @return mixed
     *
     * @author   liuml  <liumenglei0211@163.com>
     * @DateTime 2019-04-11  15:10
     */
    public function pay(array $params);
}
