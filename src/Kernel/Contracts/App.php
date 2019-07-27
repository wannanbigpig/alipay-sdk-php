<?php
/*
 * This file is part of the wannanbigpig/alipay-sdk-php.
 *
 * (c) wannanbigpig <liuml0211@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyAlipay\Kernel\Contracts;

/**
 * Interface App
 *
 * @author   liuml  <liumenglei0211@163.com>
 * @DateTime 2019-07-15  11:33
 *
 * @package  EasyAlipay\Kernel\Contracts
 */
interface App
{
    /**
     * init application config.
     *
     * @param array $config
     *
     * @return mixed
     */
    public function init(array $config);

    /**
     * get config.
     *
     * @return mixed
     */
    public function getConfig();

    /**
     * Return all providers.
     *
     * @return array
     */
    public function getProviders();

    /**
     * @param array $providers
     */
    public function registerProviders(array $providers);
}
