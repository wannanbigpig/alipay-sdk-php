<?php
/**
 * Doctor.php
 *
 * Created by PhpStorm.
 *
 * author: liuml  <liumenglei0211@163.com>
 * DateTime: 2019-04-12  11:29
 */

namespace WannanBigPig\Alipay\Payment;

interface DoctorInterface
{
    /**
     * exce
     *
     * @param array $params
     *
     * @return mixed
     *
     * @author   liuml  <liumenglei0211@163.com>
     * @DateTime 2019-04-12  11:29
     */
    public function exce(array $params);
}
