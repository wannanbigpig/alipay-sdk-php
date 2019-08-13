<?php
/*
 * This file is part of the wannanbigpig/alipay-sdk-php.
 *
 * (c) wannanbigpig <liuml0211@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyAlipay\Tripartite\Agent;

use EasyAlipay\Kernel\Support\Support;

class Client extends Support
{
    /**
     * alipay.open.agent.create(开启代商户签约、创建应用事务).
     *
     * @param string $account
     * @param array  $contactInfo
     * @param string $orderTicket
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|\WannanBigPig\Supports\Collection|\WannanBigPig\Supports\Http\Response
     *
     * @throws \EasyAlipay\Kernel\Exceptions\InvalidSignException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function create(string $account, array $contactInfo, string $orderTicket)
    {
        $method = 'alipay.open.agent.create';
        $params = array_filter([
            'account' => $account,
            'contact_info' => $contactInfo,
            'order_ticket' => $orderTicket,
        ], function ($value) {
            return !($this->checkEmpty($value));
        });

        return $this->request($method, [
            'biz_content' => $params,
        ]);
    }

    /**
     * alipay.open.agent.confirm(提交代商户签约、创建应用事务).
     *
     * @param string $batchNo
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|\WannanBigPig\Supports\Collection|\WannanBigPig\Supports\Http\Response
     *
     * @throws \EasyAlipay\Kernel\Exceptions\InvalidSignException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function confirm(string $batchNo)
    {
        $method = 'alipay.open.agent.confirm';
        $params = [
            'batch_no' => $batchNo,
        ];

        return $this->request($method, [
            'biz_content' => $params,
        ]);
    }

    /**
     * alipay.open.agent.cancel(取消代商户签约、创建应用事务).
     *
     * @param string $batchNo
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|\WannanBigPig\Supports\Collection|\WannanBigPig\Supports\Http\Response
     *
     * @throws \EasyAlipay\Kernel\Exceptions\InvalidSignException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function cancel(string $batchNo)
    {
        $method = 'alipay.open.agent.cancel';
        $params = [
            'batch_no' => $batchNo,
        ];

        return $this->request($method, [
            'biz_content' => $params,
        ]);
    }

    /**
     * alipay.open.agent.order.query(查询申请单状态).
     *
     * @param string $batchNo
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|\WannanBigPig\Supports\Collection|\WannanBigPig\Supports\Http\Response
     *
     * @throws \EasyAlipay\Kernel\Exceptions\InvalidSignException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function query(string $batchNo)
    {
        $method = 'alipay.open.agent.order.query';
        $params = [
            'batch_no' => $batchNo,
        ];

        return $this->request($method, [
            'biz_content' => $params,
        ]);
    }

    /**
     * alipay.open.agent.signstatus.query(查询商户某个产品的签约状态).
     *
     * @param string $pid
     * @param string $productCodes
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|\WannanBigPig\Supports\Collection|\WannanBigPig\Supports\Http\Response
     *
     * @throws \EasyAlipay\Kernel\Exceptions\InvalidSignException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function signStatus(string $pid, string $productCodes)
    {
        $method = 'alipay.open.agent.signstatus.query';
        $params = [
            'pid' => $pid,
            'product_codes' => $productCodes,
        ];

        return $this->request($method, [
            'biz_content' => $params,
        ]);
    }

    /**
     * alipay.open.agent.mini.create(代商家创建小程序应用).
     *
     * @param string $params
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|\WannanBigPig\Supports\Collection|\WannanBigPig\Supports\Http\Response
     *
     * @throws \EasyAlipay\Kernel\Exceptions\InvalidSignException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function miniCreate(string $params)
    {
        $method = 'alipay.open.agent.create';

        return $this->request($method, $params);
    }

    /**
     * alipay.open.agent.mobilepay.sign(代签约APP支付产品).
     *
     * @param string $params
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|\WannanBigPig\Supports\Collection|\WannanBigPig\Supports\Http\Response
     *
     * @throws \EasyAlipay\Kernel\Exceptions\InvalidSignException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function appPayment(string $params)
    {
        $method = 'alipay.open.agent.mobilepay.sign';

        return $this->request($method, $params);
    }

    /**
     * alipay.open.agent.facetoface.sign(代签约当面付产品).
     *
     * @param string $params
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|\WannanBigPig\Supports\Collection|\WannanBigPig\Supports\Http\Response
     *
     * @throws \EasyAlipay\Kernel\Exceptions\InvalidSignException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function faceToFace(string $params)
    {
        $method = 'alipay.open.agent.facetoface.sign';

        return $this->request($method, $params);
    }

    /**
     * alipay.open.agent.zhimabrief.sign(代签约芝麻信用（普惠版）产品).
     *
     * @param string $params
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|\WannanBigPig\Supports\Collection|\WannanBigPig\Supports\Http\Response
     *
     * @throws \EasyAlipay\Kernel\Exceptions\InvalidSignException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function sesameCredit(string $params)
    {
        $method = 'alipay.open.agent.zhimabrief.sign';

        return $this->request($method, $params);
    }

    /**
     * alipay.open.agent.offlinepayment.sign(代签约当面付快捷版产品) .
     *
     * @param string $params
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|\WannanBigPig\Supports\Collection|\WannanBigPig\Supports\Http\Response
     *
     * @throws \EasyAlipay\Kernel\Exceptions\InvalidSignException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function offlinePayment(string $params)
    {
        $method = 'alipay.open.agent.offlinepayment.sign';

        return $this->request($method, $params);
    }
}
