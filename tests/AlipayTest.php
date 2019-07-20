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
            'app_id' => '2016092600598145',
            'private_key_path' => STORAGE_ROOT.'private_key.pem',
            // 'private_key' => file_get_contents(STORAGE_ROOT.'private_key.txt'), // 直接配置此处则私钥文件路径则不用填写
            'charset' => 'UTF-8',
            'env' => 'dev',
        ];
        $app = Alipay::payment($config);
        $res = $app->pay([
            'out_trade_no' => 'cs123345232345',
            'scene' => 'bar_code',
            'auth_code' => '281119003059111202',
            'subject' => 'ceshiapi',
        ]);
        var_dump($res);
        $this->assertInstanceOf(Application::class, $app);
    }
}
// app_id=2016092600598145&amp;biz_content[auth_code]=281119003059111202&amp;biz_content[out_trade_no]=cs123345232345&amp;biz_content[scene]=bar_code&amp;biz_content[subject]=ceshiapi&amp;charset=UTF-8&amp;format=JSON&amp;method=alipay.trade.pay&amp;sign_type=RSA2&amp;timestamp=2019-07-20 10:35:11&amp;version=1.0