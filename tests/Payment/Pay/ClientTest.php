<?php
/*
 * This file is part of the wannanbigpig/alipay.
 *
 * (c) wannanbigpig <liuml0211@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace WannanBigPig\Alipay\Tests\Payment\Pay;

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
    /**
     * testApp.
     */
    public function testApp()
    {
        $app = $this->appClient();
        $res = $app->pay->app([
            'total_amount' => '100',
            'subject' => '大乐透',
            'out_trade_no' => Str::getRandomInt(),
        ]);

        $this->assertInternalType('string', $res);
    }

    /**
     * testWap.
     */
    public function testWap()
    {
        $app = $this->appClient();
        $res = $app->pay->wap([
            'total_amount' => '100',
            'subject' => '大乐透',
            'out_trade_no' => Str::getRandomInt(),
            'quit_url' => 'http://www.taobao.com/product/113714.html',
        ]);
        $this->assertInternalType('string', $res);
    }

    /**
     * testPc.
     */
    public function testPc()
    {
        $app = $this->appClient();
        $res = $app->pay->pc([
            'total_amount' => '100',
            'subject' => '大乐透',
            'out_trade_no' => Str::getRandomInt(),
        ]);

        $this->assertInternalType('string', $res);
    }
}