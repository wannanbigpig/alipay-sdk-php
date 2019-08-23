<?php
/*
 * This file is part of the wannanbigpig/alipay-sdk-php.
 *
 * (c) wannanbigpig <liuml0211@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyAlipay\MiniProgram\Members;

use EasyAlipay\Kernel\Support\Support;

class Client extends Support
{
    /**
     * alipay.open.app.members.create(应用添加成员).
     *
     * @param string $logonId
     * @param string $role
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|\WannanBigPig\Supports\Collection|\WannanBigPig\Supports\Http\Response
     *
     * @throws \EasyAlipay\Kernel\Exceptions\InvalidSignException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function create(string $logonId, string $role = 'EXPERIENCER')
    {
        $method = 'alipay.open.app.members.create';
        $params = [
            'logon_id' => $logonId,
            'role' => $role,
        ];

        return $this->request($method, [
            'biz_content' => $params,
        ]);
    }


    /**
     * alipay.open.app.members.query(应用查询成员列表).
     *
     * @param string $role
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|\WannanBigPig\Supports\Collection|\WannanBigPig\Supports\Http\Response
     *
     * @throws \EasyAlipay\Kernel\Exceptions\InvalidSignException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function query(string $role = 'EXPERIENCER')
    {
        $method = 'alipay.open.app.members.query';
        $params = [
            'role' => $role,
        ];

        return $this->request($method, [
            'biz_content' => $params,
        ]);
    }

    /**
     * alipay.open.app.members.delete(应用删除成员).
     *
     * @param string $userId
     * @param string $role
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|\WannanBigPig\Supports\Collection|\WannanBigPig\Supports\Http\Response
     *
     * @throws \EasyAlipay\Kernel\Exceptions\InvalidSignException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function delete(string $userId, string $role = 'EXPERIENCER')
    {
        $method = 'alipay.open.app.members.delete';
        $params = [
            'user_id' => $userId,
            'role' => $role,
        ];

        return $this->request($method, [
            'biz_content' => $params,
        ]);
    }
}
