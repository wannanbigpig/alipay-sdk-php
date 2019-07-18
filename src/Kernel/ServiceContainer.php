<?php
/*
 * This file is part of the wannanbigpig/alipay.
 *
 * (c) wannanbigpig <liuml0211@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace WannanBigPig\Alipay\Kernel;

use Pimple\Container;
use WannanBigPig\Alipay\Kernel\Contracts\App;
use WannanBigPig\Alipay\Kernel\Providers\AppServiceProvider;
use WannanBigPig\Alipay\Kernel\Providers\ConfigServiceProvider;
use WannanBigPig\Alipay\Kernel\Providers\HttpClientServiceProvider;
use WannanBigPig\Alipay\Kernel\Providers\LogServiceProvider;

/**
 * Class Application
 *
 * @author   liuml  <liumenglei0211@163.com>
 * @DateTime 2019-07-15  11:33
 *
 * @package  WannanBigPig\Alipay\Kernel
 */
class ServiceContainer extends Container implements App
{
    /**
     * @var string
     */
    const NORMAL_ENV = 'normal';

    /**
     * @var string
     */
    const DEV_ENV = 'dev';

    /**
     * @var array
     */
    protected $gateway = [
        self::NORMAL_ENV => 'https://openapi.alipay.com/gateway.do',
        self::DEV_ENV => 'https://openapi.alipaydev.com/gateway.do',
    ];

    /**
     * @var array
     */
    protected $providers = [];

    /**
     * @var array
     */
    protected $userConfig = [];

    /**
     * @var array
     */
    protected $defaultConfig = [];

    /**
     * Application constructor.
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        parent::__construct(['providers' => $this->providers]);
        $this->registerProviders($this->getProviders());
        $this->init($config);
    }

    /**
     * init application config.
     *
     * @param array $config
     */
    public function init(array $config)
    {
        $this->userConfig = $config;
    }

    /**
     * getConfig.
     *
     * @return array|mixed
     */
    public function getConfig()
    {
        $base = [
            'http' => [
                'timeout' => 30.0,
                'base_uri' => $this->getGateway(),
                'connect_timeout' => 6.0
            ],
        ];

        return array_replace_recursive($base, $this->defaultConfig, $this->userConfig);
    }

    /**
     * Acquisition of development environment.
     *
     * @return mixed|string
     */
    public function getEnv()
    {
        return isset($this->userConfig['env']) ? $this->userConfig['env'] : self::NORMAL_ENV;
    }

    /**
     * Get Alipay gateway address.
     *
     * @return mixed
     */
    public function getGateway()
    {
        return $this->gateway[$this->getEnv()] ?? $this->gateway[self::NORMAL_ENV];
    }

    /**
     * Return all providers.
     *
     * @return array
     */
    public function getProviders()
    {
        return array_merge([
            ConfigServiceProvider::class,
            HttpClientServiceProvider::class,
            LogServiceProvider::class,
            AppServiceProvider::class,
        ]);
    }

    /**
     * @param array $providers
     */
    public function registerProviders(array $providers)
    {
        foreach ($providers as $provider) {
            parent::register(new $provider());
        }
    }
}
