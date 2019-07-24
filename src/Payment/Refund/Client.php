<?php
/*
 * This file is part of the wannanbigpig/alipay.
 *
 * (c) wannanbigpig <liuml0211@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace WannanBigPig\Alipay\Payment\Refund;

use WannanBigPig\Alipay\Payment\Kernel\BaseClient;

/**
 * Class Client
 *
 * @author   liuml  <liumenglei0211@163.com>
 * @DateTime 2019-07-24  14:24
 */
class Client extends BaseClient
{
    /**
     * alipay.trade.fastpay.refund.query(统一收单交易退款查询).
     *
     * @param string      $tradeNo
     * @param string|null $outTradeNo
     * @param string|null $outRequestNo
     * @param string|null $orgPid
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|\WannanBigPig\Supports\Collection|\WannanBigPig\Supports\Http\Response
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WannanBigPig\Alipay\Kernel\Exceptions\InvalidSignException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function query(string $tradeNo, string $outTradeNo = null, string $outRequestNo = null, string $orgPid = null)
    {
        $params = array_filter([
            'trade_no' => $tradeNo,
            'out_trade_no' => $outTradeNo,
            'out_request_no' => $outRequestNo ?: $outTradeNo,
            'orgPid' => $orgPid,
        ], function ($value) {
            return !($this->checkEmpty($value));
        });

        return $this->request('alipay.trade.fastpay.refund.query', [
            'biz_content' => $params,
        ]);
    }

    /**
     * alipay.trade.page.refund(统一收单退款页面接口).
     *
     * @param string      $tradeNo
     * @param             $amount
     * @param string|null $outTradeNo
     * @param array       $params
     * @param string      $httpMethod
     *
     * @return string
     *
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function page(string $tradeNo, $amount, string $outTradeNo = null, array $params = [], string $httpMethod = 'POST')
    {
        $params = array_merge(array_filter([
            'trade_no' => $tradeNo,
            'out_trade_no' => $outTradeNo,
            'refund_amount' => $amount,
        ], function ($value) {
            return !($this->checkEmpty($value));
        }), $params);

        return $this->pageExecute('alipay.trade.refund', [
            'biz_content' => $params,
        ], $httpMethod);
    }
}
