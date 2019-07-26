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
use WannanBigPig\Alipay\Kernel\Contracts\App;
use WannanBigPig\Supports\Config;

/**
 * Class ConfigServiceProvider
 *
 * @author   liuml  <liumenglei0211@163.com>
 * @DateTime 2019-07-15  15:14
 */
class ConfigServiceProvider implements ServiceProviderInterface
{
    /**
     * Registers services on the given container.
     *
     * @param Container $pimple A container instance
     */
    public function register(Container $pimple)
    {
        $pimple['config'] = function (App $app) {
            return new Config($app->getConfig());
        };
    }
}
