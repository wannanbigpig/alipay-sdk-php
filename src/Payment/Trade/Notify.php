<?php
/**
 * Notify.php
 *
 * Created by PhpStorm.
 *
 * author: liuml  <liumenglei0211@163.com>
 * DateTime: 2019-04-16  17:20
 */

namespace WannanBigPig\Alipay\Payment\Trade;

use Symfony\Component\HttpFoundation\Request;

class Notify
{
    public $request;

    public function __construct()
    {
        Request::createFromGlobals();
    }

    public function exce(\Closure $closure)
    {

        call_user_func($closure, $this->getMessage(), [$this, 'fail']);
    }

    public function getMessage()
    {

    }
}
