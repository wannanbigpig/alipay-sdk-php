<?php
/*
 * This file is part of the wannanbigpig/alipay-sdk-php.
 *
 * (c) wannanbigpig <liuml0211@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyAlipay\Tests\BaseService\Auth;

use EasyAlipay\Alipay;
use EasyAlipay\BaseService\Auth\Client;
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

    public function testGetAccessToken()
    {
        $method = 'alipay.system.oauth.token';

        $params = [
            'grant_type' => 'authorization_code',
            'code' => '88888888888888888888',
        ];

        $client = $this->mockApiClient(Client::class, [], $this->appClient())->makePartial();

        $client->expects()->request($method, $params)->andReturn('foo');
        $this->assertSame('foo', $client->getAccessToken('88888888888888888888'));

        $params = [
            'grant_type' => 'refresh_token',
            'refresh_token' => '88888888888888888888',
        ];

        $client->expects()->request($method, $params)->andReturn('foo');
        $this->assertSame('foo', $client->getAccessToken('88888888888888888888', 'refresh_token'));
    }

    public function testetAuthorizationUrl()
    {
        $client = $this->mockApiClient(Client::class, [], $this->appClient());

        $this->assertSame('https://openauth.alipay.com/oauth2/publicAppAuthorize.htm?app_id=8888888888888888&scope=auth_base&redirect_uri=http%3A%2F%2Fwww.wannanbigpig.com&state=auth_base',
            $client->getAuthorizationUrl('http://www.wannanbigpig.com'));
    }

    public function testGetUserInfo()
    {
        $method = 'alipay.user.info.share';
        $params = [
            'auth_token' => '88888888888888888888',
        ];

        $client = $this->mockApiClient(Client::class, [], $this->appClient())->makePartial();

        $client->expects()->request($method, $params)->andReturn('foo');
        $this->assertSame('foo', $client->getUserInfo('88888888888888888888'));
    }

    public function testLoginAuthorization()
    {
        $method = 'alipay.user.info.auth';
        $params = [
            'scopes' => 'auth_base',
            'state' => 'state',
        ];

        $client = $this->mockApiClient(Client::class, [], $this->appClient())->makePartial();

        $client->expects()->request($method, [
            'biz_content' => $params,
        ])->andReturn('foo');
        $this->assertSame('foo', $client->loginAuthorization('state'));
    }
}
