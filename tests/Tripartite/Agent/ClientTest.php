<?php
/*
 * This file is part of the wannanbigpig/alipay-sdk-php.
 *
 * (c) wannanbigpig <liuml0211@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyAlipay\Tests\Tripartite\Agent;

use EasyAlipay\Tests\Tripartite\ApplicationTest;
use EasyAlipay\Tripartite\Agent\Client;

class ClientTest extends ApplicationTest
{
    public function testCreate()
    {
        $client = $this->mockApiClient(Client::class, [], $this->appClient())->makePartial();
        $params = [
            'account' => 'test@alipay.com',
            'contact_info' => [
                'contact_name' => '张三',
                'contact_mobile' => '18866668888',
                'contact_email' => 'zhangsan@alipy.com',
            ],
            'order_ticket' => '00ee2d475f374ad097ee0f1ac223fX00',
        ];

        $client->expects()->request('alipay.open.agent.create', [
            'biz_content' => $params,
        ])->andReturn('foo');
        $this->assertSame('foo', $client->create('test@alipay.com', [
            'contact_name' => '张三',
            'contact_mobile' => '18866668888',
            'contact_email' => 'zhangsan@alipy.com',
        ], '00ee2d475f374ad097ee0f1ac223fX00'));
    }

    public function testConfirm()
    {
        $client = $this->mockApiClient(Client::class, [], $this->appClient())->makePartial();
        $params = [
            'batch_no' => '2017110616474516400082883',
        ];

        $client->expects()->request('alipay.open.agent.confirm', [
            'biz_content' => $params,
        ])->andReturn('foo');
        $this->assertSame('foo', $client->confirm('2017110616474516400082883'));
    }

    public function testCancel()
    {
        $method = 'alipay.open.agent.cancel';

        $client = $this->mockApiClient(Client::class, [], $this->appClient())->makePartial();
        $params = [
            'batch_no' => '2017110616474516400082883',
        ];

        $client->expects()->request($method, [
            'biz_content' => $params,
        ])->andReturn('foo');
        $this->assertSame('foo', $client->cancel('2017110616474516400082883'));
    }

    public function testQuery()
    {
        $method = 'alipay.open.agent.order.query';
        $client = $this->mockApiClient(Client::class, [], $this->appClient())->makePartial();
        $params = [
            'batch_no' => '2017110616474516400082883',
        ];

        $client->expects()->request($method, [
            'biz_content' => $params,
        ])->andReturn('foo');
        $this->assertSame('foo', $client->query('2017110616474516400082883'));
    }

    public function testSignStatus()
    {
        $method = 'alipay.open.agent.signstatus.query';

        $client = $this->mockApiClient(Client::class, [], $this->appClient())->makePartial();
        $params = [
            'pid' => '2088123451234543',
            'product_codes' => 'FACE_TO_FACE_PAYMENT',
        ];
        $client->expects()->request($method, [
            'biz_content' => $params,
        ])->andReturn('foo');
        $this->assertSame('foo', $client->signStatus('2088123451234543', 'FACE_TO_FACE_PAYMENT'));
    }


    public function testMiniCreate()
    {
        $method = 'alipay.open.agent.mini.create';
        $client = $this->mockApiClient(Client::class, [], $this->appClient())->makePartial();
        $params = [
            'batch_no' => '2017110616474516400082883',
            // ...
        ];

        $client->expects()->request($method, $params)->andReturn('foo');
        $this->assertSame('foo', $client->miniCreate($params));
    }

    public function testAppPayment()
    {
        $method = 'alipay.open.agent.mobilepay.sign';
        $client = $this->mockApiClient(Client::class, [], $this->appClient())->makePartial();
        $params = [
            'batch_no' => '2017110616474516400082883',
            // ...
        ];

        $client->expects()->request($method, $params)->andReturn('foo');
        $this->assertSame('foo', $client->appPayment($params));
    }

    public function testFaceToFace()
    {
        $method = 'alipay.open.agent.facetoface.sign';
        $client = $this->mockApiClient(Client::class, [], $this->appClient())->makePartial();
        $params = [
            'batch_no' => '2017110616474516400082883',
            // ...
        ];

        $client->expects()->request($method, $params)->andReturn('foo');
        $this->assertSame('foo', $client->faceToFace($params));
    }

    public function testSesameCredit()
    {
        $method = 'alipay.open.agent.zhimabrief.sign';
        $client = $this->mockApiClient(Client::class, [], $this->appClient())->makePartial();
        $params = [
            'batch_no' => '2017110616474516400082883',
            // ...
        ];

        $client->expects()->request($method, $params)->andReturn('foo');
        $this->assertSame('foo', $client->sesameCredit($params));
    }

    public function testOfflinePayment()
    {
        $method = 'alipay.open.agent.offlinepayment.sign';
        $client = $this->mockApiClient(Client::class, [], $this->appClient())->makePartial();
        $params = [
            'batch_no' => '2017110616474516400082883',
            // ...
        ];

        $client->expects()->request($method, $params)->andReturn('foo');
        $this->assertSame('foo', $client->offlinePayment($params));
    }
}
