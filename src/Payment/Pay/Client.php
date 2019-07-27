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
     * @param array $params
     *
     * @return string
     *
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function app(array $params)
    {
        $method = 'alipay.trade.app.pay';
        $params['timeout_express'] = $params['timeout_express'] ?? '1c';
        $this->app->setEndpointConfig($method, [
            'return_url' => $this->app['config']->get('return_url'),
            'notify_url' => $this->app['config']->get('notify_url'),
        ]);

        return $this->sdkExecute($method, [
            'biz_content' => $params,
        ]);
    }

    /**
     * alipay.trade.wap.pay(手机网站支付接口2.0).
     *
     * @param array  $params
     * @param string $httpMethod
     *
     * @return string
     *
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function wap(array $params, string $httpMethod = 'POST')
    {
        $method = 'alipay.trade.wap.pay';
        $params['timeout_express'] = $params['timeout_express'] ?? '1c';
        $this->app->setEndpointConfig($method, [
            'return_url' => $this->app['config']->get('return_url'),
            'notify_url' => $this->app['config']->get('notify_url'),
        ]);

        return $this->pageExecute($method, [
            'biz_content' => $params,
        ], $httpMethod);
    }

    /**
     * alipay.trade.page.pay(统一收单下单并支付页面接口).
     *
     * @param array  $params
     * @param string $httpMethod
     *
     * @return string
     *
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function pc(array $params, string $httpMethod = 'POST')
    {
        $method = 'alipay.trade.page.pay';
        $params = array_merge([
            'timeout_express' => $params['timeout_express'] ?? '1c',
            'product_code' => 'FAST_INSTANT_TRADE_PAY',
        ], $params);
        $this->app->setEndpointConfig($method, [
            'return_url' => $this->app['config']->get('return_url'),
            'notify_url' => $this->app['config']->get('notify_url'),
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
