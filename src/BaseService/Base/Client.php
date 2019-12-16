<?php
/*
 * This file is part of the wannanbigpig/alipay-sdk-php.
 *
 * (c) wannanbigpig <liuml0211@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyAlipay\BaseService\Base;

use EasyAlipay\Kernel\Support\Support;

/**
 * Class Client
 *
 * @author   liuml  <liumenglei0211@163.com>
 * @DateTime 2019/12/16  18:17
 */
class Client extends Support
{
    /**
     * alipay.open.auth.token.app.query(查询某个应用授权AppAuthToken的授权信息).
     *
     * @param string $appAuthToken
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|\WannanBigPig\Supports\Collection|\WannanBigPig\Supports\Http\Response
     *
     * @throws \EasyAlipay\Kernel\Exceptions\InvalidSignException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function queryAppAuthToken(string $appAuthToken)
    {
        $method = 'alipay.open.auth.token.app.query';
        $params = [
            'app_auth_token' => $appAuthToken,
        ];

        return $this->request($method, [
            'biz_content' => $params,
        ]);
    }
}
