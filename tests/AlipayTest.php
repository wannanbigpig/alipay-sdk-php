<?php

namespace WannanBigPig\Alipay\Tests;

use PHPUnit\Framework\TestCase;
use WannanBigPig\Alipay\Alipay;

class AlipayTest extends TestCase
{
    public function testAppclication()
    {
        $alipay = Alipay::payment([]);
        var_dump($alipay);
        $this->assertNotEmpty($alipay);
    }
}
