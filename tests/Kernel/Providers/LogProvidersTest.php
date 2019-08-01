<?php
/*
 * This file is part of the wannanbigpig/alipay-sdk-php.
 *
 * (c) wannanbigpig <liuml0211@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyAlipay\Tests\Kernel\Providers;

use EasyAlipay\Kernel\Providers\LogServiceProvider;
use EasyAlipay\Kernel\ServiceContainer;
use EasyAlipay\Tests\TestCase;

class LogProvidersTest extends TestCase
{
    public function testLogConfig()
    {
        $app = new ServiceContainer([
            'log' => [
                'level' => 'debug',
            ],
        ]);
        $log = new LogServiceProvider();
        $this->assertInternalType('array', $log->logConfig($app));
    }
}