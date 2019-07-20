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
use WannanBigPig\Supports\Exceptions\InvalidArgumentException;

/**
 * Class Helpers
 *
 * @author   liuml  <liumenglei0211@163.com>
 * @DateTime 2019-07-18  17:00
 */
trait Helpers
{
    public function generateSign($data, $signType = 'RSA2')
    {
        return $this->sign($this->getSignContent($data), $signType);
    }

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
     * 验签
     *
     * @param $request
     * @param $signData
     * @param $resp
     * @param $respObject
     *
     * @throws Exception
     */
    public function checkResponseSign($request, $signData, $resp, $respObject)
    {

        if (!$this->checkEmpty($this->alipayPublicKey) || !$this->checkEmpty($this->alipayrsaPublicKey)) {
            if ($signData == null || $this->checkEmpty($signData->sign) || $this->checkEmpty($signData->signSourceData)) {
                throw new Exception(" check sign Fail! The reason : signData is Empty");
            }

            // 获取结果sub_code
            $responseSubCode = $this->parserResponseSubCode($request, $resp, $respObject, $this->format);

            if (!$this->checkEmpty($responseSubCode) || ($this->checkEmpty($responseSubCode) && !$this->checkEmpty($signData->sign))) {
                $checkResult = $this->verify($signData->signSourceData, $signData->sign, $this->alipayPublicKey, $this->signType);

                if (!$checkResult) {
                    if (strpos($signData->signSourceData, "\\/") > 0) {
                        $signData->signSourceData = str_replace("\\/", "/", $signData->signSourceData);

                        $checkResult = $this->verify($signData->signSourceData, $signData->sign, $this->alipayPublicKey, $this->signType);

                        if (!$checkResult) {
                            throw new Exception("check sign Fail! [sign=".$signData->sign.", signSourceData=".$signData->signSourceData."]");
                        }
                    } else {
                        throw new Exception("check sign Fail! [sign=".$signData->sign.", signSourceData=".$signData->signSourceData."]");
                    }
                }
            }
        }
    }

    /**
     * parserSignSource.
     *
     * @param $apiName
     * @param $response
     *
     * @return array|null
     */
    public function parserSignSource($apiName, $response)
    {
        $response_suffix = $this->app['config']->get('RESPONSE_SUFFIX', '_response');
        $error_respones = $this->app['config']->get('RESPONSE_SUFFIX', 'error_response');

        $rootNodeName = str_replace(".", "_", $apiName).$response_suffix;

        if (isset($response[$response_suffix])) {
            return $response[$response_suffix];
        } elseif (isset($response[$error_respones])) {
            return $response[$error_respones];
        } else {
            return null;
        }
    }
}
