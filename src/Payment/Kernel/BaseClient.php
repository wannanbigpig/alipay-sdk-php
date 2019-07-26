<?php
/*
 * This file is part of the wannanbigpig/alipay.
 *
 * (c) wannanbigpig <liuml0211@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace WannanBigPig\Alipay\Payment\Kernel;

use WannanBigPig\Alipay\Kernel\Support\Support;

/**
 * Class BaseClient
 *
 * @author   liuml  <liumenglei0211@163.com>
 * @DateTime 2019-07-24  14:25
 */
class BaseClient extends Support
{
    /**
     * sdkExecute.
     *
     * @param string $endpoint
     * @param array  $params
     *
     * @return string
     *
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function sdkExecute(string $endpoint, array $params = [])
    {
        // Get api system parameters
        $sysParams = $this->app->apiCommonConfig($endpoint);
        // Filter system parameters
        $sysParams = array_filter($sysParams, function ($value) {
            return !($this->checkEmpty($value));
        });
        $params = array_merge($sysParams, $this->json($params));
        // Set the signature
        $params['sign'] = $this->generateSign($params, $sysParams['sign_type']);

        ksort($params);

        return http_build_query($params);
    }

    /**
     * pageExecute.
     *
     * @param string $endpoint
     * @param array  $params
     * @param string $httpMethod
     *
     * @return string
     *
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function pageExecute(string $endpoint, array $params = [], string $httpMethod = "POST")
    {

        // Get api system parameters
        $sysParams = $this->app->apiCommonConfig($endpoint);
        // Filter system parameters
        $sysParams = array_filter($sysParams, function ($value) {
            return !($this->checkEmpty($value));
        });
        $params = array_merge($sysParams, $this->json($params));
        // Set the signature
        $params['sign'] = $this->generateSign($params, $sysParams['sign_type']);

        if ("GET" === strtoupper($httpMethod)) {
            // value urlencode
            $preString = $this->getSignContentUrlencode($params);
            // Stitching GET request string
            $requestUrl = $this->app->getGateway()."?".$preString;

            return $requestUrl;
        } else {
            // Stitching form string
            return $this->buildRequestForm($params);
        }
    }

    /**
     * buildRequestForm.
     *
     * @param array $paraTemp
     *
     * @return string
     */
    protected function buildRequestForm(array $paraTemp)
    {
        $sHtml = "<form id='alipaysubmit' name='alipaysubmit' action='".
            $this->app->getGateway()."?charset=".trim($paraTemp['charset']).
            "' method='POST'>";

        foreach ($paraTemp as $key => $val) {
            if (false === $this->checkEmpty($val)) {
                $val = str_replace("'", "&apos;", $val);
                $sHtml .= "<input type='hidden' name='".$key."' value='".$val."'/>";
            }
        }

        // Submit button control please do not include the name attribute
        $sHtml = $sHtml."<input type='submit' value='ok' style='display:none;''></form>";

        $sHtml = $sHtml."<script>document.forms['alipaysubmit'].submit();</script>";

        return $sHtml;
    }
}
