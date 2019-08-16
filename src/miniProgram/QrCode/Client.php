<?php
/*
 * This file is part of the wannanbigpig/alipay-sdk-php.
 *
 * (c) wannanbigpig <liuml0211@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyAlipay\MiniProgram\QrCode;

use EasyAlipay\Kernel\Support\Support;

class Client extends Support
{
    /**
     * alipay.open.app.qrcode.create(小程序生成推广二维码接口).
     *
     * @param string $urlParam
     * @param string $queryParam
     * @param string $describe
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|\WannanBigPig\Supports\Collection|\WannanBigPig\Supports\Http\Response
     *
     * @throws \EasyAlipay\Kernel\Exceptions\InvalidSignException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function create(string $urlParam, string $queryParam, string $describe)
    {
        $method = 'alipay.open.app.qrcode.create';
        $params = [
            'url_param' => $urlParam,
            'query_param' => $queryParam,
            'describe' => $describe,
        ];

        return $this->request($method, [
            'biz_content' => $params,
        ]);
    }
}
