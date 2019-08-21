<?php
/*
 * This file is part of the wannanbigpig/alipay-sdk-php.
 *
 * (c) wannanbigpig <liuml0211@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyAlipay\Tests\Tripartite\ServiceMarket;

use EasyAlipay\Tests\Tripartite\ApplicationTest;
use EasyAlipay\Tripartite\ServiceMarket\Client;

class ClientTest extends ApplicationTest
{
    public function testOrderQuery()
    {
        $method = 'alipay.open.servicemarket.order.query';

        $client = $this->mockApiClient(Client::class, [], $this->appClient())->makePartial();
        $params = [
            'commodity_order_id' => '20160010200000000033400',
            'start_page' => 1,
        ];

        $client->expects()->request($method, [
            'biz_content' => $params,
        ])->andReturn('foo');
        $this->assertSame('foo', $client->orderQuery('20160010200000000033400'));
    }

    public function testOrderAccept()
    {
        $method = 'alipay.open.servicemarket.order.accept';
        $client = $this->mockApiClient(Client::class, [], $this->appClient())->makePartial();
        $params = [
            'commodity_order_id' => '20160010200000000033400',
        ];

        $client->expects()->request($method, [
            'biz_content' => $params,
        ])->andReturn('foo');
        $this->assertSame('foo', $client->orderAccept('20160010200000000033400'));
    }

    public function testOrderItemComplete()
    {
        $method = 'alipay.open.servicemarket.order.item.complete';

        $client = $this->mockApiClient(Client::class, [], $this->appClient())->makePartial();
        $params = [
            'commodity_order_id' => '20160010200000000033400',
            'shop_id' => '2015052000077000000000182140',
        ];

        $client->expects()->request($method, [
            'biz_content' => $params,
        ])->andReturn('foo');
        $this->assertSame('foo', $client->orderItemComplete('20160010200000000033400', '2015052000077000000000182140'));
    }

    public function testOrderItemConfirm()
    {
        $method = 'alipay.open.servicemarket.order.item.confirm';
        $client = $this->mockApiClient(Client::class, [], $this->appClient())->makePartial();
        $params = [
            'commodity_order_id' => '20160010200000000033400',
            'shop_id' => '2015052000077000000000182140',
        ];

        $client->expects()->request($method, [
            'biz_content' => $params,
        ])->andReturn('foo');
        $this->assertSame('foo', $client->orderItemConfirm('20160010200000000033400', '2015052000077000000000182140'));
    }

    public function testCommodityShopOffline()
    {
        $method = 'alipay.open.servicemarket.commodity.shop.offline';
        $client = $this->mockApiClient(Client::class, [], $this->appClient())->makePartial();
        $params = [
            'commodity_id' => '20160010200000000033400',
            'shop_id' => '2015052000077000000000182140',
        ];

        $client->expects()->request($method, [
            'biz_content' => $params,
        ])->andReturn('foo');
        $this->assertSame('foo', $client->commodityShopOffline('20160010200000000033400', '2015052000077000000000182140'));
    }

    public function testCommodityShopOnline()
    {
        $method = 'alipay.open.servicemarket.commodity.shop.online';

        $client = $this->mockApiClient(Client::class, [], $this->appClient())->makePartial();
        $params = [
            'commodity_id' => '20160010200000000033400',
            'shop_id' => '2015052000077000000000182140',
        ];

        $client->expects()->request($method, [
            'biz_content' => $params,
        ])->andReturn('foo');
        $this->assertSame('foo', $client->commodityShopOnline('20160010200000000033400', '2015052000077000000000182140'));
    }

    public function testOrderReject()
    {
        $method = 'alipay.open.servicemarket.order.reject';

        $client = $this->mockApiClient(Client::class, [], $this->appClient())->makePartial();
        $params = [
            'commodity_order_id' => '20160010200000000033400',
            'reject_reason' => '暂不支持该地区服务',
        ];

        $client->expects()->request($method, [
            'biz_content' => $params,
        ])->andReturn('foo');
        $this->assertSame('foo', $client->orderReject('20160010200000000033400', '暂不支持该地区服务'));
    }


    public function testOrderItemCancel()
    {
        $method = 'alipay.open.servicemarket.order.item.cancel';

        $client = $this->mockApiClient(Client::class, [], $this->appClient())->makePartial();
        $params = [
            'commodity_order_id' => '20160010200000000033400',
            'shop_id' => '2015052000077000000000182140',
            'cancel_reason' => '该门店暂无法实施完成',
        ];

        $client->expects()->request($method, [
            'biz_content' => $params,
        ])->andReturn('foo');
        $this->assertSame('foo', $client->orderItemCancel('20160010200000000033400', '2015052000077000000000182140', '该门店暂无法实施完成'));
    }
}
