<?php
/*
 * This file is part of the wannanbigpig/alipay-sdk-php.
 *
 * (c) wannanbigpig <liuml0211@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyAlipay\Tests\Payment\kernel;

use EasyAlipay\Kernel\ServiceContainer;
use EasyAlipay\Payment\Kernel\BaseClient;
use EasyAlipay\Tests\TestCase;

class BaseClientTest extends TestCase
{
    public function testSdkExecute()
    {
        $app = new ServiceContainer([
            'private_key_path' => STORAGE_ROOT.'private_key.pem',
            'alipay_public_Key_path' => STORAGE_ROOT.'alipay_public_key.pem',
        ]);
        $baseClient = new BaseClient($app);
        $data = ['foo' => 'bar'];
        $this->assertInternalType('string', $baseClient->sdkExecute('pay', $data));
    }

    public function testPageExecute()
    {
        $app = new ServiceContainer([
            'private_key_path' => STORAGE_ROOT.'private_key.pem',
            'alipay_public_Key_path' => STORAGE_ROOT.'alipay_public_key.pem',
        ]);
        $baseClient = new BaseClient($app);
        $data = ['foo' => 'bar'];
        $this->assertInternalType('string', $baseClient->pageExecute('pay', $data));
        $this->assertInternalType('string', $baseClient->pageExecute('pay', $data, 'GET'));
    }
}