<?php
/*
 * This file is part of the wannanbigpig/alipay.
 *
 * (c) wannanbigpig <liuml0211@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace WannanBigPig\Alipay\Payment\App;

use WannanBigPig\Alipay\Payment\Kernel\BaseClient;

class Client extends BaseClient
{

    /**
     * alipay.trade.app.pay(app支付接口2.0).
     *
     * @param array $params
     *
     * @return string
     */
    public function pay(array $params)
    {
        $params['timeout_express'] = $params['timeout_express'] ?? '1c';
        return $this->sdkExecute('alipay.trade.app.pay', [
            'biz_content' => $params,
        ]);
    }
}
