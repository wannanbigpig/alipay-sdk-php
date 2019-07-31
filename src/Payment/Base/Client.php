<?php
/*
 * This file is part of the wannanbigpig/alipay-sdk-php.
 *
 * (c) wannanbigpig <liuml0211@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyAlipay\Payment\Base;

use EasyAlipay\Payment\Kernel\BaseClient;

/**
 * Class Client
 *
 * @author   liuml  <liumenglei0211@163.com>
 * @DateTime 2019-07-24  14:24
 */
class Client extends BaseClient
{
    /**
     * alipay.trade.pay(统一收单交易支付接口).
     *
     * @param array $params
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|\WannanBigPig\Supports\Collection|\WannanBigPig\Supports\Http\Response
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \EasyAlipay\Kernel\Exceptions\InvalidSignException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function pay(array $params)
    {
        $method = 'alipay.trade.pay';
        $params = array_merge([
            'scene' => 'bar_code',
            'product_code' => 'FACE_TO_FACE_PAYMENT',
        ], $params);
        $this->app->setEndpointConfig($method, [
            'notify_url' => $this->app['config']->get('notify_url'),
        ]);

        return $this->request($method, [
            'biz_content' => $params,
        ]);
    }

    /**
     * alipay.trade.create(统一收单交易创建接口).
     *
     * @param array $params
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|\WannanBigPig\Supports\Collection|\WannanBigPig\Supports\Http\Response
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \EasyAlipay\Kernel\Exceptions\InvalidSignException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function create(array $params)
    {
        $method = 'alipay.trade.create';
        $this->app->setEndpointConfig($method, [
            'notify_url' => $this->app['config']->get('notify_url'),
        ]);

        return $this->request($method, [
            'biz_content' => $params,
        ]);
    }

    /**
     * alipay.trade.precreate(统一收单线下交易预创建).
     *
     * @param array $params
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|\WannanBigPig\Supports\Collection|\WannanBigPig\Supports\Http\Response
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \EasyAlipay\Kernel\Exceptions\InvalidSignException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function preCreate(array $params)
    {
        $method = 'alipay.trade.precreate';
        $this->app->setEndpointConfig($method, [
            'notify_url' => $this->app['config']->get('notify_url'),
        ]);

        return $this->request($method, [
            'biz_content' => $params,
        ]);
    }


    /**
     * alipay.trade.close(统一收单交易关闭接口).
     *
     * @param string      $tradeNo
     * @param string|null $outTradeNo
     * @param string|null $operatorId
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|\WannanBigPig\Supports\Collection|\WannanBigPig\Supports\Http\Response
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \EasyAlipay\Kernel\Exceptions\InvalidSignException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function close(string $tradeNo, string $outTradeNo = null, string $operatorId = null)
    {
        $method = 'alipay.trade.close';
        $params = array_filter([
            'trade_no' => $tradeNo,
            'out_trade_no' => $outTradeNo,
            'operator_id' => $operatorId,
        ], function ($value) {
            return !($this->checkEmpty($value));
        });
        $this->app->setEndpointConfig($method, [
            'notify_url' => $this->app['config']->get('notify_url'),
        ]);

        return $this->request($method, [
            'biz_content' => $params,
        ]);
    }

    /**
     * alipay.trade.refund(统一收单交易退款接口).
     *
     * @param string           $tradeNo
     * @param float|int|string $amount
     * @param string|null      $outTradeNo
     * @param array            $params
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|\WannanBigPig\Supports\Collection|\WannanBigPig\Supports\Http\Response
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \EasyAlipay\Kernel\Exceptions\InvalidSignException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function refund(string $tradeNo, $amount, string $outTradeNo = null, array $params = [])
    {
        $params = array_merge(array_filter([
            'trade_no' => $tradeNo,
            'out_trade_no' => $outTradeNo,
            'refund_amount' => $amount,
        ], function ($value) {
            return !($this->checkEmpty($value));
        }), $params);

        return $this->request('alipay.trade.refund', [
            'biz_content' => $params,
        ]);
    }

    /**
     * alipay.trade.query(统一收单线下交易查询).
     *
     * @param string      $tradeNo
     * @param string|null $outTradeNo
     * @param string|null $orgPid
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|\WannanBigPig\Supports\Collection|\WannanBigPig\Supports\Http\Response
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \EasyAlipay\Kernel\Exceptions\InvalidSignException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function query(string $tradeNo, string $outTradeNo = null, string $orgPid = null)
    {
        $params = array_filter([
            'trade_no' => $tradeNo,
            'out_trade_no' => $outTradeNo,
            'org_pid' => $orgPid,
        ], function ($value) {
            return !($this->checkEmpty($value));
        });

        return $this->request('alipay.trade.query', [
            'biz_content' => $params,
        ]);
    }

    /**
     * alipay.trade.cancel(统一收单交易撤销接口).
     *
     * @param string      $tradeNo
     * @param string|null $outTradeNo
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|\WannanBigPig\Supports\Collection|\WannanBigPig\Supports\Http\Response
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \EasyAlipay\Kernel\Exceptions\InvalidSignException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function cancel(string $tradeNo, string $outTradeNo = null)
    {
        $params = array_filter([
            'trade_no' => $tradeNo,
            'out_trade_no' => $outTradeNo,
        ], function ($value) {
            return !($this->checkEmpty($value));
        });

        return $this->request('alipay.trade.cancel', [
            'biz_content' => $params,
        ]);
    }

    /**
     * alipay.trade.order.settle(统一收单交易结算接口).
     *
     * @param string      $outRequestNo
     * @param string      $tradeNo
     * @param array       $royaltyParameters
     * @param string|null $operatorId
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|\WannanBigPig\Supports\Collection|\WannanBigPig\Supports\Http\Response
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \EasyAlipay\Kernel\Exceptions\InvalidSignException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function orderSettle(string $outRequestNo, string $tradeNo, array $royaltyParameters, string $operatorId = null)
    {
        $royalty = [];
        if (count($royaltyParameters) === count($royaltyParameters, COUNT_RECURSIVE)) {
            $royalty[0] = $royaltyParameters;
        } else {
            $royalty = $royaltyParameters;
        }
        $params = array_filter([
            'out_request_no' => $outRequestNo,
            'trade_no' => $tradeNo,
            'royalty_parameters' => $royalty,
            'operator_id' => $operatorId,
        ], function ($value) {
            return !($this->checkEmpty($value));
        });

        return $this->request('alipay.trade.order.settle', [
            'biz_content' => $params,
        ]);
    }

    /**
     * alipay.trade.orderinfo.sync(支付宝订单信息同步接口).
     *
     * @param string      $tradeNo
     * @param string      $outRequestNo
     * @param string      $bizType
     * @param string|null $origRequestNo
     * @param string|null $orderBizInfo
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|\WannanBigPig\Supports\Collection|\WannanBigPig\Supports\Http\Response
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \EasyAlipay\Kernel\Exceptions\InvalidSignException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function orderInfoSync(string $tradeNo, string $outRequestNo, string $bizType, string $origRequestNo = null, string $orderBizInfo = null)
    {
        $params = array_filter([
            'trade_no' => $tradeNo,
            'out_request_no' => $outRequestNo,
            'orig_request_no' => $origRequestNo,
            'biz_type' => $bizType,
        ], function ($value) {
            return !($this->checkEmpty($value));
        });

        if (!($this->checkEmpty($orderBizInfo))) {
            $params['order_biz_info'] = json_encode(['status' => $orderBizInfo]);
        }

        return $this->request('alipay.trade.orderinfo.sync', [
            'biz_content' => $params,
        ]);
    }
}
