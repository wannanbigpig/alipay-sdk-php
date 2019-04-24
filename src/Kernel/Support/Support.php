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

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use WannanBigPig\Alipay\Kernel\Events\ApiRequestEnd;
use WannanBigPig\Alipay\Kernel\Events\ApiRequestStart;
use WannanBigPig\Alipay\Kernel\Events\SignFailed;
use WannanBigPig\Alipay\Kernel\Exceptions\SignException;
use WannanBigPig\Supports\AccessData;
use WannanBigPig\Supports\Config;
use WannanBigPig\Supports\Curl\HttpRequest;
use WannanBigPig\Supports\Events;
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
     * @var string
     */
    public static $fileCharset = 'UTF-8';

    /**
     * @var string
     */
    public static $respCharset = 'UTF-8';

    /**
     * @var float
     */
    public $connectTimeout = 6.0;

    /**
     * @var string
     */
    public $baseUri = '';

    /**
     * @var float
     */
    public $timeout = 6.0;

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
            self::$instance->setHttpOptions();
        }

        return self::$instance;
    }

    /**
     * setHttpOptions
     */
    protected function setHttpOptions()
    {
        if (self::$config->has('http') && is_array(self::$config->get('http'))) {
            self::$config->offsetUnset('http.base_uri');
            $this->httpOptions = self::$config->get('http');
        }
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
     * @param  string  $key
     * @param  string  $default
     *
     * @return mixed
     *
     * @author   liuml  <liumenglei0211@163.com>
     * @DateTime 2019-04-08  17:17
     */
    public static function getConfig($key = '', $default = '')
    {
        if ($key === '') {
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
     * @param  array  $params
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
        $privateKey = self::getConfig('private_key');
        if (!is_string($privateKey)) {
            throw new Exceptions\InvalidArgumentException('请检查 [ private_key ] 配置项的私钥文件格式或路径是否正确,只接受字符串类型值');
        }
        $keyFromFile = Str::endsWith($privateKey, '.pem');
        if ($keyFromFile) {
            $res = openssl_pkey_get_private('file://' . $privateKey);
        } else {
            $res = "-----BEGIN RSA PRIVATE KEY-----\n" .
                wordwrap(
                    $privateKey,
                    64,
                    "\n",
                    true
                ) . "\n-----END RSA PRIVATE KEY-----";
        }

        if (!$res) {
            throw new Exceptions\InvalidArgumentException('支付宝RSA私钥错误。请检查 [ private_key ] 配置项的私钥文件格式或路径是否正确');
        }

        $data = self::getSignContent($params);
        if ("RSA2" == self::getConfig('sign_type', 'RSA2')) {
            openssl_sign($data, $sign, $res, OPENSSL_ALGO_SHA256);
        } else {
            openssl_sign($data, $sign, $res);
        }

        $sign = base64_encode($sign);
        if ($keyFromFile && is_resource($res)) {
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
                $v = self::characet($v, $params['charset'] ?? 'utf-8');

                $stringToBeSigned .= $k . '=' . $v . '&';
            }
        }
        unset($k, $v);

        return rtrim($stringToBeSigned, '&');
    }

    /**
     * @static   getSignContentUrlencode
     *
     * @param $params
     *
     * @return string
     *
     * @author   liuml  <liumenglei0211@163.com>
     * @DateTime 2019-04-11  11:56
     */
    public static function getSignContentUrlencode($params)
    {
        ksort($params);

        $stringToBeSigned = "";

        foreach ($params as $k => $v) {
            if ($v !== '' && !is_null($v) && $k != 'sign' && '@' != substr($v, 0, 1)) {
                $v = self::characet($v, $params['charset'] ?? 'utf-8');

                $stringToBeSigned .= $k . '=' . urlencode($v) . '&';
            }
        }

        unset($k, $v);

        return rtrim($stringToBeSigned, '&');
    }

    /**
     * @static  verifySign
     *
     * @param  string       $data
     * @param  string       $sign
     * @param  null|string  $sign_type
     *
     * @return bool
     *
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public static function verifySign(string $data, string $sign, $sign_type = null): bool
    {
        $publicKey = self::getConfig('ali_public_key');
        if (!is_string($publicKey)) {
            throw new Exceptions\InvalidArgumentException('请检查 [ ali_public_key ] 配置项的公钥文件格式或路径是否正确,只支持字符串类型参数');
        }
        $keyFromFile = Str::endsWith($publicKey, '.pem');
        if ($keyFromFile) {
            $res = openssl_pkey_get_public("file://" . $publicKey);
        } else {
            if ($publicKey) {
                $res = "-----BEGIN PUBLIC KEY-----\n" .
                    wordwrap(
                        $publicKey,
                        64,
                        "\n",
                        true
                    ) . "\n-----END PUBLIC KEY-----";
            } else {
                $res = false;
            }
        }

        if (!$res) {
            Events::dispatch(
                SignFailed::NAME,
                new SignFailed(
                    self::$config->get('event.driver'),
                    self::$config->get('event.method'),
                    [$data],
                    '支付宝RSA公钥错误。请检查 [ ali_public_key ] 配置项的公钥文件格式或路径是否正确'
                )
            );
            throw new Exceptions\InvalidArgumentException('支付宝RSA公钥错误。请检查 [ ali_public_key ] 配置项的公钥文件格式或路径是否正确');
        }
        $sign_type = $sign_type === null ? self::getConfig('sign_type', 'RSA2') : $sign_type;
        // 调用openssl内置方法验签，返回bool值
        if ("RSA2" == $sign_type) {
            $result = (openssl_verify(
                $data,
                base64_decode($sign),
                $res,
                OPENSSL_ALGO_SHA256
            ) === 1);
        } else {
            $result = (openssl_verify($data, base64_decode($sign), $res) === 1);
        }

        if ($keyFromFile && is_resource($res)) {
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
            $data = mb_convert_encoding(
                $data,
                $targetCharset,
                self::$fileCharset
            );
        }

        return $data;
    }


    /**
     * @static   requestApi
     *
     * @param         $gatewayUrl
     * @param  array  $data
     *
     * @return AccessData
     *
     * @throws Exceptions\BusinessException
     * @throws Exceptions\InvalidArgumentException
     * @throws SignException
     *
     * @author   liuml  <liumenglei0211@163.com>
     * @DateTime 2019-04-11  10:38
     */
    public static function requestApi($gatewayUrl, array $data): AccessData
    {
        Events::dispatch(
            ApiRequestStart::NAME,
            new ApiRequestStart(
                self::$config->get('event.driver'),
                self::$config->get('event.method'),
                $gatewayUrl,
                $data
            )
        );
        $data = array_filter($data, function ($value) {
            return ($value == '' || is_null($value)) ? false : true;
        });
        // 请求支付宝网关
        $resp = self::getInstance()->post($gatewayUrl, $data);

        self::$respCharset = mb_detect_encoding($resp, "UTF-8, GBK, GB2312");

        // 将返回结果转换本地文件编码
        $result = iconv(self::$respCharset, self::$fileCharset . "//IGNORE", $resp);

        Events::dispatch(
            ApiRequestEnd::NAME,
            new ApiRequestEnd(
                self::$config->get('event.driver'),
                self::$config->get('event.method'),
                $gatewayUrl,
                $data,
                $result
            )
        );

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
     * @throws Exceptions\BusinessException
     * @throws Exceptions\InvalidArgumentException
     * @throws SignException
     *
     * @author   liuml  <liumenglei0211@163.com>
     * @DateTime 2019-04-11  10:38
     */
    protected static function processingApiResult($data, $resp): AccessData
    {
        $format = self::getConfig('format', 'JSON');
        // 解析返回结果
        $respWellFormed = false;
        if ("XML" == $format) {
            $disableLibxmlEntityLoader = libxml_disable_entity_loader(true);
            $respObject                = @simplexml_load_string($resp);
            libxml_disable_entity_loader($disableLibxmlEntityLoader);
            if (false !== $respObject) {
                $respWellFormed = true;
            }
            $result = json_decode(json_encode($respObject), true);
        } else {
            $result = json_decode($resp, true);
            if (null !== $result) {
                $respWellFormed = true;
            }
        }
        //返回的HTTP文本不是标准JSON或者XML，记下错误日志
        if (false === $respWellFormed) {
            throw new Exceptions\InvalidArgumentException(
                '返回的HTTP文本不是标准JSON或者XML',
                $resp
            );
        }

        $method = str_replace('.', '_', $data['method']) . '_response';

        // 签名不存在抛出应用异常，该异常为支付宝网关错误，例如 app_id 配置错误,没有返回签名，建议检查配置项是否正确
        if (!isset($result['sign'])) {
            throw new SignException(
                '[' . $method . '] Get Alipay API Error: msg ['
                . $result[$method]['msg'] . ']',
                $result
            );
        }

        $result_method_content = json_encode($result[$method], JSON_UNESCAPED_UNICODE);
        $result_method_content = mb_convert_encoding($result_method_content, self::$respCharset, self::$fileCharset);
        // 验证支付返回的签名，验证失败抛出应用异常
        if (!self::verifySign($result_method_content, $result['sign'])) {
            Events::dispatch(
                SignFailed::NAME,
                new SignFailed(
                    self::$config->get('event.driver'),
                    self::$config->get('event.method'),
                    $result,
                    'Signature verification error'
                )
            );
            throw new SignException(
                '[' . $method
                . '] Get Alipay API Error: Signature verification error',
                $result
            );
        }

        // 业务返回处理，返回码 10000 则正常返回成功数据，其他的则抛出业务异常
        // 捕获 BusinessException 异常 获取 raw 元素查看完整数据并做处理
        if ($result[$method]['code'] != '10000' && Support::getConfig('business_exception', false)) {
            throw new Exceptions\BusinessException(
                '[' . $method
                . '] Business Error: msg [' . $result[$method]['msg'] . ']'
                . (isset($result[$method]['sub_code']) ? ' - sub_code ['
                    . $result[$method]['sub_code'] . ']' : '')
                . (isset($result[$method]['sub_msg']) ? ' - sub_msg ['
                    . $result[$method]['sub_msg'] . ']' : ''),
                $result[$method]
            );
        }

        return new AccessData($result[$method]);
    }

    /**
     * @static   assemblyProgram
     *
     * @param          $gatewayUrl
     * @param  array   $data
     * @param  string  $httpmethod
     *
     * @return Response
     *
     * @author   liuml  <liumenglei0211@163.com>
     * @DateTime 2019-04-12  09:54
     */
    public static function assemblyProgram($gatewayUrl, array $data, $httpmethod = 'POST'): Response
    {
        if ("GET" == strtoupper($httpmethod)) {
            //value做urlencode
            $preString = self::getSignContentUrlencode($data);

            //拼接GET请求串
            $requestUrl = $gatewayUrl . "?" . $preString;

            return Response::create($requestUrl);
        }

        //拼接表单字符串
        return Response::create(self::buildRequestForm($gatewayUrl, $data));
    }

    /**
     * @static   buildRequestForm
     *
     * @param $gatewayUrl
     * @param $para_temp
     *
     * @return string
     *
     * @author   liuml  <liumenglei0211@163.com>
     * @DateTime 2019-04-10  15:13
     */
    protected static function buildRequestForm($gatewayUrl, $para_temp)
    {
        $sHtml = "<form id='alipaysubmit' name='alipaysubmit' action='"
            . $gatewayUrl . "' method='POST'>";

        foreach ($para_temp as $key => $val) {
            if (!is_null($val)) {
                //$val = $this->characet($val, $this->postCharset);
                $val = str_replace("'", "&apos;", $val);
                //$val = str_replace("\"","&quot;",$val);
                $sHtml .= "<input type='hidden' name='" . $key . "' value='"
                    . $val . "'/>";
            }
        }

        //submit按钮控件请不要含有name属性
        $sHtml = $sHtml
            . "<input type='submit' value='ok' style='display:none;'></form>";

        $sHtml = $sHtml
            . "<script>document.forms['alipaysubmit'].submit();</script>";

        return $sHtml;
    }

    /**
     * @static   executeApi
     *
     * @param $params
     * @param $method
     *
     * @return AccessData
     *
     * @throws Exceptions\BusinessException
     * @throws Exceptions\InvalidArgumentException
     * @throws SignException
     *
     * @author   liuml  <liumenglei0211@163.com>
     * @DateTime 2019-04-12  10:06
     */
    public static function executeApi($params, $method)
    {
        // 获取公共参数
        $payload = self::$config->get('payload', []);
        // 设置方法
        $payload['method'] = $method;
        // 设置业务参数
        $payload['biz_content'] = json_encode($params);
        // 过滤空值
        $payload = array_filter($payload, function ($value) {
            return $value !== '' && !is_null($value);
        });
        // 设置签名
        $payload['sign'] = self::generateSign($payload);
        // 获取支付宝网关地址
        $base_uri = self::getConfig('base_uri');

        // 请求支付宝网关
        return self::requestApi($base_uri, $payload);
    }

    /**
     * 页面提交执行方法
     *
     * @param  array   $params  跳转类接口的request; $httpmethod 提交方式。两个值可选：post、get
     * @param  string  $method  构建好的、签名后的最终跳转URL（GET）或String形式的form（POST）
     *
     * @return Response
     *
     * @throws Exceptions\InvalidArgumentException
     *
     * @author   liuml  <liumenglei0211@163.com>
     * @DateTime 2019-04-12  09:59
     */
    public static function executePage($params, $method)
    {
        // 请求跳转类接口，返回字符串组装格式get url或post表单形式，默认POST形式
        $http_method = 'POST';
        if (isset($params['http_method'])) {
            $http_method = isset($params['http_method'])
                ? $params['http_method'] : 'POST';
            unset($params['http_method']);
        }
        // 获取公共参数
        $payload = self::$config->get('payload', []);
        // 设置方法
        $payload['method'] = $method;
        // 设置业务参数
        $payload['biz_content'] = json_encode($params);
        // 过滤空值
        $payload = array_filter($payload, function ($value) {
            return $value !== '' && !is_null($value);
        });
        // 设置签名
        $payload['sign'] = self::generateSign($payload);
        // 获取支付宝网关地址
        $base_uri = self::getConfig('base_uri');

        // 生成客户端需要的表单或者url字符串
        return self::assemblyProgram($base_uri, $payload, $http_method);
    }

    /**
     * 生成用于调用收银台SDK的字符串
     *
     * @param  array  $params  SDK接口的请求参数对象
     * @param         $method
     *
     * @return Response
     *
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public static function executeSdk($params, $method): Response
    {
        // 获取公共参数
        $payload = self::$config->get('payload', []);
        // 设置方法
        $payload['method'] = $method;
        // 设置业务参数
        $payload['biz_content'] = json_encode($params);
        // 过滤空值
        $payload = array_filter($payload, function ($value) {
            return $value !== '' && !is_null($value);
        });
        ksort($payload);
        // 设置签名
        $payload['sign'] = self::generateSign($payload);

        foreach ($payload as &$value) {
            $value = self::characet($value, $payload['charset']);
        }

        return Response::create(http_build_query($payload));
    }

    /**
     * @static  notifyVerify
     *
     * @param  mixed  $data
     *
     * @return bool
     *
     * @throws Exceptions\InvalidArgumentException
     */
    public static function notifyVerify($data = null)
    {
        $data      = ($data === null) ? self::getRequest() : $data;
        $sign_type = null;
        if (isset($data['sign_type'])) {
            $sign_type         = $data['sign_type'];
            $data['sign_type'] = null;
        }

        return self::verifySign(
            Support::getSignContent($data),
            $data['sign'],
            $sign_type
        );
    }

    /**
     * @static  getRequest
     *
     * @return array
     */
    public static function getRequest()
    {
        $request = Request::createFromGlobals();

        return $request->request->count() > 0 ? $request->request->all() : $request->query->all();
    }
}
