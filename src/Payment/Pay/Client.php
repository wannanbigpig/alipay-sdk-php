<?php
/*
 * This file is part of the wannanbigpig/alipay-sdk-php.
 *
 * (c) wannanbigpig <liuml0211@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyAlipay\Payment\Pay;

use EasyAlipay\Payment\Kernel\BaseClient;

/**
 * Class Client
 *
 * @author   liuml  <liumenglei0211@163.com>
 * @DateTime 2019-07-22  14:36
 */
class Client extends BaseClient
{
    /**
     * alipay.trade.app.pay(app支付接口2.0).
     *
     * @param array       $params
     * @param string|null $returnUrl
     *
     * @return string
     *
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function app(array $params, string $returnUrl = null)
    {
        $method = 'alipay.trade.app.pay';
        $params = array_merge([
            'timeout_express' => '1c',
            'product_code' => 'QUICK_MSECURITY_PAY',
        ], $params);

        $this->app->setEndpointConfig($method, [
            'return_url' => $returnUrl ?: $this->app['config']->get('sys_params.return_url'),
            'notify_url' => $this->app['config']->get('sys_params.notify_url'),
        ]);

        return $this->sdkExecute($method, [
            'biz_content' => $params,
        ]);
    }

    /**
     * alipay.trade.wap.pay(手机网站支付接口2.0).
     *
     * @param array       $params
     * @param string      $httpMethod
     * @param string|null $returnUrl
     *
     * @return string
     *
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function wap(array $params, string $httpMethod = 'POST', string $returnUrl = null)
    {
        $method = 'alipay.trade.wap.pay';
        $params = array_merge([
            'timeout_express' => '1c',
            'product_code' => 'QUICK_WAP_WAY',
        ], $params);

        $this->app->setEndpointConfig($method, [
            'return_url' => $returnUrl ?: $this->app['config']->get('sys_params.return_url'),
            'notify_url' => $this->app['config']->get('sys_params.notify_url'),
        ]);

        return $this->pageExecute($method, [
            'biz_content' => $params,
        ], $httpMethod);
    }

    /**
     * alipay.trade.page.pay(统一收单下单并支付页面接口).
     *
     * @param array       $params
     * @param string      $httpMethod
     * @param string|null $returnUrl
     *
     * @return string
     *
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function pc(array $params, string $httpMethod = 'POST', string $returnUrl = null)
    {
        $method = 'alipay.trade.page.pay';
        $params = array_merge([
            'timeout_express' => '1c',
            'product_code' => 'FAST_INSTANT_TRADE_PAY',
        ], $params);
        $this->app->setEndpointConfig($method, [
            'return_url' => $returnUrl ?: $this->app['config']->get('sys_params.return_url'),
            'notify_url' => $this->app['config']->get('sys_params.notify_url'),
        ]);

        return $this->pageExecute($method, [
            'biz_content' => $params,
        ], $httpMethod);
    }

    /**
     * zoloz.authentication.customer.smilepay.initialize(人脸初始化唤起zim).
     *
     * @param string $zimmetainfo
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|\WannanBigPig\Supports\Collection|\WannanBigPig\Supports\Http\Response
     *
     * @throws \EasyAlipay\Kernel\Exceptions\InvalidSignException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function face(string $zimmetainfo)
    {
        $method = 'zoloz.authentication.customer.smilepay.initialize';
        $params = [
            'zimmetainfo' => $zimmetainfo,
        ];

        return $this->request($method, [
            'biz_content' => $params,
        ]);
    }
}
