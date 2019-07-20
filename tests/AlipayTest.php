<?php
/*
 * This file is part of the wannanbigpig/alipay.
 *
 * (c) wannanbigpig <liuml0211@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace WannanBigPig\Alipay\Tests;

use WannanBigPig\Alipay\Alipay;
use WannanBigPig\Alipay\Payment\Application;
use WannanBigPig\Supports\Str;

class AlipayTest extends TestCase
{
    public function testApp()
    {
        $config = [
            'app_id' => '88888888888888888',
            'private_key_path' => STORAGE_ROOT.'private_key.pem',
            // 'private_key' => file_get_contents(STORAGE_ROOT.'private_key.txt'), // 直接配置此处则私钥文件路径则不用填写
            'alipay_public_Key_path' => STORAGE_ROOT.'alipay_public_key.pem',
            // 'alipay_public_Key' => file_get_contents(STORAGE_ROOT.'alipay_public_Key.txt'), // 直接配置此处则私钥文件路径则不用填写
            'charset' => 'UTF-8',
            'env' => 'dev',
        ];
        $app = Alipay::payment($config);
        $res = $app->pay([
            'out_trade_no' => Str::getRandomInt(),
            'scene' => 'bar_code',
            'auth_code' => '281119023123123123',
            'subject' => 'ceshiapi',
            'total_amount' => '100',
        ]);
        var_dump($res);
        $this->assertInstanceOf(Application::class, $app);
    }
}
