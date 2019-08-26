<?php
/*
 * This file is part of the wannanbigpig/alipay-sdk-php.
 *
 * (c) wannanbigpig <liuml0211@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyAlipay\Tests\MiniProgram\Base;

use EasyAlipay\Tests\MiniProgram\ApplicationTest;
use EasyAlipay\MiniProgram\Base\Client;

class ClientTest extends ApplicationTest
{
    public function testGetBaseInfo()
    {
        $method = 'alipay.open.mini.baseinfo.query';
        $params = [];

        $client = $this->mockApiClient(Client::class, [], $this->appClient())->makePartial();

        $client->expects()->request($method, [
            'biz_content' => $params,
        ])->andReturn('foo');
        $this->assertSame('foo', $client->getBaseInfo());
    }

    public function testUpdateBaseInfo()
    {
        $method = 'alipay.open.mini.baseinfo.modify';
        $params = [
            'app_name' => '小程序名称',
            // ...
        ];

        $client = $this->mockApiClient(Client::class, [], $this->appClient())->makePartial();

        $client->expects()->request($method, $params)->andReturn('foo');
        $this->assertSame('foo', $client->updateBaseInfo($params));
    }

    public function testGetUsageTemplateList()
    {
        $method = 'alipay.open.mini.template.usage.query';
        $params = [
            'template_id' => '模板ID',
            'page_num' => 1,
            'page_size' => 10,
            'template_version' => '0.0.1',
        ];

        $client = $this->mockApiClient(Client::class, [], $this->appClient())->makePartial();

        $client->expects()->request($method, [
            'biz_content' => $params,
        ])->andReturn('foo');
        $this->assertSame('foo', $client->getUsageTemplateList('模板ID', 1, 10, '0.0.1'));
    }

    public function testCreateSafeDomain()
    {
        $method = 'alipay.open.mini.safedomain.create';
        $params = [
            'safe_domain' => 'www.wannanbigpig.com',
        ];

        $client = $this->mockApiClient(Client::class, [], $this->appClient())->makePartial();

        $client->expects()->request($method, [
            'biz_content' => $params,
        ])->andReturn('foo');
        $this->assertSame('foo', $client->createSafeDomain('www.wannanbigpig.com'));
    }

    public function testDeleteSafeDomain()
    {
        $method = 'alipay.open.mini.safedomain.delete';
        $params = [
            'safe_domain' => 'www.wannanbigpig.com',
        ];

        $client = $this->mockApiClient(Client::class, [], $this->appClient())->makePartial();

        $client->expects()->request($method, [
            'biz_content' => $params,
        ])->andReturn('foo');
        $this->assertSame('foo', $client->deleteSafeDomain('www.wannanbigpig.com'));
    }

    public function testContentRiskDetect()
    {
        $method = 'alipay.security.risk.content.detect';
        $params = [
            'content' => '代办毕业证，我们最专业',
        ];

        $client = $this->mockApiClient(Client::class, [], $this->appClient())->makePartial();

        $client->expects()->request($method, [
            'biz_content' => $params,
        ])->andReturn('foo');
        $this->assertSame('foo', $client->contentRiskDetect('代办毕业证，我们最专业'));
    }

    public function testGetCategoryList()
    {
        $method = 'alipay.open.mini.category.query';
        $params = [];

        $client = $this->mockApiClient(Client::class, [], $this->appClient())->makePartial();

        $client->expects()->request($method, [
            'biz_content' => $params,
        ])->andReturn('foo');
        $this->assertSame('foo', $client->getCategoryList());
    }

    public function testFaceAuthenticationResultsQuery()
    {
        $method = 'zoloz.identification.customer.certifyzhub.query';
        $params = [
            'biz_id' => '1234556',
            'zim_id' => '1234556sad',
            'face_type' => 2,
            'bizType' => 2,
        ];

        $client = $this->mockApiClient(Client::class, [], $this->appClient())->makePartial();

        $client->expects()->request($method, [
            'biz_content' => $params,
        ])->andReturn('foo');
        $this->assertSame('foo', $client->faceAuthenticationResultsQuery('1234556', '1234556sad', 2));
    }
}
