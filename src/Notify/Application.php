<?php
/**
 * Application.php
 *
 * Created by PhpStorm.
 *
 * author: liuml  <liumenglei0211@163.com>
 * DateTime: 2019-04-04  16:31
 */

namespace WannanBigPig\Alipay\Notify;

use WannanBigPig\Alipay\Kernel\Support\Support;
use WannanBigPig\Supports\Exceptions;

class Application
{
    use Notify;

    /**
     * @var string
     */
    const SUCCESS = 'success';

    /**
     * @var string
     */
    const FAIL = 'fail';

    /**
     * @var string
     */
    protected $method = '';

    /**
     * Application constructor.
     */
    public function __construct()
    {
        $this->setMethod();
    }

    /**
     * __call
     *
     * @param $name
     * @param $arguments
     *
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return call_user_func([$this, $name], ...$arguments);
    }

    /**
     * setMethod
     */
    protected function setMethod()
    {
        Support::$config->set('event', [
            'driver' => 'Notify',
            'method' => $this->method,
        ]);
    }

    /**
     * verify
     *
     * @param  mixed  $data
     *
     * @return bool
     *
     * @throws Exceptions\InvalidArgumentException
     */
    public function verify($data = null)
    {
        return Support::notifyVerify($data);
    }
}
