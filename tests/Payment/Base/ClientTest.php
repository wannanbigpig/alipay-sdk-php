<?php
/*
 * This file is part of the wannanbigpig/alipay.
 *
 * (c) wannanbigpig <liuml0211@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace WannanBigPig\Alipay\Tests\Payment\Base;

use WannanBigPig\Alipay\Payment\Base\Client;
use WannanBigPig\Alipay\Tests\Payment\ApplicationTest;
use WannanBigPig\Supports\Str;

/**
 * Class ClientTest
 *
 * @author   liuml  <liumenglei0211@163.com>
 * @DateTime 2019-07-21  14:10
 */
class ClientTest extends ApplicationTest
{
    public function testPay(){
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
}