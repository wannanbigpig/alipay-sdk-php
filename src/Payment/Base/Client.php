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
    public function pay(array $params)
    {
        return $this->request('alipay.trade.pay', [
            'biz_content' => $params,
        ]);
    }
}
