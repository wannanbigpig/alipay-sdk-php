<?php
/*
 * This file is part of the wannanbigpig/alipay-sdk-php.
 *
 * (c) wannanbigpig <liuml0211@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyAlipay\BaseService\User;

use EasyAlipay\Kernel\Support\Support;

class Client extends Support
{
    /**
     * alipay.user.certify.open.initialize(身份认证初始化服务).
     *
     * @param array $params
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|\WannanBigPig\Supports\Collection|\WannanBigPig\Supports\Http\Response
     *
     * @throws \EasyAlipay\Kernel\Exceptions\InvalidSignException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function certifyInitialize(array $params)
    {
        $method = 'alipay.user.certify.open.initialize';

        return $this->request($method, [
            'biz_content' => $params,
        ]);
    }

    /**
     * alipay.user.certify.open.certify(身份认证开始认证).
     *
     * @param array $params
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|\WannanBigPig\Supports\Collection|\WannanBigPig\Supports\Http\Response
     *
     * @throws \EasyAlipay\Kernel\Exceptions\InvalidSignException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function certifyStart(array $params)
    {
        $method = 'alipay.user.certify.open.certify';

        return $this->request($method, [
            'biz_content' => $params,
        ]);
    }

    /**
     * alipay.user.certify.open.query(身份认证记录查询).
     *
     * @param string $certifyId
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|\WannanBigPig\Supports\Collection|\WannanBigPig\Supports\Http\Response
     *
     * @throws \EasyAlipay\Kernel\Exceptions\InvalidSignException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function getCertifyStatus(string $certifyId)
    {
        $method = 'alipay.user.certify.open.query';

        return $this->request($method, [
            'biz_content' => [
                'certify_id' => $certifyId,
            ],
        ]);
    }
}
