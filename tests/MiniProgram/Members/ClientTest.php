<?php
/*
 * This file is part of the wannanbigpig/alipay-sdk-php.
 *
 * (c) wannanbigpig <liuml0211@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyAlipay\Tests\MiniProgram\Members;

use EasyAlipay\MiniProgram\Members\Client;
use EasyAlipay\Tests\MiniProgram\ApplicationTest;

class ClientTest extends ApplicationTest
{
    public function testCreate()
    {
        $method = 'alipay.open.app.members.create';
        $params = [
            'logon_id' => '1234556',
            'role' => 'EXPERIENCER',
        ];

        $client = $this->mockApiClient(Client::class, [], $this->appClient())->makePartial();

        $client->expects()->request($method, [
            'biz_content' => $params,
        ])->andReturn('foo');
        $this->assertSame('foo', $client->create('1234556'));
    }

    public function testQuery()
    {
        $method = 'alipay.open.app.members.query';
        $params = [
            'role' => 'EXPERIENCER',
        ];

        $client = $this->mockApiClient(Client::class, [], $this->appClient())->makePartial();

        $client->expects()->request($method, [
            'biz_content' => $params,
        ])->andReturn('foo');
        $this->assertSame('foo', $client->query());
    }

    public function testDelete()
    {
        $method = 'alipay.open.app.members.delete';
        $params = [
            'user_id' => '123',
            'role' => 'EXPERIENCER',
        ];

        $client = $this->mockApiClient(Client::class, [], $this->appClient())->makePartial();

        $client->expects()->request($method, [
            'biz_content' => $params,
        ])->andReturn('foo');
        $this->assertSame('foo', $client->delete('123'));
    }
}
