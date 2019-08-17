<?php
/*
 * This file is part of the wannanbigpig/alipay-sdk-php.
 *
 * (c) wannanbigpig <liuml0211@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyAlipay\Tests\Kernel\Notify;

use EasyAlipay\Kernel\Notify\Handle;
use EasyAlipay\Payment\Application;
use EasyAlipay\Tests\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HandleTest extends TestCase
{
    private function makeApp($config = [])
    {
        return new Application(array_merge([
            'sys_params' => [
                'app_id' => '88888888888888888888888888888888',
            ],
        ], $config));
    }

    public function testPaidNotify()
    {
        $app = $this->makeApp([
            'alipay_public_Key_path' => STORAGE_ROOT.'public_key.pem',
        ]);
        $app['request'] = Request::create('https://alipay.docs.wannanbigpig.com/', 'POST', [
            'foo' => 'bar',
            'sign' => 'AC5/umSW7Gc3NT9NMMMhaeLoKXEu5sD7C3gpMbQarwtcLhk+0POcmZydvPTcr7TIxQo/NiEwnjcrqMgx1avVDMzNyEbXYUuRAvLUUYPHhZl2Y6lso1lO0giuEIDixhtM5OXEQGr6pLTZqJr40JUS7p6afmf++wRj1cWSswXr2j7plDkxqA7qOBUSwO26T8UBwlasMPuHOtaZ9f7injAk2B+eDnhYlHiyQAtyedOc8Fv9VnaElxbcZJB+P2Kfj38s+z5QVXiVieu67OTeTE7PK3ELfFesCpaJ64WOuJOnTGuZYldQ4goJK1kyo3uxxDtVnlMoZfVrz2rFRJu7iOFzXw==',
            'sign_type' => 'RSA2',
        ]);
        $handle = new Handle($app);
        $response = $handle->run(function ($request, $response) {
            if ($request->foo === 'bar') {
                return $response();
            }

            return $response(false);
        });
        $this->assertInstanceOf(Response::class, $response);
        $this->assertSame('success', $response->getContent());
    }

    public function testFail()
    {
        $app = $this->makeApp([
            'alipay_public_Key_path' => STORAGE_ROOT.'public_key.pem',
        ]);
        $app['request'] = Request::create('https://alipay.docs.wannanbigpig.com/', 'POST', [
            'foo' => 'bar',
            'sign' => 'A...',
            'sign_type' => 'RSA2',
        ]);
        $notify = new Handle($app);

        // Exceptions are logged here, but they are not thrown. And instead of going into anonymous functions, you go straight back to fail.
        $response = $notify->run(function () {

        });

        $this->assertSame('fail', $response->getContent());
    }
}