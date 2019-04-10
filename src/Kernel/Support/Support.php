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

use Symfony\Component\HttpFoundation\Response;
use WannanBigPig\Supports\AccessData;
use WannanBigPig\Supports\Config;
use WannanBigPig\Supports\Curl\HttpRequest;
use WannanBigPig\Supports\Exceptions;
use WannanBigPig\Supports\Str;

class Support
{
    use HttpRequest;

    /**
     * Instance.
     *
     * @var Support
     */
    private static $instance;

    /**
     * Config.
     *
     * @var Config
     */
    public static $config;

    /**
     * Charset
     *
     * @var array
     */
    public static $fileCharset = ['gb2312', 'GBK', 'uft-8'];

    /**
     * @static   getInstance
     *
     * @return Support
     *
     * @author   liuml  <liumenglei0211@163.com>
     * @DateTime 2019-04-09  10:13
     */
    public static function getInstance()
    {
        if (php_sapi_name() === 'cli' || !(self::$instance instanceof self)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

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
     * @throws Exceptions\InvalidArgumentException
     *
     * @author   liuml  <liumenglei0211@163.com>
     * @DateTime 2019-04-09  17:24
     */
    public static function generateSign(array $params): string
    {
        $privateKey  = self::getConfig('private_key');
        $keyFromFile = Str::endsWith($privateKey, '.pem');
        if ($keyFromFile) {
            $res = openssl_pkey_get_private('file://' . $privateKey);
        } else {
            $res = "-----BEGIN RSA PRIVATE KEY-----\n" . wordwrap($privateKey, 64, "\n", true) . "\n-----END RSA PRIVATE KEY-----";
        }

        if (!$res) {
            throw new Exceptions\InvalidArgumentException('支付宝RSA私钥错误。请检查 [ private_key ] 配置项的私钥文件格式或路径是否正确');
        }

        $data = self::getSignContent($params);
        if ("RSA2" == self::getConfig('', 'RSA2')) {
            openssl_sign($data, $sign, $res, OPENSSL_ALGO_SHA256);
        } else {
            openssl_sign($data, $sign, $res);
        }

        $sign = base64_encode($sign);
        if ($keyFromFile) {
            // 释放资源
            openssl_free_key($res);
        }
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
                $v                = self::characet($v, $params['charset'] ?? 'utf-8');
                $stringToBeSigned .= $k . '=' . $v . '&';
            }
        }

        unset ($k, $v);

        return rtrim($stringToBeSigned, '&');
    }

    /**
     * @static   verifySign
     *
     * @param string $params
     * @param        $sign
     *
     * @return bool
     *
     * @throws Exceptions\InvalidArgumentException
     *
     * @author   liuml  <liumenglei0211@163.com>
     * @DateTime 2019-04-09  19:02
     */
    public static function verifySign(string $params, $sign): bool
    {
        $publicKey = self::getConfig('ali_public_key');

        $keyFromFile = Str::endsWith($publicKey, '.pem');
        if ($keyFromFile) {
            $res = openssl_pkey_get_public("file://" . $publicKey);
        } else {
            $res = "-----BEGIN PUBLIC KEY-----\n" .
                wordwrap($publicKey, 64, "\n", true) .
                "\n-----END PUBLIC KEY-----";
        }

        if (!$res) {
            throw new Exceptions\InvalidArgumentException('支付宝RSA公钥错误。请检查 [ ali_public_key ] 配置项的公钥文件格式或路径是否正确');
        }
        $params = mb_convert_encoding($params, 'gb2312', 'utf-8');

        // 调用openssl内置方法验签，返回bool值
        if ("RSA2" == self::getConfig('sign_type', 'RSA2')) {
            $result = (openssl_verify($params, base64_decode($sign), $res, OPENSSL_ALGO_SHA256) === 1);
        } else {
            $result = (openssl_verify($params, base64_decode($sign), $res) === 1);
        }

        if ($keyFromFile) {
            // 释放资源
            openssl_free_key($res);
        }
        return $result;
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
            $data = mb_convert_encoding($data, $targetCharset, self::$fileCharset);
        }
        return $data;
    }


    /**
     * @static   requestApi
     *
     * @param array $data
     *
     * @return AccessData
     *
     * @throws Exceptions\ApplicationException
     * @throws Exceptions\BusinessException
     * @throws Exceptions\InvalidArgumentException
     *
     * @author   liuml  <liumenglei0211@163.com>
     * @DateTime 2019-04-09  17:19
     */
    public static function requestApi(array $data): AccessData
    {
        $data = array_filter($data, function($value) {
            return ($value == '' || is_null($value)) ? false : true;
        });

        $result = mb_convert_encoding(self::getInstance()->post(self::$config->get('base_uri'), $data), self::$config->get('charset', 'utf-8'), self::$fileCharset);

        return self::processingApiResult($data, $result);
    }

    /**
     * @static   processingApiResult
     *
     * @param $data
     * @param $resp
     *
     * @return AccessData
     *
     * @throws Exceptions\ApplicationException
     * @throws Exceptions\BusinessException
     * @throws Exceptions\InvalidArgumentException
     *
     * @author   liuml  <liumenglei0211@163.com>
     * @DateTime 2019-04-09  18:45
     */
    protected static function processingApiResult($data, $resp): AccessData
    {
        $format = self::getConfig('format', 'JSON');
        $result = [];
        // 解析返回结果
        $respWellFormed = false;
        if ("JSON" == $format) {
            $result = json_decode($resp, true);
            if (NULL !== $result) {
                $respWellFormed = true;
            }
        } else if ("XML" == $format) {
            $disableLibxmlEntityLoader = libxml_disable_entity_loader(true);
            $respObject                = @ simplexml_load_string($resp);
            libxml_disable_entity_loader($disableLibxmlEntityLoader);
            if (NULL !== $respObject) {
                $respWellFormed = true;
            }
            $result = json_decode(json_encode($respObject), true);
        }

        //返回的HTTP文本不是标准JSON或者XML，记下错误日志
        if (false === $respWellFormed) {
            throw new Exceptions\InvalidArgumentException('返回的HTTP文本不是标准JSON或者XML', $resp);
        }

        $method = str_replace('.', '_', $data['method']) . '_response';

        // 签名不存在抛出应用异常，该异常为支付宝网关错误，例如 app_id 配置错误
        if (!isset($result['sign'])) {
            throw new Exceptions\ApplicationException(
                '[' . $method . '] Get Alipay API Error: msg [' . $result[$method]['msg'] . ']',
                $result
            );
        }

        // 验证支付返回的签名，验证失败抛出应用异常
        if (!self::verifySign(json_encode($result[$method], JSON_UNESCAPED_UNICODE), $result['sign'])) {
            throw new Exceptions\ApplicationException(
                '[' . $method . '] Get Alipay API Error: Signature verification error',
                $result
            );
        }

        // 业务返回处理，返回码 10000 则正常返回成功数据，其他的则抛出业务异常
        // 捕获 BusinessException 异常 获取 raw 元素查看完整数据并做处理
        if ($result[$method]['code'] != '10000') {
            throw new Exceptions\BusinessException(
                '[' . $method . '] Business Error: msg [' . $result[$method]['msg'] . ']' . (isset($result[$method]['sub_code']) ? ' - sub_code [' . $result[$method]['sub_code'] . ']' : '') . (isset($result[$method]['sub_msg']) ? ' - sub_msg [' . $result[$method]['sub_msg'] . ']' : ''), $result
            );
        }

        return new AccessData($result[$method]);
    }

    /**
     * @static   pageExecute
     *
     * @param array $data
     *
     * @return Response
     *
     * @author   liuml  <liumenglei0211@163.com>
     * @DateTime 2019-04-10  12:00
     */
    public static function pageExecute(array $data): Response
    {
        $httpmethod = self::getConfig('http_method', "POST");
        if ("GET" == strtoupper($httpmethod)) {

            //value做urlencode
            $preString = self::getSignContent($data);

            //拼接GET请求串
            $requestUrl = self::getConfig('base_uri') . "?" . $preString;

            return Response::create($requestUrl);
        } else {
            //拼接表单字符串
            return Response::create(self::buildRequestForm($data));
        }
    }

    /**
     * @static   buildRequestForm 建立请求，以表单HTML形式构造（默认）
     *
     * @param $para_temp
     *
     * @return string
     *
     * @author   liuml  <liumenglei0211@163.com>
     * @DateTime 2019-04-10  11:58
     */
    protected static function buildRequestForm($para_temp)
    {

        $sHtml = "<form id='alipaysubmit' name='alipaysubmit' action='" . self::getConfig('base_uri') . "' method='POST'>";

        foreach ($para_temp as $key => $val) {
            if (!is_null($val)) {
                //$val = $this->characet($val, $this->postCharset);
                $val = str_replace("'", "&apos;", $val);
                //$val = str_replace("\"","&quot;",$val);
                $sHtml .= "<input type='hidden' name='" . $key . "' value='" . $val . "'/>";
            }
        }

        //submit按钮控件请不要含有name属性
        $sHtml = $sHtml . "<input type='submit' value='ok' style='display:none;''></form>";

        $sHtml = $sHtml . "<script>document.forms['alipaysubmit'].submit();</script>";

        return $sHtml;
    }

}