<?php
/*
 * This file is part of the wannanbigpig/alipay.
 *
 * (c) wannanbigpig <liuml0211@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyAlipay\Tests\Payment\Base;

use EasyAlipay\Payment\Base\Client;
use EasyAlipay\Tests\Payment\ApplicationTest;
use WannanBigPig\Supports\Str;

/**
 * Class ClientTest
 *
 * @author   liuml  <liumenglei0211@163.com>
 * @DateTime 2019-07-21  14:10
 */
class ClientTest extends ApplicationTest
{
    /**
     * testPay.
     */
    public function testPay()
    {
        $client = $this->mockApiClient(Client::class, ['pay'], $this->appClient())->makePartial();
        $params = [
            'out_trade_no' => Str::getRandomInt(),
            'scene' => 'bar_code',
            'auth_code' => '283856205796385922',
            'subject' => 'ceshiapi',
            'total_amount' => '100',
        ];
        $client->expects()->pay($params)->andReturn('foo');
        $this->assertSame('foo', $client->pay($params));
    }

    /**
     * testCreate.
     */
    public function testCreate()
    {
        $client = $this->mockApiClient(Client::class, ['create'], $this->appClient())->makePartial();
        $params = [
            'out_trade_no' => Str::getRandomInt(),
            'total_amount' => 100,
            'buyer_id' => '2088102177891684',
            'subject' => 'mac X pro 2080',
            'body' => 'mac X pro 2080',
        ];
        $client->expects()->create($params)->andReturn('foo');
        $this->assertSame('foo', $client->create($params));
    }

    /**
     * testPreCreate.
     */
    public function testPreCreate()
    {
        $client = $this->mockApiClient(Client::class, ['preCreate'], $this->appClient())->makePartial();
        $params = [
            'out_trade_no' => Str::getRandomInt(),
            'total_amount' => 100,
            'subject' => 'mac X pro 2080',
            'body' => 'mac X pro 2080',
        ];
        $client->expects()->preCreate($params)->andReturn('foo');
        $this->assertSame('foo', $client->preCreate($params));
    }

    /**
     * testClose.
     */
    public function testClose()
    {
        $client = $this->mockApiClient(Client::class, ['close'], $this->appClient())->makePartial();
        $client->expects()->close('2019072422001491681000170710')->andReturn('foo');
        $this->assertSame('foo', $client->close('2019072422001491681000170710'));
    }

    /**
     * testRefund.
     */
    public function testRefund()
    {
        $client = $this->mockApiClient(Client::class, ['refund'], $this->appClient())->makePartial();
        $client->expects()->refund('2019072422001491681000170710', '100')->andReturn('foo');
        $this->assertSame('foo', $client->refund('2019072422001491681000170710', '100'));
    }

    /**
     * testQuery.
     */
    public function testQuery()
    {
        $client = $this->mockApiClient(Client::class, ['query'], $this->appClient())->makePartial();
        $client->expects()->query('2019072422001491681000170710')->andReturn('foo');
        $this->assertSame('foo', $client->query('2019072422001491681000170710'));
    }

    /**
     * testCancel.
     */
    public function testCancel()
    {
        $client = $this->mockApiClient(Client::class, ['cancel'], $this->appClient())->makePartial();
        $client->expects()->cancel('2019072422001491681000170710')->andReturn('foo');
        $this->assertSame('foo', $client->cancel('2019072422001491681000170710'));
    }

    /**
     * testOrderSettle.
     */
    public function testOrderSettle()
    {
        $client = $this->mockApiClient(Client::class, ['orderSettle'], $this->appClient())->makePartial();
        $client->expects()->orderSettle('1234567890', '2019072422001491681000170710', [
            'trans_in' => '2088102177891684',
            'amount' => '70',
        ])->andReturn('foo');
        $this->assertSame('foo', $client->orderSettle('1234567890', '2019072422001491681000170710', [
            'trans_in' => '2088102177891684',
            'amount' => '70',
        ]));
    }
    
    /**
     * testOrderSettle.
     */
    public function testOrderInfoSync()
    {
        $client = $this->mockApiClient(Client::class, ['orderInfoSync'], $this->appClient())->makePartial();
        $client->expects()->orderInfoSync('2019072422001491681000169170', '4936660400225200', 'CREDIT_AUTH')->andReturn('foo');
        $this->assertSame('foo', $client->orderInfoSync('2019072422001491681000169170', '4936660400225200', 'CREDIT_AUTH'));
    }
}