<?php
/*
 * This file is part of the wannanbigpig/alipay-sdk-php.
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
        $client = $this->mockApiClient(Client::class, [], $this->appClient())->makePartial();
        $params = [
            'scene' => 'bar_code',
            'product_code' => 'FACE_TO_FACE_PAYMENT',
            'out_trade_no' => Str::getRandomInt(),
            'auth_code' => '283856205796385922',
            'subject' => 'ceshiapi',
            'total_amount' => '100',
        ];

        $client->expects()->request('alipay.trade.pay', [
            'biz_content' => $params,
        ])->andReturn('foo');
        $this->assertSame('foo', $client->pay($params));
    }

    /**
     * testCreate.
     */
    public function testCreate()
    {
        $client = $this->mockApiClient(Client::class, [], $this->appClient())->makePartial();
        $params = [
            'out_trade_no' => Str::getRandomInt(),
            'total_amount' => 100,
            'buyer_id' => '2088102177891684',
            'subject' => 'mac X pro 2080',
            'body' => 'mac X pro 2080',
        ];
        $client->expects()->request('alipay.trade.create', [
            'biz_content' => $params,
        ])->andReturn('foo');
        $this->assertSame('foo', $client->create($params));
    }

    /**
     * testPreCreate.
     */
    public function testPreCreate()
    {
        $client = $this->mockApiClient(Client::class, [], $this->appClient())->makePartial();
        $params = [
            'out_trade_no' => Str::getRandomInt(),
            'total_amount' => 100,
            'subject' => 'mac X pro 2080',
            'body' => 'mac X pro 2080',
        ];
        $client->expects()->request('alipay.trade.precreate', [
            'biz_content' => $params,
        ])->andReturn('foo');
        $this->assertSame('foo', $client->preCreate($params));
    }

    /**
     * testClose.
     */
    public function testClose()
    {
        $client = $this->mockApiClient(Client::class, [], $this->appClient())->makePartial();
        $client->expects()->request('alipay.trade.close', [
            'biz_content' => [
                'out_trade_no' => '2019072422001491681000170710',
            ],
        ])->andReturn('foo');
        $this->assertSame('foo', $client->close('2019072422001491681000170710'));
    }

    /**
     * testRefund.
     */
    public function testRefund()
    {
        $client = $this->mockApiClient(Client::class, ['refund'], $this->appClient())->makePartial();
        $client->expects()->request('alipay.trade.refund', [
            'biz_content' => [
                'trade_no' => '2019072422001491681000170710',
                'refund_amount' => '100',
            ],
        ])->andReturn('foo');
        $this->assertSame('foo', $client->refund('2019072422001491681000170710', '100'));
    }

    /**
     * testQuery.
     */
    public function testQuery()
    {
        $client = $this->mockApiClient(Client::class, [], $this->appClient())->makePartial();
        $client->expects()->request('alipay.trade.query', [
            'biz_content' => [
                'out_trade_no' => '2019072422001491681000170710',
            ],
        ])->andReturn('foo');
        $this->assertSame('foo', $client->query('2019072422001491681000170710'));
    }

    /**
     * testCancel.
     */
    public function testCancel()
    {
        $client = $this->mockApiClient(Client::class, [], $this->appClient())->makePartial();
        $client->expects()->request('alipay.trade.cancel', [
            'biz_content' => [
                'out_trade_no' => '2019072422001491681000170710',
            ],
        ])->andReturn('foo');
        $this->assertSame('foo', $client->cancel('2019072422001491681000170710'));
    }

    /**
     * testOrderSettle.
     */
    public function testOrderSettle()
    {
        $client = $this->mockApiClient(Client::class, [], $this->appClient())->makePartial();
        $params = [
            'trans_in' => '2088102177891684',
            'amount' => '70',
        ];
        $client->expects()->request('alipay.trade.order.settle', [
            'biz_content' => [
                'out_request_no' => '1234567890',
                'trade_no' => '2019072422001491681000170710',
                'royalty_parameters' => [$params],
            ],
        ])->andReturn('foo');
        $this->assertSame('foo', $client->orderSettle('1234567890', '2019072422001491681000170710', $params));
        $params = [
            [
                'trans_in' => '2088102177891684',
                'amount' => '70',
            ],
        ];
        $this->assertSame('foo', $client->orderSettle('1234567890', '2019072422001491681000170710', $params));
    }

    /**
     * testOrderSettle.
     */
    public function testOrderInfoSync()
    {
        $client = $this->mockApiClient(Client::class, [], $this->appClient())->makePartial();
        $client->expects()->request('alipay.trade.orderinfo.sync', [
            'biz_content' => [
                'trade_no' => '2019072422001491681000169170',
                'out_request_no' => '4936660400225200',
                'biz_type' => 'CREDIT_AUTH',
            ],
        ])->andReturn('foo');
        $this->assertSame('foo', $client->orderInfoSync('2019072422001491681000169170', '4936660400225200', 'CREDIT_AUTH'));
        $client->expects()->request('alipay.trade.orderinfo.sync', [
            'biz_content' => [
                'trade_no' => '2019072422001491681000169170',
                'out_request_no' => '4936660400225200',
                'biz_type' => 'CREDIT_AUTH',
                'order_biz_info' => '{"status":"COMPLETE"}'
            ],
        ])->andReturn('foo');
        $this->assertSame('foo', $client->orderInfoSync('2019072422001491681000169170', '4936660400225200', 'CREDIT_AUTH', null, "COMPLETE"));
    }
}