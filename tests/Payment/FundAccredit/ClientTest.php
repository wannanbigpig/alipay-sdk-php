<?php
/*
 * This file is part of the wannanbigpig/alipay-sdk-php.
 *
 * (c) wannanbigpig <liuml0211@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyAlipay\Tests\Payment\FundAccredit;

use EasyAlipay\Tests\Payment\ApplicationTest;
use EasyAlipay\Payment\FundAccredit\Client;

class ClientTest extends ApplicationTest
{
    public function testQuery()
    {
        $method = 'alipay.fund.auth.operation.detail.query';

        $client = $this->mockApiClient(Client::class, [], $this->appClient())->makePartial();
        $params = [
            'auth_no' => '2014021601002000640012345678',
            'operation_id' => '20140216010020006400',
        ];

        $client->expects()->request($method, [
            'biz_content' => $params,
        ])->andReturn('foo');

        $this->assertSame('foo', $client->query($params));
    }

    public function testCancel()
    {
        $method = 'alipay.fund.auth.operation.cancel';
        $client = $this->mockApiClient(Client::class, [], $this->appClient())->makePartial();
        $params = [
            'auth_no' => '2014021601002000640012345678',
            'operation_id' => '20140216010020006400',
            'remark' => '授权撤销',
        ];

        $client->expects()->request($method, [
            'biz_content' => $params,
        ])->andReturn('foo');

        $this->assertSame('foo', $client->cancel($params));
    }

    public function testFreeze()
    {
        $method = 'alipay.fund.auth.order.freeze';
        $client = $this->mockApiClient(Client::class, [], $this->appClient())->makePartial();
        $params = [
            'auth_code' => '2014021601002000640012345678',
            // ...
        ];

        $client->expects()->request($method, [
            'biz_content' => $params,
        ])->andReturn('foo');

        $this->assertSame('foo', $client->freeze($params));
    }

    public function testUnfreeze()
    {
        $method = 'alipay.fund.auth.order.unfreeze';

        $client = $this->mockApiClient(Client::class, [], $this->appClient())->makePartial();
        $params = [
            'auth_no' => '2016101210002001810258115912',
            'out_request_no' => '2016101200104001110081001',
            'amount' => 20.11,
            'remark' => '2014-05期解冻200.00元',
        ];

        $client->expects()->request($method, [
            'biz_content' => $params,
        ])->andReturn('foo');

        $this->assertSame('foo', $client->unfreeze('2016101210002001810258115912', '2016101200104001110081001', 20.11, '2014-05期解冻200.00元'));
    }


    public function testOnlineFreeze()
    {
        $method = 'alipay.fund.auth.order.app.freeze';
        $client = $this->mockApiClient(Client::class, [], $this->appClient())->makePartial();
        $params = [
            'out_order_no' => '2014021601002000640012345678',
            // ...
        ];

        $client->expects()->request($method, [
            'biz_content' => $params,
        ])->andReturn('foo');

        $this->assertSame('foo', $client->onlineFreeze($params));
    }

    public function testGetQrcode()
    {
        $method = 'alipay.fund.auth.order.voucher.create';
        $client = $this->mockApiClient(Client::class, [], $this->appClient())->makePartial();
        $params = [
            'out_order_no' => '2014021601002000640012345678',
            // ...
        ];

        $client->expects()->request($method, [
            'biz_content' => $params,
        ])->andReturn('foo');

        $this->assertSame('foo', $client->getQrcode($params));
    }

    public function testTransfer()
    {
        $method = 'alipay.fund.trans.toaccount.transfer';

        $client = $this->mockApiClient(Client::class, [], $this->appClient())->makePartial();
        $params = [
            'out_biz_no' => '2014021601002000640012345678',
            // ...
        ];

        $client->expects()->request($method, [
            'biz_content' => $params,
        ])->andReturn('foo');

        $this->assertSame('foo', $client->transfer($params));
    }

    public function testGetTransferOrder()
    {
        $method = 'alipay.fund.trans.order.query';

        $client = $this->mockApiClient(Client::class, [], $this->appClient())->makePartial();
        $params = [
            'out_biz_no' => '20160627110070001502260006780837',
        ];

        $client->expects()->request($method, [
            'biz_content' => $params,
        ])->andReturn('foo');

        $this->assertSame('foo', $client->getTransferOrder('20160627110070001502260006780837'));
    }


    public function testUnifiedTransfer()
    {
        $method = 'alipay.fund.trans.uni.transfer';

        $client = $this->mockApiClient(Client::class, [], $this->appClient())->makePartial();
        $params = [
            'out_biz_no' => '20160627110070001502260006780837',
            // ...
        ];

        $client->expects()->request($method, [
            'biz_content' => $params,
        ])->andReturn('foo');

        $this->assertSame('foo', $client->unifiedTransfer($params));
    }

    public function testTransferBack()
    {
        $method = 'alipay.fund.trans.refund';

        $client = $this->mockApiClient(Client::class, [], $this->appClient())->makePartial();
        $params = [
            'order_id' => '20190703110075000006530004756875',
            'out_request_no' => '2018999960760005838333',
            'refund_amount' => 8.88,
            'remark' => '红包超时退回',
        ];

        $client->expects()->request($method, [
            'biz_content' => $params,
        ])->andReturn('foo');

        $this->assertSame('foo', $client->TransferBack('20190703110075000006530004756875', '2018999960760005838333', 8.88, '红包超时退回'));

    }

    public function testCashBonus()
    {
        $method = 'alipay.fund.trans.app.pay';

        $client = $this->mockApiClient(Client::class, [], $this->appClient())->makePartial();
        $params = [
            'out_biz_no' => '20160627110070001502260006780837',
            // ...
        ];

        $client->expects()->request($method, [
            'biz_content' => $params,
        ])->andReturn('foo');

        $this->assertSame('foo', $client->cashBonus($params));
    }

    public function testTransferCommonQuery()
    {
        $method = 'alipay.fund.trans.common.query';

        $client = $this->mockApiClient(Client::class, [], $this->appClient())->makePartial();
        $params = [
            'out_biz_no' => '20160627110070001502260006780837',
            // ...
        ];

        $client->expects()->request($method, [
            'biz_content' => $params,
        ])->andReturn('foo');

        $this->assertSame('foo', $client->transferCommonQuery($params));
    }
}
