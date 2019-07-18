<?php
/*
 * This file is part of the wannanbigpig/alipay.
 *
 * (c) wannanbigpig <liuml0211@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace WannanBigPig\Alipay\Kernel\Support;

use WannanBigPig\Alipay\Kernel\Contracts\App;
use WannanBigPig\Supports\Traits\HttpRequest;

class Support
{
    use HttpRequest {
        request as performRequest;
    }

    /**
     * @var \WannanBigPig\Alipay\Kernel\Contracts\App
     */
    protected $app;

    /**
     * Support constructor.
     *
     * @param \WannanBigPig\Alipay\Kernel\Contracts\App $app
     */
    public function __construct(App $app)
    {
        $this->app = $app;

        $this->setHttpClient($this->app['http_client']);
    }

    public function request($method, $url, $options = [])
    {
        $this->performRequest($method, $url, $options);
    }
}
