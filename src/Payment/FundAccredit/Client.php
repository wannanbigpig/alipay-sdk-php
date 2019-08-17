<?php
/*
 * This file is part of the wannanbigpig/alipay-sdk-php.
 *
 * (c) wannanbigpig <liuml0211@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyAlipay\Payment\FundAccredit;

use EasyAlipay\Payment\Kernel\BaseClient;

class Client extends BaseClient
{
    /**
     * alipay.fund.auth.operation.detail.query(资金授权操作查询接口).
     *
     * @param array $params
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|\WannanBigPig\Supports\Collection|\WannanBigPig\Supports\Http\Response
     *
     * @throws \EasyAlipay\Kernel\Exceptions\InvalidSignException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function query(array $params)
    {
        $method = 'alipay.fund.auth.operation.detail.query';

        return $this->request($method, [
            'biz_content' => $params,
        ]);
    }

    /**
     * alipay.fund.auth.operation.cancel(资金授权撤销接口).
     *
     * @param array $params
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|\WannanBigPig\Supports\Collection|\WannanBigPig\Supports\Http\Response
     *
     * @throws \EasyAlipay\Kernel\Exceptions\InvalidSignException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function cancel(array $params)
    {
        $method = 'alipay.fund.auth.operation.cancel';
        $this->app->setEndpointConfig($method, [
            'notify_url' => $this->app['config']->get('notify_url'),
        ]);

        return $this->request($method, [
            'biz_content' => $params,
        ]);
    }

    /**
     * alipay.fund.auth.order.freeze(资金授权冻结接口).
     *
     * @param array $params
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|\WannanBigPig\Supports\Collection|\WannanBigPig\Supports\Http\Response
     *
     * @throws \EasyAlipay\Kernel\Exceptions\InvalidSignException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function freeze(array $params)
    {
        $method = 'alipay.fund.auth.order.freeze';
        $this->app->setEndpointConfig($method, [
            'notify_url' => $this->app['config']->get('notify_url'),
        ]);

        return $this->request($method, [
            'biz_content' => $params,
        ]);
    }

    /**
     * alipay.fund.auth.order.unfreeze(资金授权解冻接口).
     *
     * @param string $authNo
     * @param string $outRequestNo
     * @param string $amount
     * @param string $remark
     * @param string $extraParam
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|\WannanBigPig\Supports\Collection|\WannanBigPig\Supports\Http\Response
     *
     * @throws \EasyAlipay\Kernel\Exceptions\InvalidSignException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function unfreeze(string $authNo, string $outRequestNo, string $amount, string $remark, string $extraParam = null)
    {
        $method = 'alipay.fund.auth.order.unfreeze';
        $params = array_filter([
            'auth_no' => $authNo,
            'out_request_no' => $outRequestNo,
            'amount' => $amount,
            'remark' => $remark,
            'extra_param' => $extraParam,
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
     * alipay.fund.auth.order.app.freeze(线上资金授权冻结接口).
     *
     * @param array $params
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|\WannanBigPig\Supports\Collection|\WannanBigPig\Supports\Http\Response
     *
     * @throws \EasyAlipay\Kernel\Exceptions\InvalidSignException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function onlineFreeze(array $params)
    {
        $method = 'alipay.fund.auth.order.app.freeze';
        $this->app->setEndpointConfig($method, [
            'notify_url' => $this->app['config']->get('notify_url'),
        ]);

        return $this->request($method, [
            'biz_content' => $params,
        ]);
    }

    /**
     * alipay.fund.auth.order.voucher.create(资金授权发码接口).
     *
     * @param array $params
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|\WannanBigPig\Supports\Collection|\WannanBigPig\Supports\Http\Response
     *
     * @throws \EasyAlipay\Kernel\Exceptions\InvalidSignException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function getQrcode(array $params)
    {
        $method = 'alipay.fund.auth.order.voucher.create';
        $this->app->setEndpointConfig($method, [
            'notify_url' => $this->app['config']->get('notify_url'),
        ]);

        return $this->request($method, [
            'biz_content' => $params,
        ]);
    }

    /**
     * alipay.fund.trans.toaccount.transfer(单笔转账到支付宝账户接口).
     *
     * @param array $params
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|\WannanBigPig\Supports\Collection|\WannanBigPig\Supports\Http\Response
     *
     * @throws \EasyAlipay\Kernel\Exceptions\InvalidSignException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function transfer(array $params)
    {
        $method = 'alipay.fund.trans.toaccount.transfer';

        return $this->request($method, [
            'biz_content' => $params,
        ]);
    }

    /**
     * alipay.fund.trans.order.query(查询转账订单接口).
     *
     * @param string      $orderId
     * @param string|null $outBizNo
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|\WannanBigPig\Supports\Collection|\WannanBigPig\Supports\Http\Response
     *
     * @throws \EasyAlipay\Kernel\Exceptions\InvalidSignException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function getTransferOrder(string $orderId, string $outBizNo = null)
    {
        $method = 'alipay.fund.trans.order.query';

        $params = array_filter([
            'order_id' => $orderId,
            'out_biz_no' => $outBizNo,
        ], function ($value) {
            return !($this->checkEmpty($value));
        });

        return $this->request($method, [
            'biz_content' => $params,
        ]);
    }

    /**
     * alipay.fund.trans.uni.transfer(统一转账接口).
     *
     * @param array $params
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|\WannanBigPig\Supports\Collection|\WannanBigPig\Supports\Http\Response
     *
     * @throws \EasyAlipay\Kernel\Exceptions\InvalidSignException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function unifiedTransfer(array $params)
    {
        $method = 'alipay.fund.trans.uni.transfer';

        return $this->request($method, [
            'biz_content' => $params,
        ]);
    }

    /**
     * alipay.fund.trans.refund(资金退回接口).
     *
     * @param string      $orderId
     * @param string      $outRequestNo
     * @param string      $refundAmount
     * @param string|null $remark
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|\WannanBigPig\Supports\Collection|\WannanBigPig\Supports\Http\Response
     *
     * @throws \EasyAlipay\Kernel\Exceptions\InvalidSignException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function TransferBack(string $orderId, string $outRequestNo, string $refundAmount, string $remark = null)
    {
        $method = 'alipay.fund.trans.refund';

        $params = array_filter([
            'order_id' => $orderId,
            'out_request_no' => $outRequestNo,
            'refund_amount' => $refundAmount,
            'remark' => $remark,
        ], function ($value) {
            return !($this->checkEmpty($value));
        });

        return $this->request($method, [
            'biz_content' => $params,
        ]);
    }

    /**
     * alipay.fund.trans.app.pay(现金红包无线支付接口).
     *
     * @param array $params
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|\WannanBigPig\Supports\Collection|\WannanBigPig\Supports\Http\Response
     *
     * @throws \EasyAlipay\Kernel\Exceptions\InvalidSignException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function cashBonus(array $params)
    {
        $method = 'alipay.fund.trans.app.pay';

        $this->app->setEndpointConfig($method, [
            'return_url' => $this->app['config']->get('return_url'),
        ]);

        return $this->request($method, [
            'biz_content' => $params,
        ]);
    }

    /**
     * alipay.fund.trans.common.query(转账业务单据查询接口).
     *
     * @param array $params
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|\WannanBigPig\Supports\Collection|\WannanBigPig\Supports\Http\Response
     *
     * @throws \EasyAlipay\Kernel\Exceptions\InvalidSignException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function transferCommonQuery(array $params)
    {
        $method = 'alipay.fund.trans.common.query';

        return $this->request($method, [
            'biz_content' => $params,
        ]);
    }
}
