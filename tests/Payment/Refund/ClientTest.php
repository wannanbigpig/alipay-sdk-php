<?php
/*
 * This file is part of the wannanbigpig/alipay-sdk-php.
 *
 * (c) wannanbigpig <liuml0211@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyAlipay\Tests\Payment\Refund;

use EasyAlipay\Payment\Refund\Client;
use EasyAlipay\Tests\Payment\ApplicationTest;

/**
 * Class ClientTest
 *
 * @author   liuml  <liumenglei0211@163.com>
 * @DateTime 2019-07-21  14:10
 */
class ClientTest extends ApplicationTest
{
    /**
     * testApp.
     */
    public function testQuery()
    {
        $client = $this->mockApiClient(Client::class, ['query'], $this->appClient());
        $client->expects()->query('1234567890')->andReturn('foo');
        $this->assertSame('foo', $client->query('1234567890'));
    }

    /**
     * testWap.
     *
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function testPage()
    {
        $app = $this->appClient();
        $res = $app->refund->page('1111111111111', '100', '11111');
        $this->assertInternalType('string', $res);
    }
}
