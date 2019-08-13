<?php
/*
 * This file is part of the wannanbigpig/alipay-sdk-php.
 *
 * (c) wannanbigpig <liuml0211@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyAlipay\Tripartite\ServiceMarket;

use EasyAlipay\Kernel\Support\Support;

class Client extends Support
{
    /**
     * alipay.open.servicemarket.order.query(订购插件订单明细查询).
     *
     * @param string $commodityOrderId
     * @param int    $startPage
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|\WannanBigPig\Supports\Collection|\WannanBigPig\Supports\Http\Response
     *
     * @throws \EasyAlipay\Kernel\Exceptions\InvalidSignException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function orderQuery(string $commodityOrderId, int $startPage = 1)
    {
        $method = 'alipay.open.servicemarket.order.query';
        $params = [
            'commodity_order_id' => $commodityOrderId,
            'start_page' => $startPage,
        ];

        return $this->request($method, [
            'biz_content' => $params,
        ]);
    }

    /**
     * alipay.open.servicemarket.order.accept(服务商接单操作).
     *
     * @param string $commodityOrderId
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|\WannanBigPig\Supports\Collection|\WannanBigPig\Supports\Http\Response
     *
     * @throws \EasyAlipay\Kernel\Exceptions\InvalidSignException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function orderAccept(string $commodityOrderId)
    {
        $method = 'alipay.open.servicemarket.order.accept';
        $params = [
            'commodity_order_id' => $commodityOrderId,
        ];

        return $this->request($method, [
            'biz_content' => $params,
        ]);
    }

    /**
     * alipay.open.servicemarket.order.item.complete(服务商完成订单内单个明细实施项).
     *
     * @param string $commodityOrderId
     * @param string $shopId
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|\WannanBigPig\Supports\Collection|\WannanBigPig\Supports\Http\Response
     *
     * @throws \EasyAlipay\Kernel\Exceptions\InvalidSignException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function orderItemComplete(string $commodityOrderId, string $shopId = null)
    {
        $method = 'alipay.open.servicemarket.order.item.complete';
        $params = array_filter([
            'commodity_order_id' => $commodityOrderId,
            'shop_id' => $shopId,
        ], function ($value) {
            return !($this->checkEmpty($value));
        });

        return $this->request($method, [
            'biz_content' => $params,
        ]);
    }

    /**
     * alipay.open.servicemarket.order.item.confirm(服务商代商家确认实施完成).
     *
     * @param string      $commodityOrderId
     * @param string|null $shopId
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|\WannanBigPig\Supports\Collection|\WannanBigPig\Supports\Http\Response
     *
     * @throws \EasyAlipay\Kernel\Exceptions\InvalidSignException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function orderItemConfirm(string $commodityOrderId, string $shopId = null)
    {
        $method = 'alipay.open.servicemarket.order.item.confirm';
        $params = array_filter([
            'commodity_order_id' => $commodityOrderId,
            'shop_id' => $shopId,
        ], function ($value) {
            return !($this->checkEmpty($value));
        });

        return $this->request($method, [
            'biz_content' => $params,
        ]);
    }

    /**
     * alipay.open.servicemarket.commodity.shop.offline(门店插件下架操作).
     *
     * @param string $commodityId
     * @param string $shopId
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|\WannanBigPig\Supports\Collection|\WannanBigPig\Supports\Http\Response
     *
     * @throws \EasyAlipay\Kernel\Exceptions\InvalidSignException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function commodityShopOffline(string $commodityId, string $shopId)
    {
        $method = 'alipay.open.servicemarket.commodity.shop.offline';
        $params = [
            'commodity_id' => $commodityId,
            'shop_id' => $shopId,
        ];

        return $this->request($method, [
            'biz_content' => $params,
        ]);
    }

    /**
     * alipay.open.servicemarket.commodity.shop.online(门店插件上架操作).
     *
     * @param string $commodityId
     * @param string $shopId
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|\WannanBigPig\Supports\Collection|\WannanBigPig\Supports\Http\Response
     *
     * @throws \EasyAlipay\Kernel\Exceptions\InvalidSignException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function commodityShopOnline(string $commodityId, string $shopId)
    {
        $method = 'alipay.open.servicemarket.commodity.shop.online';
        $params = [
            'commodity_id' => $commodityId,
            'shop_id' => $shopId,
        ];

        return $this->request($method, [
            'biz_content' => $params,
        ]);
    }

    /**
     * alipay.open.servicemarket.order.reject(服务商拒绝接单).
     *
     * @param string $commodityOrderId
     * @param string $rejectReason
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|\WannanBigPig\Supports\Collection|\WannanBigPig\Supports\Http\Response
     *
     * @throws \EasyAlipay\Kernel\Exceptions\InvalidSignException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function orderReject(string $commodityOrderId, string $rejectReason)
    {
        $method = 'alipay.open.servicemarket.order.reject';
        $params = [
            'commodity_order_id' => $commodityOrderId,
            'reject_reason' => $rejectReason,
        ];

        return $this->request($method, [
            'biz_content' => $params,
        ]);
    }

    /**
     * alipay.open.servicemarket.order.item.cancel(服务订单明细实施项单项取消).
     *
     * @param string $commodityOrderId
     * @param string $shopId
     * @param string $cancelReason
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|\WannanBigPig\Supports\Collection|\WannanBigPig\Supports\Http\Response
     *
     * @throws \EasyAlipay\Kernel\Exceptions\InvalidSignException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function orderItemCancel(string $commodityOrderId, string $shopId, string $cancelReason)
    {
        $method = 'alipay.open.servicemarket.order.item.cancel';
        $params = [
            'commodity_order_id' => $commodityOrderId,
            'shop_id' => $shopId,
            'cancel_reason' => $cancelReason,
        ];

        return $this->request($method, [
            'biz_content' => $params,
        ]);
    }
}
