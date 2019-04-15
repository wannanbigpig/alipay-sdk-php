<?php
/**
 * Class Alipay
 *
 * @author   liuml  <liumenglei0211@163.com>
 * @DateTime 2019-04-04  15:40
 */

namespace WannanBigPig\Alipay;

use WannanBigPig\Alipay\Kernel\Support\Support;
use WannanBigPig\Alipay\Payment\Application;
use WannanBigPig\Supports\Config;
use WannanBigPig\Supports\Exceptions\ApplicationException;
use WannanBigPig\Supports\Str;

/**
 * Class Alipay
 *
 * @author   liuml  <liumenglei0211@163.com>
 * @DateTime 2019-04-04  16:53
 *
 * @package  WannanBigPig\Alipay
 *
 * @method static Application payment(array $config)
 */
class Alipay
{
    /**
     * Const mode_normal.
     */
    const ENV_NORMAL = 'normal';

    /**
     * Const mode_dev.
     */
    const ENV_DEV = 'dev';

    /**
     * Const url.
     */
    const URL
        = [
            self::ENV_NORMAL => 'https://openapi.alipay.com/gateway.do',
            self::ENV_DEV    => 'https://openapi.alipaydev.com/gateway.do',
        ];

    /**
     * commonParams
     *
     * @param  Config  $config
     *
     * @return array
     */
    public function commonParams(Config $config)
    {
        return [
            'app_id'         => $config->get('app_id'),
            'method'         => '',
            'format'         => $config->get('format', 'JSON'),
            'charset'        => $config->get('charset', 'utf-8'),
            'sign_type'      => $config->get('sign_type', 'RSA2'),
            'version'        => $config->get('version', '1.0'),
            'return_url'     => $config->get('return_url'),
            'notify_url'     => $config->get('notify_url'),
            'timestamp'      => date('Y-m-d H:i:s'),
            'sign'           => '',
            'biz_content'    => '',
            'app_auth_token' => $config->get('app_auth_token'),
        ];
    }

    /**
     * create
     *
     * @param $name
     * @param  array  $config
     *
     * @return mixed
     *
     * @throws ApplicationException
     */
    public function create($name, array $config)
    {
        $name        = Str::studly($name);
        $application = __NAMESPACE__."\\{$name}\\Application";
        if (class_exists($application)) {
            // 设置配置数组
            $this->config($config);

            // 实例化应用
            return $this->make($application);
        }

        throw new ApplicationException("Application [{$name}] does not exist");
    }

    /**
     * make
     *
     * @param $application
     *
     * @return mixed
     */
    public function make($application)
    {
        return new $application();
    }

    /**
     * config
     *
     * @param  array  $config
     *
     * @return $this
     */
    public function config(array $config)
    {
        // 创建配置
        $config = Support::createConfig($config);

        // 设置系统参数
        $config->set('payload', $this->commonParams($config));

        // 设置支付宝网关
        $base_uri = self::URL[$config->get('env', self::ENV_NORMAL)];
        $config->set('base_uri', $base_uri);

        return $this;
    }

    /**
     * @static  __callStatic
     *
     * @param $name
     * @param $arguments
     *
     * @return mixed
     *
     * @throws ApplicationException
     */
    public static function __callStatic($name, $arguments)
    {
        $app = new self();
        if (method_exists($app, $name)) {
            return $app->$name(...$arguments);
        }

        return $app->create($name, ...$arguments);
    }
}
