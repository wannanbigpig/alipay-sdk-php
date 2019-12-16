<?php
/*
 * This file is part of the wannanbigpig/alipay-sdk-php.
 *
 * (c) wannanbigpig <liuml0211@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyAlipay\Tests\BaseService\Base;

use EasyAlipay\Alipay;
use EasyAlipay\BaseService\Base\Client;
use EasyAlipay\Tests\TestCase;

class ClientTest extends TestCase
{

    /**
     * appClient.
     *
     * @return \EasyAlipay\BaseService\Application
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

        return Alipay::baseService($config);
    }

    /**
     * testQueryAppAuthToken.
     */
    public function testQueryAppAuthToken()
    {
        $method = 'alipay.open.auth.token.app.query';

        $params = [
            'biz_content' => [
                'app_auth_token' => '201509BBeff9351ad1874306903e96b91d248A36',
            ],
        ];


        $client = $this->mockApiClient(Client::class, [], $this->appClient())->makePartial();

        $client->expects()->request($method, $params)->andReturn('foo');
        $this->assertSame('foo', $client->queryAppAuthToken('201509BBeff9351ad1874306903e96b91d248A36'));
    }
}
