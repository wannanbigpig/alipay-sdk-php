<?php
/*
 * This file is part of the wannanbigpig/alipay-sdk-php.
 *
 * (c) wannanbigpig <liuml0211@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyAlipay\MiniProgram\Version;

use EasyAlipay\Tests\MiniProgram\ApplicationTest;

class ClientTest extends ApplicationTest
{
    public function testGrayCancel()
    {
        $method = 'alipay.open.mini.version.gray.cancel';
        $params = [
            'app_version' => '1.0.1',
        ];

        $client = $this->mockApiClient(Client::class, [], $this->appClient())->makePartial();

        $client->expects()->request($method, [
            'biz_content' => $params,
        ])->andReturn('foo');
        $this->assertSame('foo', $client->grayCancel('1.0.1'));
    }

    public function testDelete()
    {
        $method = 'alipay.open.mini.version.delete';
        $params = [
            'app_version' => '1.0.1',
        ];

        $client = $this->mockApiClient(Client::class, [], $this->appClient())->makePartial();

        $client->expects()->request($method, [
            'biz_content' => $params,
        ])->andReturn('foo');
        $this->assertSame('foo', $client->delete('1.0.1'));
    }

    public function testUpload()
    {
        $method = 'alipay.open.mini.version.upload';
        $params = [
            'template_version' => '0.0.1',
            'template_id' => '14234',
            'app_version' => '0.0.1',
        ];

        $client = $this->mockApiClient(Client::class, [], $this->appClient())->makePartial();

        $client->expects()->request($method, [
            'biz_content' => $params,
        ])->andReturn('foo');
        $this->assertSame('foo', $client->upload('14234', '0.0.1', '0.0.1'));
    }


    public function testGrayOnline()
    {
        $method = 'alipay.open.mini.version.delete';
        $params = [
            'app_version' => '0.0.1',
            'gray_strategy' => 'p10',
        ];

        $client = $this->mockApiClient(Client::class, [], $this->appClient())->makePartial();

        $client->expects()->request($method, [
            'biz_content' => $params,
        ])->andReturn('foo');
        $this->assertSame('foo', $client->grayOnline('0.0.1', 'p10'));
    }

    public function testBuildQuery()
    {
        $method = 'alipay.open.mini.version.build.query';
        $params = [
            'app_version' => '0.0.1',
        ];

        $client = $this->mockApiClient(Client::class, [], $this->appClient())->makePartial();

        $client->expects()->request($method, [
            'biz_content' => $params,
        ])->andReturn('foo');
        $this->assertSame('foo', $client->buildQuery('0.0.1'));
    }

    public function testCancelAudited()
    {
        $method = 'alipay.open.mini.version.audited.cancel';
        $params = [
            'app_version' => '0.0.1',
        ];

        $client = $this->mockApiClient(Client::class, [], $this->appClient())->makePartial();

        $client->expects()->request($method, [
            'biz_content' => $params,
        ])->andReturn('foo');
        $this->assertSame('foo', $client->cancelAudited('0.0.1'));
    }

    public function testOffline()
    {
        $method = 'alipay.open.mini.version.offline';
        $params = [
            'app_version' => '0.0.1',
        ];

        $client = $this->mockApiClient(Client::class, [], $this->appClient())->makePartial();

        $client->expects()->request($method, [
            'biz_content' => $params,
        ])->andReturn('foo');
        $this->assertSame('foo', $client->offline('0.0.1'));
    }

    public function testGetList()
    {
        $method = 'alipay.open.mini.version.list.query';
        $params = [];

        $client = $this->mockApiClient(Client::class, [], $this->appClient())->makePartial();

        $client->expects()->request($method, [
            'biz_content' => $params,
        ])->andReturn('foo');
        $this->assertSame('foo', $client->getList());
    }

    public function testCreateExperience()
    {
        $method = 'alipay.open.mini.experience.create';
        $params = [
            'app_version' => '0.0.1',
        ];

        $client = $this->mockApiClient(Client::class, [], $this->appClient())->makePartial();

        $client->expects()->request($method, [
            'biz_content' => $params,
        ])->andReturn('foo');
        $this->assertSame('foo', $client->createExperience('0.0.1'));
    }

    public function testCancelExperience()
    {
        $method = 'alipay.open.mini.experience.cancel';
        $params = [
            'app_version' => '0.0.1',
        ];

        $client = $this->mockApiClient(Client::class, [], $this->appClient())->makePartial();

        $client->expects()->request($method, [
            'biz_content' => $params,
        ])->andReturn('foo');
        $this->assertSame('foo', $client->cancelExperience('0.0.1'));
    }

    public function testQueryExperience()
    {
        $method = 'alipay.open.mini.experience.query';
        $params = [
            'app_version' => '0.0.1',
        ];

        $client = $this->mockApiClient(Client::class, [], $this->appClient())->makePartial();

        $client->expects()->request($method, [
            'biz_content' => $params,
        ])->andReturn('foo');
        $this->assertSame('foo', $client->queryExperience('0.0.1'));
    }

    public function testOnline()
    {
        $method = 'alipay.open.mini.version.online';
        $params = [
            'app_version' => '0.0.1',
        ];

        $client = $this->mockApiClient(Client::class, [], $this->appClient())->makePartial();

        $client->expects()->request($method, [
            'biz_content' => $params,
        ])->andReturn('foo');
        $this->assertSame('foo', $client->online('0.0.1'));
    }

    public function testGetDetail()
    {
        $method = 'alipay.open.mini.version.detail.query';
        $params = [
            'app_version' => '0.0.1',
        ];

        $client = $this->mockApiClient(Client::class, [], $this->appClient())->makePartial();

        $client->expects()->request($method, [
            'biz_content' => $params,
        ])->andReturn('foo');
        $this->assertSame('foo', $client->getDetail('0.0.1'));
    }

    public function testRollback()
    {
        $method = 'alipay.open.mini.version.rollback';
        $params = [
            'app_version' => '0.0.1',
        ];

        $client = $this->mockApiClient(Client::class, [], $this->appClient())->makePartial();

        $client->expects()->request($method, [
            'biz_content' => $params,
        ])->andReturn('foo');
        $this->assertSame('foo', $client->rollback('0.0.1'));
    }

    public function testSubmitAudit()
    {
        $method = 'alipay.open.mini.version.audit.apply';
        $params = [
            'app_version' => '0.0.1',
            // ...
        ];

        $client = $this->mockApiClient(Client::class, [], $this->appClient())->makePartial();

        $client->expects()->request($method, [
            'biz_content' => $params,
        ])->andReturn('foo');
        $this->assertSame('foo', $client->submitAudit($params));
    }
}
