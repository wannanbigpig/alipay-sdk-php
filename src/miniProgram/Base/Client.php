<?php
/*
 * This file is part of the wannanbigpig/alipay-sdk-php.
 *
 * (c) wannanbigpig <liuml0211@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyAlipay\MiniProgram\Base;

use EasyAlipay\Kernel\Support\Support;

class Client extends Support
{
    /**
     * alipay.open.mini.baseinfo.query(查询小程序基础信息).
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|\WannanBigPig\Supports\Collection|\WannanBigPig\Supports\Http\Response
     *
     * @throws \EasyAlipay\Kernel\Exceptions\InvalidSignException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function getBaseInfo()
    {
        $method = 'alipay.open.mini.baseinfo.query';
        $params = [];

        return $this->request($method, [
            'biz_content' => $params,
        ]);
    }

    /**
     * alipay.open.mini.baseinfo.modify(小程序修改基础信息).
     *
     * @param array $params
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|\WannanBigPig\Supports\Collection|\WannanBigPig\Supports\Http\Response
     *
     * @throws \EasyAlipay\Kernel\Exceptions\InvalidSignException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function updateBaseInfo(array $params)
    {
        $method = 'alipay.open.mini.baseinfo.modify';

        return $this->request($method, $params);
    }

    /**
     * alipay.open.mini.template.usage.query(查询使用模板的小程序列表).
     *
     * @param array $params
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|\WannanBigPig\Supports\Collection|\WannanBigPig\Supports\Http\Response
     *
     * @throws \EasyAlipay\Kernel\Exceptions\InvalidSignException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function getUsageTemplateList(array $params)
    {
        $method = 'alipay.open.mini.template.usage.query';

        return $this->request($method, $params);
    }

    /**
     * alipay.open.mini.safedomain.create(小程序添加域白名单).
     *
     * @param string $safeDomain
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|\WannanBigPig\Supports\Collection|\WannanBigPig\Supports\Http\Response
     *
     * @throws \EasyAlipay\Kernel\Exceptions\InvalidSignException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function createSafeDomain(string $safeDomain)
    {
        $method = 'alipay.open.mini.safedomain.create';
        $params = [
            'safe_domain' => $safeDomain,
        ];

        return $this->request($method, [
            'biz_content' => $params,
        ]);
    }

    /**
     * alipay.open.mini.safedomain.delete(小程序删除域白名单).
     *
     * @param string $safeDomain
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|\WannanBigPig\Supports\Collection|\WannanBigPig\Supports\Http\Response
     *
     * @throws \EasyAlipay\Kernel\Exceptions\InvalidSignException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function deleteSafeDomain(string $safeDomain)
    {
        $method = 'alipay.open.mini.safedomain.delete';
        $params = [
            'safe_domain' => $safeDomain,
        ];

        return $this->request($method, [
            'biz_content' => $params,
        ]);
    }

    /**
     * alipay.security.risk.content.detect(小程序内容风险检测服务).
     *
     * @param string $content
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|\WannanBigPig\Supports\Collection|\WannanBigPig\Supports\Http\Response
     *
     * @throws \EasyAlipay\Kernel\Exceptions\InvalidSignException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function contentRiskDetect(string $content)
    {
        $method = 'alipay.open.mini.safedomain.delete';
        $params = [
            'content' => $content,
        ];

        return $this->request($method, [
            'biz_content' => $params,
        ]);
    }

    /**
     * alipay.open.mini.category.query(小程序类目树查询).
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|\WannanBigPig\Supports\Collection|\WannanBigPig\Supports\Http\Response
     *
     * @throws \EasyAlipay\Kernel\Exceptions\InvalidSignException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function getCategoryList()
    {
        $method = 'alipay.open.mini.category.query';
        $params = [];

        return $this->request($method, [
            'biz_content' => $params,
        ]);
    }

    /**
     * zoloz.identification.customer.certifyzhub.query(刷脸查询认证结果接口).
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|\WannanBigPig\Supports\Collection|\WannanBigPig\Supports\Http\Response
     *
     * @throws \EasyAlipay\Kernel\Exceptions\InvalidSignException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function faceAuthenticationResultsQuery()
    {
        $method = 'zoloz.identification.customer.certifyzhub.query';
        $params = [];

        return $this->request($method, [
            'biz_content' => $params,
        ]);
    }
}
