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
use WannanBigPig\Supports\Logs\Log;

/**
 * Class LogServiceProvider
 *
 * @author   liuml  <liumenglei0211@163.com>
 * @DateTime 2019-07-18  17:00
 */
class LogServiceProvider implements ServiceProviderInterface
{
    /**
     * Registers services on the given container.
     *
     * @param Container $pimple A container instance
     */
    public function register(Container $pimple)
    {
        $pimple['logger'] = $pimple['log'] = function ($app) {
            $config = $this->logConfig($app);

            return new Log($config);
        };
    }

    /**
     * Get the log configuration.
     *
     * @param $app
     *
     * @return array
     */
    public function logConfig($app)
    {
        $logConfig = [];
        if (!empty($app['config']->get('log'))) {
            $logConfig = $app['config']->get('log');
        }

        return array_merge([
            'driver' => 'single',
            'level' => 'notice',
            'format' => "%datetime% > %channel% [ %level_name% ] > %message% %context% %extra%\n",
            'path' => '/tmp/wannanbigpig.alipay.log',
        ], $logConfig);
    }
}
