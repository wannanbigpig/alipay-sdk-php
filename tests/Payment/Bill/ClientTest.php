<?php
/*
 * This file is part of the wannanbigpig/alipay-sdk-php.
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
    public function testGet()
    {
        $client = $this->mockApiClient(Client::class, [], $this->appClient());
        $client->expects()->request('alipay.data.dataservice.bill.downloadurl.query', [
            'biz_content' => [
                'bill_type' => 'trade',
                'bill_date' => '2019-06',
            ],
        ])->andReturn('foo');
        $this->assertSame('foo', $client->get('trade','2019-06'));
    }
}