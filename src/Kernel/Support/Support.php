<?php
/*
 * This file is part of the wannanbigpig/alipay-sdk-php.
 *
 * (c) wannanbigpig <liuml0211@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyAlipay\Kernel\Support;

use EasyAlipay\Kernel\ServiceContainer;
use EasyAlipay\Kernel\Traits\Helpers;
use GuzzleHttp\MessageFormatter;
use GuzzleHttp\Middleware;
use Psr\Http\Message\ResponseInterface;
use WannanBigPig\Supports\Http\Response;
use WannanBigPig\Supports\Traits\HttpRequest;
use WannanBigPig\Supports\Traits\ResponseCastable;

/**
 * Class Support
 *
 * @author   liuml  <liumenglei0211@163.com>
 * @DateTime 2019-07-22  11:10
 */
class Support
{
    use Helpers, ResponseCastable, HttpRequest {
        HttpRequest::request as performRequest;
    }

    /**
     * @var \EasyAlipay\Kernel\ServiceContainer
     */
    protected $app;

    /**
     * Support constructor.
     *
     * @param \EasyAlipay\Kernel\ServiceContainer $app
     */
    public function __construct(ServiceContainer $app)
    {
        $this->app = $app;

        $this->setHttpClient($this->app['http_client']);
    }

    /**
     * request.
     *
     * @param        $endpoint
     * @param array  $params
     * @param string $method
     * @param array  $options
     * @param bool   $returnResponse
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|\WannanBigPig\Supports\Collection|\WannanBigPig\Supports\Http\Response
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \EasyAlipay\Kernel\Exceptions\InvalidSignException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function request($endpoint, $params = [], $method = 'POST', array $options = [], $returnResponse = false)
    {
        // Get api system parameters
        $sysParams = $this->app->apiCommonConfig($endpoint);
        // Filter system parameters
        $sysParams = array_filter($sysParams, function ($value) {
            return !($this->checkEmpty($value));
        });
        $params = $this->json($params);
        // Set the signature
        $sysParams['sign'] = $this->generateSign(array_merge($sysParams, $params), $sysParams['sign_type']);
        // Set log middleware to record data, Log request and response data to the log file info level
        $this->pushMiddleware($this->logMiddleware(), 'log');
        // Set http parameter options
        $options = array_merge([
            'form_params' => $params,
            'headers' => [
                'content-type' => 'application/x-www-form-urlencoded',
                'charset' => $sysParams['charset'],
            ],
        ], $options);

        $response = $this->performRequest($method, '?'.http_build_query($sysParams), $options);

        $arrayBody = \GuzzleHttp\json_decode((string)$response->getBody(), true, 512, JSON_BIGINT_AS_STRING);
        $context = \GuzzleHttp\json_encode($this->parserSignSource($arrayBody, $endpoint), JSON_UNESCAPED_UNICODE);

        // Verify Response Signature
        $this->checkResponseSign($context, $arrayBody['sign'] ?? null);

        return $returnResponse ? $response : $this->handleResponse($response, $context);
    }

    /**
     * handleResponse.
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param string|null                         $context
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|\WannanBigPig\Supports\Collection|\WannanBigPig\Supports\Http\Response
     *
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function handleResponse(ResponseInterface $response, string $context = null)
    {
        $is_build = true;
        if ($this->app['config']->get('handle_response', true) && !is_null($context)) {
            $response = new Response(
                $response->getStatusCode(),
                $response->getHeaders(),
                $context,
                $response->getProtocolVersion(),
                $response->getReasonPhrase()
            );
            $is_build = false;
        }

        return $this->castResponseToType($response, $this->app['config']->get('response_type', 'array'), $is_build);
    }

    /**
     * Log the request.
     *
     * @return \Closure
     */
    protected function logMiddleware()
    {
        $formatter = new MessageFormatter($this->app['config']['http.log_template'] ?? MessageFormatter::DEBUG);

        return Middleware::log($this->app['logger']->getLogger(), $formatter);
    }

    /**
     * json.
     *
     * @param array $data
     *
     * @return array
     */
    protected function json(array $data): array
    {
        $array = [];
        if (isset($data['biz_content']) && is_array($data['biz_content'])) {
            $array['biz_content'] = \GuzzleHttp\json_encode($data['biz_content'], JSON_UNESCAPED_UNICODE);
        } else {
            return $data;
        }

        return $array;
    }
}
