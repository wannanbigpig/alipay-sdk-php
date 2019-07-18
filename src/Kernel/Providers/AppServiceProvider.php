<?php
/*
 * This file is part of the wannanbigpig/alipay.
 *
 * (c) wannanbigpig <liuml0211@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace WannanBigPig\Alipay\Kernel\Providers;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class AppServiceProvider
 *
 * @author   liuml  <liumenglei0211@163.com>
 * @DateTime 2019-07-17  16:07
 *
 * @package  WannanBigPig\Alipay\Kernel\Providers
 */
class AppServiceProvider implements ServiceProviderInterface
{
    /**
     * Registers services on the given container.
     *
     * @param Container $pimple A container instance
     */
    public function register(Container $pimple)
    {
        foreach ($pimple['providers'] as $key => $value) {
            $pimple[$key] = function ($app) use ($value) {
                return new $value($app);
            };
        }
    }
}
