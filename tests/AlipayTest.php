<?php
/*
 * This file is part of the wannanbigpig/alipay-sdk-php.
 *
 * (c) wannanbigpig <liuml0211@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyAlipay\Tests;

use EasyAlipay\Alipay;
use EasyAlipay\Kernel\Exceptions\ApplicationException;

class AlipayTest extends TestCase
{
    public function testAlipay()
    {
        $this->expectException(ApplicationException::class);
        $config = [
            'app_id' => '111',
        ];
        Alipay::Foo($config);
    }
}