<?php
/**
 * Support.php
 *
 * Created by PhpStorm.
 *
 * author: liuml  <liumenglei0211@163.com>
 * DateTime: 2019-04-04  15:42
 */

namespace WannanBigPig\Alipay\Kernel\Support;

use WannanBigPig\Supports\Config;
use WannanBigPig\Supports\Curl\HttpRequest;
use WannanBigPig\Supports\Exceptions\InvalidArgumentException;
use WannanBigPig\Supports\Str;

class Support
{
    use HttpRequest;

    /**
     * Alipay gateway.
     *
     * @var string
     */
    protected $baseUri;

    protected $url = 'https://openapi.alipay.com/gateway.do';
    /**
     * Config.
     *
     * @var Config
     */
    public static $config;

    /**
     * @static   createConfig
     *
     * @param $config
     *
     * @return Config
     *
     * @author   liuml  <liumenglei0211@163.com>
     * @DateTime 2019-04-08  17:17
     */
    public static function createConfig($config)
    {
        self::$config = new Config($config);
        return self::$config;
    }

    /**
     * @static   getConfig
     *
     * @param null $key
     * @param null $default
     *
     * @return array|mixed|null
     *
     * @author   liuml  <liumenglei0211@163.com>
     * @DateTime 2019-04-08  17:17
     */
    public static function getConfig($key = NULL, $default = NULL)
    {
        if (is_null($key)) {
            return self::$config->get();
        }

        if (self::$config->offsetExists($key)) {
            return self::$config[$key];
        }

        return $default;
    }

    /**
     * @static   generateSign
     *
     * @param array $params
     *
     * @return string
     *
     * @throws InvalidArgumentException
     *
     * @author   liuml  <liumenglei0211@163.com>
     * @DateTime 2019-04-08  21:04
     */
    public static function generateSign(array $params): string
    {
        $privateKey = Support::getConfig('private_key');

        if (is_null($privateKey)) {
            throw new InvalidArgumentException('Missing Alipay Config -- [private_key]');
        }

        if (Str::endsWith($privateKey, '.pem')) {
            $privateKey = openssl_pkey_get_private('file://'.$privateKey);
        } else {
            $privateKey = "-----BEGIN RSA PRIVATE KEY-----\n" . wordwrap($privateKey, 64, "\n", true) . "\n-----END RSA PRIVATE KEY-----";
        }

        openssl_sign(self::getSignContent($params), $sign, $privateKey, OPENSSL_ALGO_SHA256);

        $sign = base64_encode($sign);

        return $sign;
    }

    /**
     * @static   getSignContent
     *
     * @param $params
     *
     * @return string
     *
     * @author   liuml  <liumenglei0211@163.com>
     * @DateTime 2019-04-08  21:03
     */
    public static function getSignContent($params)
    {
        ksort($params);

        $stringToBeSigned = "";

        foreach ($params as $k => $v) {
            if ($v !== '' && !is_null($v) && $k != 'sign' && '@' != substr($v, 0, 1)) {
                $v                = self::characet($v, $params['charset']);
                $stringToBeSigned .= $k . '=' . $v . '&';
            }
        }

        unset ($k, $v);

        return rtrim($stringToBeSigned, '&');
    }

    /**
     * @static   characet
     *
     * @param $data
     * @param $targetCharset
     *
     * @return false|string|string[]|null
     *
     * @author   liuml  <liumenglei0211@163.com>
     * @DateTime 2019-04-08  21:03
     */
    public static function characet($data, $targetCharset)
    {
        if (!empty($data)) {
            if (strcasecmp('gb2312', $targetCharset) != 0) {
                $data = mb_convert_encoding($data, $targetCharset, 'gb2312');
            }
        }
        return $data;
    }


}