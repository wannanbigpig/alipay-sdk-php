<?php
/*
 * This file is part of the wannanbigpig/alipay.
 *
 * (c) wannanbigpig <liuml0211@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace WannanBigPig\Alipay\Payment\Base;

use WannanBigPig\Alipay\Payment\Kernel\BaseClient;

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
     * @throws \WannanBigPig\Alipay\Kernel\Exceptions\InvalidSignException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function pay(array $params)
    {
        $params['scene'] = $params['scene'] ?? 'bar_code';
        return $this->request('alipay.trade.pay', [
            'biz_content' => $params,
        ]);
    }
}
