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
     * @param       $uri
     * @param array $content
     *
     * @return mixed
     *
     *
     * @author   liuml  <liumenglei0211@163.com>
     *
     * @DateTime 2019-04-01  15:39
     */
    public function pay($uri, array $content);
}