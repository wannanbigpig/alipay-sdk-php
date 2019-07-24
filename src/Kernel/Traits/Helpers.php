<?php
/*
 * This file is part of the wannanbigpig/alipay.
 *
 * (c) wannanbigpig <liuml0211@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace WannanBigPig\Alipay\Kernel\Traits;

use Exception;
use WannanBigPig\Alipay\Kernel\Exceptions\InvalidSignException;
use WannanBigPig\Supports\Exceptions\InvalidArgumentException;

/**
 * Class Helpers
 *
 * @author   liuml  <liumenglei0211@163.com>
 * @DateTime 2019-07-18  17:00
 */
trait Helpers
{
    /**
     * generateSign.
     *
     * @param        $data
     * @param string $signType
     *
     * @return string
     *
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function generateSign($data, $signType = 'RSA2')
    {
        return $this->sign($this->getSignContent($data), $signType);
    }

    /**
     * getSignContent.
     *
     * @param $params
     *
     * @return string
     */
    public function getSignContent($params)
    {
        ksort($params);

        $stringToBeSigned = "";
        $i = 0;
        foreach ($params as $k => $v) {
            if (false === $this->checkEmpty($v) && "@" != substr($v, 0, 1)) {
                if ($i == 0) {
                    $stringToBeSigned .= "$k"."="."$v";
                } else {
                    $stringToBeSigned .= "&"."$k"."="."$v";
                }
                $i++;
            }
        }

        unset($k, $v);

        return $stringToBeSigned;
    }

    /**
     * This method does URLEncode for values.
     *
     * @param $params
     *
     * @return string
     */
    public function getSignContentUrlencode($params)
    {
        ksort($params);

        $stringToBeSigned = "";
        $i = 0;
        foreach ($params as $k => $v) {
            if (false === $this->checkEmpty($v) && "@" != substr($v, 0, 1)) {
                if ($i == 0) {
                    $stringToBeSigned .= "$k"."=".urlencode($v);
                } else {
                    $stringToBeSigned .= "&"."$k"."=".urlencode($v);
                }
                $i++;
            }
        }

        unset($k, $v);

        return $stringToBeSigned;
    }

    /**
     * sign.
     *
     * @param        $data
     * @param string $signType
     *
     * @return string
     *
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    protected function sign($data, $signType = "RSA2")
    {
        $rsaPrivateKeyFilePath = $this->app['config']->get('private_key_path');
        if ($this->checkEmpty($rsaPrivateKeyFilePath)) {
            $priKey = $this->app['config']['private_key'];
            $res = "-----BEGIN RSA PRIVATE KEY-----\n".
                wordwrap($priKey, 64, "\n", true).
                "\n-----END RSA PRIVATE KEY-----";
        } else {
            $priKey = file_get_contents($rsaPrivateKeyFilePath);
            $res = openssl_get_privatekey($priKey);
        }

        if ($res === false) {
            throw new InvalidArgumentException('Invalid private_key configuration');
        }

        if ("RSA2" == $signType) {
            openssl_sign($data, $sign, $res, OPENSSL_ALGO_SHA256);
        } else {
            openssl_sign($data, $sign, $res);
        }

        if (!$this->checkEmpty($rsaPrivateKeyFilePath)) {
            openssl_free_key($res);
        }
        $sign = base64_encode($sign);

        return $sign;
    }

    /**
     * checkEmpty.
     *
     * @param $value
     *
     * @return bool
     */
    protected function checkEmpty($value)
    {
        if ($value === null) {
            return true;
        }

        if (trim($value) === "") {
            return true;
        }

        return false;
    }

    /**
     * parserSignSource.
     *
     * @param array $response
     *
     * @return array|mixed
     */
    public function parserSignSource(array $response)
    {
        $response_suffix = $this->app['config']->get('RESPONSE_SUFFIX', '_response');
        $error_respones = $this->app['config']->get('RESPONSE_SUFFIX', 'error_response');

        $rootNodeName = str_replace(".", "_", $this->app['config']['api_method']).$response_suffix;

        if (isset($response[$rootNodeName])) {
            return $response[$rootNodeName];
        } elseif (isset($response[$error_respones])) {
            return $response[$error_respones];
        } else {
            return $response;
        }
    }

    /**
     * verify sign.
     *
     * @param string $data
     * @param        $sign
     * @param string $signType
     *
     * @return bool
     *
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function verify(string $data, $sign, $signType = 'RSA2')
    {
        $alipayPublicKeyPath = $this->app['config']->get('alipay_public_Key_path');
        if ($this->checkEmpty($alipayPublicKeyPath)) {
            $pubKey = $this->app['config']->get('alipay_public_Key');
            $res = "-----BEGIN PUBLIC KEY-----\n".
                wordwrap($pubKey, 64, "\n", true).
                "\n-----END PUBLIC KEY-----";
        } else {
            //读取公钥文件
            $pubKey = file_get_contents($alipayPublicKeyPath);
            //转换为openssl格式密钥
            $res = openssl_get_publickey($pubKey);
        }

        if ($res === false) {
            throw new InvalidArgumentException('Invalid alipay_public_Key configuration');
        }

        //调用openssl内置方法验签，返回bool值
        if ("RSA2" == $signType) {
            $result = (openssl_verify($data, base64_decode($sign), $res, OPENSSL_ALGO_SHA256) === 1);
        } else {
            $result = (openssl_verify($data, base64_decode($sign), $res) === 1);
        }

        if (!$this->checkEmpty($alipayPublicKeyPath)) {
            //释放资源
            openssl_free_key($res);
        }

        return $result;
    }

    /**
     * checkResponseSign.
     *
     * @param $response
     *
     * @return bool
     *
     * @throws \WannanBigPig\Alipay\Kernel\Exceptions\InvalidSignException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function checkResponseSign($response)
    {
        $result = true;

        if (isset($response['sign'])) {
            $result = $this->verify(
                \GuzzleHttp\json_encode($this->parserSignSource($response), JSON_UNESCAPED_UNICODE),
                $response['sign'],
                $this->app['config']->get('sign_type', 'RSA2')
            );
        }

        if (!$result) {
            throw new InvalidSignException(sprintf(
                '"%s" method responds to parameter validation signature error',
                $this->app['config']['api_method']
            ));
        }

        return $result;
    }
}
