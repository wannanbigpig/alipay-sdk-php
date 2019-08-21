<?php
/*
 * This file is part of the wannanbigpig/alipay-sdk-php.
 *
 * (c) wannanbigpig <liuml0211@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyAlipay\BaseService\Auth;

use EasyAlipay\Kernel\Support\Support;

class Client extends Support
{
    /**
     * alipay.system.oauth.token(换取授权访问令牌).
     *
     * @param string $code
     * @param string $grantType
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|\WannanBigPig\Supports\Collection|\WannanBigPig\Supports\Http\Response
     *
     * @throws \EasyAlipay\Kernel\Exceptions\InvalidSignException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function getAccessToken(string $code, string $grantType = 'authorization_code')
    {
        $method = 'alipay.system.oauth.token';

        $params = [
            'grant_type' => $grantType,
        ];

        if ($grantType !== 'authorization_code') {
            $params['refresh_token'] = $code;
        } else {
            $params['code'] = $code;
        }

        return $this->request($method, $params);
    }

    /**
     * get authorization url.
     *
     * @param string      $redirectUri
     * @param string      $scope
     * @param string|null $state
     *
     * @return string
     */
    public function getAuthorizationUrl(string $redirectUri, string $scope = 'auth_base', string $state = null)
    {
        $appid = $this->app->config->get('sys_params.app_id');
        $params = [
            'app_id' => $appid,
            'scope' => $scope,
            'redirect_uri' => $redirectUri,
            'state' => $state ?: $scope,
        ];

        $url = 'https://openauth.alipay.com/oauth2/publicAppAuthorize.htm?';

        return $url.http_build_query($params);
    }

    /**
     * alipay.user.info.share(支付宝会员授权信息查询接口).
     *
     * @param string $authToken
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|\WannanBigPig\Supports\Collection|\WannanBigPig\Supports\Http\Response
     *
     * @throws \EasyAlipay\Kernel\Exceptions\InvalidSignException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function getUserInfo(string $authToken)
    {
        $method = 'alipay.user.info.share';
        $params = [
            'auth_token' => $authToken,
        ];

        return $this->request($method, $params);
    }

    /**
     * alipay.user.info.auth(用户登陆授权).
     *
     * @param string      $state
     * @param string      $scopes
     * @param string|null $returnUrl
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|\WannanBigPig\Supports\Collection|\WannanBigPig\Supports\Http\Response
     *
     * @throws \EasyAlipay\Kernel\Exceptions\InvalidSignException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function loginAuthorization(string $state, string $scopes = 'auth_base', string $returnUrl = null)
    {
        $method = 'alipay.user.info.auth';
        $params = [
            'scopes' => $scopes,
            'state' => $state,
        ];
        $this->app->setEndpointConfig($method, [
            'return_url' => $returnUrl ?: $this->app['config']->get('return_url'),
        ]);

        return $this->request($method, [
            'biz_content' => $params,
        ]);
    }
}
