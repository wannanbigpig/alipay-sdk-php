<?php
/*
 * This file is part of the wannanbigpig/alipay-sdk-php.
 *
 * (c) wannanbigpig <liuml0211@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyAlipay\Tests\Kernel;

use EasyAlipay\Kernel\ServiceContainer;
use EasyAlipay\Tests\TestCase;
use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\Request;
use WannanBigPig\Supports\Config;
use WannanBigPig\Supports\Exceptions\RuntimeException;
use WannanBigPig\Supports\Logs\Log;

class ServiceContainerTest extends TestCase
{
    public function testBasicFeatures()
    {
        $container = new ServiceContainer();

        $this->assertNotEmpty($container->getProviders());

        // __set, __get, offsetGet
        $this->assertInstanceOf(Config::class, $container['config']);
        $this->assertInstanceOf(Config::class, $container->config);

        $this->assertInstanceOf(Client::class, $container['http_client']);
        $this->assertInstanceOf(Request::class, $container['request']);
        $this->assertInstanceOf(Log::class, $container['logger']);

        $container['foo'] = 'foo';

        $this->assertSame('foo', $container['foo']);
    }

    public function testGetConfig()
    {
        $service = new ServiceContainer(['app_id' => 'app-id1']);
        $service->setEndpointConfig('pay', ['foo' => 'bar']);
        $service->setAppAuthToken('234123234123412');
        $this->assertInternalType('array', $service->getConfig());
        $this->assertInternalType('array', $service->apiCommonConfig('pay'));
        $this->assertSame('https://openapi.alipay.com/gateway.do', $service->getGateway());
        $service = new ServiceContainer(['app_id' => 'app-id1', 'sandbox' => true]);
        $this->assertSame('https://openapi.alipaydev.com/gateway.do', $service->getGateway());
    }

    public function testRuntimeException()
    {
        $this->expectException(RuntimeException::class);
        $service = new ServiceContainer();
        $service->foo;
    }
}
