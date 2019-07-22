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

class BaseClient extends Support
{
    /**
     * sdkExecute.
     *
     * @param       $endpoint
     * @param array $params
     *
     * @return string
     */
    public function sdkExecute($endpoint, $params = [])
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
     * @param        $endpoint
     * @param array  $params
     * @param string $httpMethod
     *
     * @return string
     */
    public function pageExecute($endpoint, $params = [], $httpMethod = "POST")
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

        if ("GET" == strtoupper($httpMethod)) {

            //value做urlencode
            $preString = $this->getSignContentUrlencode($params);
            //拼接GET请求串
            $requestUrl = $this->app->getGateway()."?".$preString;

            return $requestUrl;
        } else {
            //拼接表单字符串
            return $this->buildRequestForm($params);
        }
    }

    /**
     * buildRequestForm.
     *
     * @param $para_temp
     *
     * @return string
     */
    protected function buildRequestForm($para_temp)
    {

        $sHtml = "<form id='alipaysubmit' name='alipaysubmit' action='".$this->app->getGateway()."?charset=".trim($para_temp['charset'])."' method='POST'>";

        foreach ($para_temp as $key => $val) {
            if (false === $this->checkEmpty($val)) {
                //$val = $this->characet($val, $this->postCharset);
                $val = str_replace("'", "&apos;", $val);
                //$val = str_replace("\"","&quot;",$val);
                $sHtml .= "<input type='hidden' name='".$key."' value='".$val."'/>";
            }
        }

        //submit按钮控件请不要含有name属性
        $sHtml = $sHtml."<input type='submit' value='ok' style='display:none;''></form>";

        $sHtml = $sHtml."<script>document.forms['alipaysubmit'].submit();</script>";

        return $sHtml;
    }
}