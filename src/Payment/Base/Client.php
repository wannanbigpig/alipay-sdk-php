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
    public function pay()
    {
        $this->app['logger']->info('记录日志');
        return $this->app['config']->get('appid');
    }
}
