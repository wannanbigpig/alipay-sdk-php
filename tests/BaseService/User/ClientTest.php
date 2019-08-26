<?php
/*
 * This file is part of the wannanbigpig/alipay-sdk-php.
 *
 * (c) wannanbigpig <liuml0211@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyAlipay\Tests\BaseService\User;

use EasyAlipay\Alipay;
use EasyAlipay\BaseService\User\Client;
use EasyAlipay\Tests\TestCase;

class ClientTest extends TestCase
{
    /**
     * appClient.
     *
     * @return \EasyAlipay\MiniProgram\ApplicationTest
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

        return Alipay::miniProgram($config);
    }

    public function testCertifyInitialize()
    {
        $method = 'alipay.user.certify.open.initialize';

        $params = [
            'outer_order_no' => 'ZGYD201809132323000001234',
            // ...
        ];
        $client = $this->mockApiClient(Client::class, [], $this->appClient())->makePartial();
        $client->expects()->request($method, [
            'biz_content' => $params,
        ])->andReturn('foo');
        $this->assertSame('foo', $client->certifyInitialize($params));
    }


    public function testCertifyStart()
    {
        $method = 'alipay.user.certify.open.certify';

        $params = [
            'certify_id' => 'OC201809253000000393900404029253',
        ];
        $client = $this->mockApiClient(Client::class, [], $this->appClient())->makePartial();
        $client->expects()->request($method, [
            'biz_content' => $params,
        ])->andReturn('foo');
        $this->assertSame('foo', $client->certifyStart('OC201809253000000393900404029253'));
    }

    public function testGetCertifyStatus()
    {
        $method = 'alipay.user.certify.open.query';

        $params = [
            'certify_id' => 'OC201809253000000393900404029253',
        ];
        $client = $this->mockApiClient(Client::class, [], $this->appClient())->makePartial();
        $client->expects()->request($method, [
            'biz_content' => $params,
        ])->andReturn('foo');
        $this->assertSame('foo', $client->getCertifyStatus('OC201809253000000393900404029253'));
    }
}
