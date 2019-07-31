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

class SupportTest extends TestCase
{

    public function testRequest()
    {
        $client = $this->mockApiClient(Support::class, ['request', 'handleResponse'], new ServiceContainer([]))->makePartial();
        $url = 'http://wannanbigpig.com';
        $query = ['foo' => 'bar'];
        $client->expects()->request($url, $query)->andReturn('mock-result');
        $respons = new \GuzzleHttp\Psr7\Response(200, [], '{"foo":"bar"}');

        $this->assertSame('mock-result', $client->request($url, $query));
        $this->assertSame($query, $client->handleResponse($respons));
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

        $this->assertArrayHasKey('foo', $client->json(['foo'=>'bar']));
        $this->assertInstanceOf('Closure', $client->logMiddleware());
    }
}
