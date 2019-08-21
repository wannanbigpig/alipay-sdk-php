<?php
/*
 * This file is part of the wannanbigpig/alipay-sdk-php.
 *
 * (c) wannanbigpig <liuml0211@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyAlipay\Tests\Tripartite;

use EasyAlipay\Alipay;
use EasyAlipay\Tests\TestCase;
use EasyAlipay\Tripartite\Application;

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
     * @return \EasyAlipay\Tripartite\Application
     */
    public function appClient()
    {
        $config = [
            'sys_params' => [
                'app_id' => '8888888888888888',
                'charset' => 'UTF-8', // 默认 UTF-8
                'sign_type' => 'RSA2', // 默认 RSA2
                'notify_url' => 'http://docs.wannanbigpig.com/',
                'return_url' => 'http://docs.wannanbigpig.com/',
            ],
            'private_key_path' => STORAGE_ROOT.'private_key.pem',
            // 'private_key' => file_get_contents(STORAGE_ROOT.'private_key.txt'), // 直接配置此处则私钥文件路径则不用填写
            'alipay_public_Key_path' => STORAGE_ROOT.'alipay_public_key.pem',
            // 'alipay_public_Key' => file_get_contents(STORAGE_ROOT.'alipay_public_Key.txt'), // 直接配置此处则私钥文件路径则不用填写
            'charset' => 'UTF-8',
            'env' => 'dev',
        ];

        return Alipay::tripartite($config);
    }

    public function testClient()
    {
        $config = [
            'app_id' => '8888888888888888',
            'private_key_path' => STORAGE_ROOT.'private_key.pem',
            // 'private_key' => file_get_contents(STORAGE_ROOT.'private_key.txt'), // 直接配置此处则私钥文件路径则不用填写
            'alipay_public_Key_path' => STORAGE_ROOT.'alipay_public_key.pem',
            // 'alipay_public_Key' => file_get_contents(STORAGE_ROOT.'alipay_public_Key.txt'), // 直接配置此处则私钥文件路径则不用填写
            'charset' => 'UTF-8',
            'return_url' => 'http://www.wannanbigpig.com/',
            'env' => 'dev',
        ];

        $app = Alipay::tripartite($config);

        $this->assertInstanceOf(Application::class, $app);
        $this->assertInstanceOf(Application::class, $app->setNotifyUrl('alipay.docs.wannanbigpig.com'));
        $this->assertInstanceOf(Application::class, $app->setReturnUrl('alipay.docs.wannanbigpig.com'));
        $this->assertSame('fail', $app->handleNotify(function () {

        })->getContent());
        // $this->expectException(RuntimeException::class);
        // $app->foo([]);
    }
}