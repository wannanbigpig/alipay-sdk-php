<?php
/*
 * This file is part of the wannanbigpig/alipay-sdk-php.
 *
 * (c) wannanbigpig <liuml0211@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyAlipay\Tests\Kernel\Support;

use EasyAlipay\Kernel\ServiceContainer;
use EasyAlipay\Kernel\Support\Support;
use EasyAlipay\Tests\TestCase;
use GuzzleHttp\Psr7\Response;

class SupportTest extends TestCase
{
    public function testRequest()
    {
        $config = [
            'sys_params' => [
                'app_id' => '201600000000',
                'charset' => 'UTF-8', // 默认 UTF-8
                'sign_type' => 'RSA2', // 默认 RSA2
                'notify_url' => 'http://docs.wannanbigpig.com/',
                'return_url' => 'http://docs.wannanbigpig.com/',
            ],
            'private_key_path' => STORAGE_ROOT.'private_key.pem',
            'alipay_public_Key_path' => STORAGE_ROOT.'alipay_public_key.pem',
        ];
        $app = new ServiceContainer($config);
        $client = $this->mockApiClient(Support::class, ['performRequest', 'checkResponseSign'], $app)->makePartial();
        $params = [
            'foo' => 'bar',
            'timestamp' => date('Y-m-d H:i:s'),
        ];

        $sysParams = $app->apiCommonConfig('pay');
        $sysParams = array_filter($sysParams, function ($value) use ($client) {
            return !($client->checkEmpty($value));
        });
        $sysParams['sign'] = $client->generateSign(array_merge($sysParams, $params), $sysParams['sign_type']);


        $options = [
            'form_params' => $params,
            'headers' => [
                'content-type' => 'application/x-www-form-urlencoded',
                'charset' => 'UTF-8',
            ],
        ];

        $response = new Response(200, [], '{"foo":"bar"}');
        $client->pushMiddleware($client->logMiddleware(), 'log');

        $client->expects()->performRequest('POST', '?'.http_build_query($sysParams), $options)->andReturn($response);
        $client->expects()->checkResponseSign('{"foo":"bar"}', null)->andReturn(true);
        // $returnResponse = false
        $this->assertSame(['foo' => 'bar'], $client->request('pay', $params, 'POST', $options, false));
    }

    public function testHandleResponse()
    {
        $client = $this->mockApiClient(Support::class, [], new ServiceContainer([]))->makePartial();
        $url = 'http://wannanbigpig.com';
        $query = ['foo' => 'bar'];
        $respons = new \GuzzleHttp\Psr7\Response(200, [], '{"foo":"bar"}');

        $this->assertSame($query, $client->handleResponse($respons));
        $this->assertSame($query, $client->handleResponse($respons, '{"foo":"bar"}'));
    }

    /**
     * testLogMiddleware.
     */
    public function testLogMiddleware()
    {
        $app = new ServiceContainer([]);
        $client = $this->mockApiClient(Support::class, ['logMiddleware', 'json'], $app)
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        $this->assertArrayHasKey('foo', $client->json(['foo' => 'bar']));
        $this->assertInstanceOf('Closure', $client->logMiddleware());
    }
}
