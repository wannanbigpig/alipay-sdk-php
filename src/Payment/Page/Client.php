<?php
/*
 * This file is part of the wannanbigpig/alipay.
 *
 * (c) wannanbigpig <liuml0211@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace WannanBigPig\Alipay\Payment\Page;

use WannanBigPig\Alipay\Payment\Kernel\BaseClient;

class Client extends BaseClient
{

    /**
     * alipay.trade.wap.pay(手机网站支付接口2.0).
     *
     * @param array  $params
     * @param string $httpMethod
     *
     * @return string
     */
    public function wap(array $params, $httpMethod = 'GET')
    {
        $params['timeout_express'] = $params['timeout_express'] ?? '1c';

        return $this->pageExecute('alipay.trade.wap.pay', [
            'biz_content' => $params,
        ], $httpMethod);
    }
}
