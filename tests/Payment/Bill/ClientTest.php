<?php
/*
 * This file is part of the wannanbigpig/alipay.
 *
 * (c) wannanbigpig <liuml0211@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyAlipay\Tests\Payment\Bill;

use EasyAlipay\Payment\Bill\Client;
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
        $client = $this->mockApiClient(Client::class, ['get'], $this->appClient());
        $client->expects()->get('trade', '2019-06')->andReturn('foo');
        $this->assertSame('foo', $client->get('trade','2019-06'));
    }
}