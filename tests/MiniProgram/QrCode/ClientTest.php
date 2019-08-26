<?php
/*
 * This file is part of the wannanbigpig/alipay-sdk-php.
 *
 * (c) wannanbigpig <liuml0211@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyAlipay\Tests\MiniProgram\QrCode;

use EasyAlipay\MiniProgram\QrCode\Client;
use EasyAlipay\Tests\MiniProgram\ApplicationTest;

class ClientTest extends ApplicationTest
{
    public function testCreate()
    {
        $method = 'alipay.open.app.qrcode.create';
        $params = [
            'url_param' => 'page/component/component-pages/view/view',
            'query_param' => 'a=1',
            'describe' => '二维码描述',
        ];

        $client = $this->mockApiClient(Client::class, [], $this->appClient())->makePartial();

        $client->expects()->request($method, [
            'biz_content' => $params,
        ])->andReturn('foo');
        $this->assertSame('foo', $client->create('page/component/component-pages/view/view','a=1','二维码描述'));
    }
}
