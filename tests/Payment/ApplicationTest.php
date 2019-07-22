<?php
/*
 * This file is part of the wannanbigpig/alipay.
 *
 * (c) wannanbigpig <liuml0211@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace WannanBigPig\Alipay\Tests\Payment;

use WannanBigPig\Alipay\Alipay;
use WannanBigPig\Alipay\Tests\TestCase;

/**
 * Class ApplicationTest
 *
 * @author   liuml  <liumenglei0211@163.com>
 * @DateTime 2019-07-21  15:14
 */
class ApplicationTest extends TestCase
{
    /**
     * appClient.
     *
     * @return \WannanBigPig\Alipay\Payment\Application
     */
    public function appClient()
    {
        $config = [
            'app_id' => '2016092600598145',
            'private_key_path' => STORAGE_ROOT.'private_key.pem',
            // 'private_key' => file_get_contents(STORAGE_ROOT.'private_key.txt'), // 直接配置此处则私钥文件路径则不用填写
            'alipay_public_Key_path' => STORAGE_ROOT.'alipay_public_key.pem',
            // 'alipay_public_Key' => file_get_contents(STORAGE_ROOT.'alipay_public_Key.txt'), // 直接配置此处则私钥文件路径则不用填写
            'charset' => 'UTF-8',
            'return_url' => 'http://www.wannanbigpig.com/',
            'env' => 'dev',
        ];

        return Alipay::payment($config);
    }
}