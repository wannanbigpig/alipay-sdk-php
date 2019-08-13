<?php
/*
 * This file is part of the wannanbigpig/alipay-sdk-php.
 *
 * (c) wannanbigpig <liuml0211@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyAlipay\Tripartite;

use Closure;
use EasyAlipay\Kernel\ServiceContainer;
use EasyAlipay\Payment\Notify\Handle;

/**
 * Class Application
 *
 * @author   liuml  <liumenglei0211@163.com>
 * @DateTime 2019-07-18  16:13
 *
 * @property \EasyAlipay\Tripartite\Agent\Client $agent
 * @property \EasyAlipay\Tripartite\ServiceMarket\Client $serviceMarket
 */
class Application extends ServiceContainer
{

    /**
     * @var array
     */
    protected $providers = [
        'agent' => Agent\Client::class,
    ];

    /**
     * __call.
     *
     * @param $name
     * @param $arguments
     *
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return call_user_func_array([$this['base'], $name], $arguments);
    }

    /**
     * handleNotify.
     *
     * @param \Closure $closure
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handleNotify(Closure $closure)
    {
        return (new Handle($this))->run($closure);
    }
}
