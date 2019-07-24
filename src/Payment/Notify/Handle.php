<?php
/*
 * This file is part of the wannanbigpig/alipay.
 *
 * (c) wannanbigpig <liuml0211@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace WannanBigPig\Alipay\Payment\Notify;

use Closure;
use Symfony\Component\HttpFoundation\Response;
use WannanBigPig\Alipay\Kernel\Exceptions\InvalidSignException;
use WannanBigPig\Alipay\Kernel\Traits\Helpers;
use WannanBigPig\Alipay\Payment\Application;
use WannanBigPig\Supports\Collection;

/**
 * Class Handle
 *
 * @author   liuml  <liumenglei0211@163.com>
 * @DateTime 2019-07-23  17:24
 */
class Handle
{
    use Helpers;

    /**
     * @var string
     */
    protected $fail = 'fail';

    /**
     * @var string
     */
    protected $success = 'success';

    /**
     * @var array
     */
    protected $data;

    /**
     * @var string
     */
    protected $response;

    /**
     * @var \WannanBigPig\Alipay\Payment\Application
     */
    protected $app;

    /**
     * Handle constructor.
     *
     * @param \WannanBigPig\Alipay\Payment\Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * run.
     *
     * @param \Closure $closure
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function run(Closure $closure): Response
    {
        try {
            $response = \call_user_func($closure, $this->getMessage(), [$this, 'response']);
        } catch (\Exception $e) {
            $this->app['logger']->error('Alipay asynchronous notification fatal error：'.$e->getMessage());
            $response = $this->response(false);
        }

        return Response::create($response);
    }

    /**
     * response.
     *
     * @param bool $result
     *
     * @return string
     */
    public function response(bool $result = true): string
    {
        if ($result) {
            return $this->success;
        }

        return $this->fail;
    }

    /**
     * getMessage.
     *
     * @return \WannanBigPig\Supports\Collection
     *
     * @throws \WannanBigPig\Alipay\Kernel\Exceptions\InvalidSignException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function getMessage(): Collection
    {
        $signData = $request = $this->app['request']->request->all();
        unset($signData['sign'], $signData['sign_type']);
        if ($this->verify($this->getSignContentUrlencode($signData), $request['sign'], $request['sign_type'])) {
            return new Collection($request);
        }

        throw new InvalidSignException('Asynchronous notification signature verification failed');
    }
}
