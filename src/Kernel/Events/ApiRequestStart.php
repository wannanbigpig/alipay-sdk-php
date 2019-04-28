<?php

namespace WannanBigPig\Alipay\Kernel\Events;

class ApiRequestStart extends Event
{

    /**
     * NAME
     *
     * @var string
     */
    const NAME = 'api_request_start';

    /**
     * request.
     *
     * @var string | array
     */
    public $request;

    /**
     * uri.
     *
     * @var string
     */
    public $uri;

    /**
     * ApiRequestStart constructor.
     *
     * @param  string|null  $driver
     * @param  string|null  $method
     * @param  string       $uri
     * @param               $request
     */
    public function __construct($driver, $method, string $uri, $request)
    {
        $this->uri     = $uri;
        $this->request = $request;

        parent::__construct($driver, $method);
    }

    /**
     * getRequest
     *
     * @return mixed
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * getUri
     *
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }
}
