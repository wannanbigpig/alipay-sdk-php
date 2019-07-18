<?php
/*
 * This file is part of the wannanbigpig/alipay.
 *
 * (c) wannanbigpig <liuml0211@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace WannanBigPig\Alipay\Tests;

use WannanBigPig\Alipay\Alipay;
use WannanBigPig\Alipay\Payment\Application;

class AlipayTest extends TestCase
{
    public function testApp()
    {
        $config = [
            'appid' => '88888888888888888888',
        ];
        $app = Alipay::payment($config);
        var_dump($app->pay());
        $this->assertInstanceOf(Application::class, $app);
    }
}
