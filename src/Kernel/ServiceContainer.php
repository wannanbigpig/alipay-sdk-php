<?php
/*
 * This file is part of the wannanbigpig/alipay-sdk-php.
 *
 * (c) wannanbigpig <liuml0211@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyAlipay\Kernel;

use Closure;
use EasyAlipay\Kernel\Contracts\App;
use EasyAlipay\Kernel\Notify\Handle;
use EasyAlipay\Kernel\Providers\AppServiceProvider;
use EasyAlipay\Kernel\Providers\ConfigServiceProvider;
use EasyAlipay\Kernel\Providers\HttpClientServiceProvider;
use EasyAlipay\Kernel\Providers\LogServiceProvider;
use EasyAlipay\Kernel\Providers\RequestServiceProvider;
use Pimple\Container;
use WannanBigPig\Supports\Exceptions\RuntimeException;

/**
 * Class ServiceContainer
 *
 * @property \WannanBigPig\Supports\Config             $config
 * @property \Symfony\Component\HttpFoundation\Request $request
 * @property \GuzzleHttp\Client                        $http_client
 * @property \Monolog\Logger                           $logger
 *
 * @author   liuml  <liumenglei0211@163.com>
 * @DateTime 2019-07-18  16:13
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
    public function __construct(array $config = [])
    {
        parent::__construct(['app_client_providers' => $this->providers]);
        $this->init($config);
        $this->registerProviders($this->getProviders());
    }

    /**
     * __get.
     *
     * @param $name
     *
     * @return mixed
     *
     * @throws \WannanBigPig\Supports\Exceptions\RuntimeException
     */
    public function __get($name)
    {
        if (isset($this[$name])) {
            return $this[$name];
        }
        throw new RuntimeException(sprintf('Identifier "%s" is not defined', $name));
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
                'timeout' => 6.0,
                'base_uri' => $this->getGateway(),
                'connect_timeout' => 6.0,
                'log_template' => "\n>>>>>>>>request\n--------\n{request}\n--------\n>>>>>>>>response\n--------\n{response}\n--------\n>>>>>>>>error\n--------\n{error}\n--------\n",
            ],
        ];

        return array_replace_recursive($base, $this->defaultConfig, $this->userConfig);
    }

    /**
     * Get the common request parameters of Alipay interface.
     *
     * @param $endpoint
     *
     * @return array
     */
    public function apiCommonConfig(string $endpoint): array
    {
        $this->config->set('api_method', $endpoint);

        return array_merge([
            'app_id' => $this->config['sys_params.app_id'],
            'method' => $endpoint,
            'format' => 'JSON',
            'charset' => $this->config->get('sys_params.charset', 'utf-8'),
            'sign_type' => $this->config->get('sys_params.sign_type', 'RSA2'),
            'sign' => '',
            'timestamp' => date('Y-m-d H:i:s'),
            'version' => '1.0',
            'app_auth_token' => $this->config->get('sys_params.app_auth_token', ''),
        ], $this->config->get($endpoint.'config', []));
    }

    /**
     * setEndpointConfig.
     *
     * @param string $endpoint
     * @param array  $config
     *
     * @return $this
     */
    public function setEndpointConfig(string $endpoint, array $config)
    {
        $this->config->set($endpoint.'config', $config);

        return $this;
    }

    /**
     * Acquisition of development environment.
     *
     * @return bool
     */
    public function getEnv(): bool
    {
        return (bool)(isset($this->userConfig['sandbox']) ? $this->userConfig['sandbox'] : false);
    }

    /**
     * Get Alipay gateway address.
     *
     * @return mixed
     */
    public function getGateway()
    {
        if ($this->getEnv()) {
            return $this->gateway[self::DEV_ENV];
        } else {
            return $this->gateway[self::NORMAL_ENV];
        }
    }

    /**
     * setAppAuthToken.
     *
     * @param $appAuthToken
     *
     * @return $this
     */
    public function setAppAuthToken($appAuthToken)
    {
        $this->config->set('sys_params.app_auth_token', $appAuthToken);

        return $this;
    }

    /**
     * setNotifyUrl.
     *
     * @param string $notifyUrl
     *
     * @return $this
     */
    public function setNotifyUrl(string $notifyUrl)
    {
        $this->config->set('notify_url', $notifyUrl);

        return $this;
    }

    /**
     * setReturnUrl.
     *
     * @param string $returnUrl
     *
     * @return $this
     */
    public function setReturnUrl(string $returnUrl)
    {
        $this->config->set('return_url', $returnUrl);

        return $this;
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
            RequestServiceProvider::class,
            AppServiceProvider::class,
        ]);
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
