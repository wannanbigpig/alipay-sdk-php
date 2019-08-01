<?php
/*
 * This file is part of the wannanbigpig/alipay-sdk-php.
 *
 * (c) wannanbigpig <liuml0211@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyAlipay\Tests\Kernel\Traits;

use EasyAlipay\Kernel\Exceptions\InvalidSignException;
use EasyAlipay\Kernel\ServiceContainer;
use EasyAlipay\Kernel\Support\Support;
use EasyAlipay\Tests\TestCase;
use WannanBigPig\Supports\Exceptions\InvalidArgumentException;

class HelpersTest extends TestCase
{
    /**
     * testGenerateSign.
     */
    public function testhelpers()
    {
        $app = new ServiceContainer([
            'private_key_path' => STORAGE_ROOT.'private_key.pem',
            'alipay_public_Key_path' => STORAGE_ROOT.'public_key.pem',
        ]);
        $client = $this->mockApiClient(Support::class, ['parserSignSource', 'verify', 'checkResponseSign'], $app)->makePartial();
        $data = ['foo' => 'bar'];

        $client->expects()->parserSignSource($data)->andReturn('result');

        $sign =
            "AC5/umSW7Gc3NT9NMMMhaeLoKXEu5sD7C3gpMbQarwtcLhk+0POcmZydvPTcr7TIxQo/NiEwnjcrqMgx1avVDMzNyEbXYUuRAvLUUYPHhZl2Y6lso1lO0giuEIDixhtM5OXEQGr6pLTZqJr40JUS7p6afmf++wRj1cWSswXr2j7plDkxqA7qOBUSwO26T8UBwlasMPuHOtaZ9f7injAk2B+eDnhYlHiyQAtyedOc8Fv9VnaElxbcZJB+P2Kfj38s+z5QVXiVieu67OTeTE7PK3ELfFesCpaJ64WOuJOnTGuZYldQ4goJK1kyo3uxxDtVnlMoZfVrz2rFRJu7iOFzXw==";
        $this->assertSame($sign, $client->generateSign($data));
        $this->assertSame(true, $client->checkResponseSign('foo=bar', $sign));
        $this->assertSame(false, $client->verify('foo=bar', $sign, 'RSA'));
        $this->assertSame('result', $client->parserSignSource($data));
        $this->assertSame('result', $client->parserSignSource(['pay_response' => 'result'], 'pay'));
        $this->assertSame('error', $client->parserSignSource(['error_response' => 'error']));

        $this->expectException(InvalidArgumentException::class);
        $app->config->offsetUnset('alipay_public_Key_path');
        $client = $this->mockApiClient(Support::class, ['parserSignSource', 'verify', 'checkResponseSign'], $app)->makePartial();
        $client->verify('foo=bar', $sign, 'RSA');
    }

    /**
     * testGetSignContentUrlencode.
     */
    public function testGetSignContentUrlencode()
    {
        $app = new ServiceContainer([]);
        $client = $this->mockApiClient(Support::class, [], $app)->makePartial();
        $data = [
            'foo' => 'bar',
            'lan' => '中文',
            'foo_1' => '@bar_1',
        ];
        $this->assertSame('foo=bar&lan=%E4%B8%AD%E6%96%87', $client->getSignContentUrlencode($data));
    }

    /**
     * testGetSignContentUrlencode.
     */
    public function testGetSignContent()
    {
        $app = new ServiceContainer([]);
        $client = $this->mockApiClient(Support::class, [], $app)->makePartial();
        $data = [
            'foo' => 'bar',
            'lan' => '中文',
            'foo_1' => '@bar_1',
        ];
        $this->assertSame('foo=bar&lan=中文', $client->getSignContent($data));
    }

    public function testSign()
    {
        $app = new ServiceContainer([
            'private_key' => file_get_contents(STORAGE_ROOT.'private_key.txt'),
        ]);
        $client = $this->mockApiClient(Support::class, [], $app)->makePartial();
        $data = 'foo=bar';
        $signRsa2 =
            "AC5/umSW7Gc3NT9NMMMhaeLoKXEu5sD7C3gpMbQarwtcLhk+0POcmZydvPTcr7TIxQo/NiEwnjcrqMgx1avVDMzNyEbXYUuRAvLUUYPHhZl2Y6lso1lO0giuEIDixhtM5OXEQGr6pLTZqJr40JUS7p6afmf++wRj1cWSswXr2j7plDkxqA7qOBUSwO26T8UBwlasMPuHOtaZ9f7injAk2B+eDnhYlHiyQAtyedOc8Fv9VnaElxbcZJB+P2Kfj38s+z5QVXiVieu67OTeTE7PK3ELfFesCpaJ64WOuJOnTGuZYldQ4goJK1kyo3uxxDtVnlMoZfVrz2rFRJu7iOFzXw==";
        $signRsa =
            "n5AHzYql6D54m39lNX7YJCg0scf6oPatkCbhtQGY4aauWOpXxk0ko2UTWP6u+pReuQ/S3awXXi8JwlfX6w0jhSFuUEJlZ0zMP6G01ucDctqjdIXUyms9dB5YzlHtG0DdHvC2WwzmC13amLEIXJV/lXPqDCwvKM1xXWYkuLP0HlXNjNgtUsJJ4q4pJWbA24nPIVCwUMdSSRCnff91nxPrH3Aj4XQSON9HU8sWpKxjwJWwZ1Egzcul82zNvU0ddqwY+6jzkWE7O/r/EL1HYKwU+0GL0lYWiQayLCGblttXSSvWA9PAw7lDHrdjkPNaCdbybZj1Ij7o8J1mCc0izICi2Q==";
        $this->assertSame($signRsa2, $client->sign($data));
        $this->assertSame($signRsa, $client->sign($data, 'RSA'));
    }

    public function testInvalidArgumentException()
    {
        $this->expectException(InvalidArgumentException::class);
        $app = new ServiceContainer();
        $client = $this->mockApiClient(Support::class, [], $app)->makePartial();
        $data = 'foo=bar';
        $client->sign($data);
    }

    public function testCheckEmpty()
    {
        $app = new ServiceContainer();
        $client = $this->mockApiClient(Support::class, [], $app)->makePartial();
        $this->assertSame(true, $client->checkEmpty([]));
    }

    public function testInvalidSign()
    {
        $this->expectException(\EasyAlipay\Kernel\Exceptions\InvalidSignException::class);
        $app = new ServiceContainer([
            'alipay_public_Key' => file_get_contents(STORAGE_ROOT.'alipay_public_Key.txt'),
        ]);
        $client = $this->mockApiClient(Support::class, [], $app)->makePartial();
        try {
            $client->checkResponseSign('xxxx', 'dss');
        } catch (InvalidSignException $e) {
            $client->checkResponseSign('xxxx');
        }
    }

}
