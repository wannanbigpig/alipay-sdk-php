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
use Closure;
use WannanBigPig\Alipay\Kernel\Events\SignFailed;
use WannanBigPig\Alipay\Kernel\Support\Support;
use WannanBigPig\Supports\Events;

class Notify
{

    protected $data;

    /**
     * exce
     *
     * @param  \Closure  $closure
     * @param  null      $data
     *
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function exce(Closure $closure, $data = null)
    {
        $this->setData($data);
        $request = $this->getRequset();
        if (Support::notifyVerify($this->getData())) {
            call_user_func($closure, $request, $this);
        }
        Events::dispatch(
            SignFailed::NAME,
            new SignFailed(
                Support::$config->get('event.driver'),
                Support::$config->get('event.method'),
                $this->getData(),
                'Signature verification error'
            )
        );
    }

    /**
     * setData
     *
     * @param $data
     */
    protected function setData($data)
    {
        $this->data = $data;
    }

    /**
     * getData
     *
     * @return mixed
     */
    protected function getData()
    {
        return $this->data;
    }

    /**
     * getMessage
     *
     * @return array
     */
    protected function getRequset()
    {
        if (is_null($this->data)) {
            $request = Request::createFromGlobals();

            $this->data = $request->request->count() > 0 ? $request->request->all()
                : $request->query->all();
        }

        return $this->data;
    }

    /**
     * notifyVerify
     *
     * @param $partner
     * @param $notify_id
     *
     * @return bool|false|string
     */
    public function notifyVerify($partner, $notify_id)
    {
        $res = file_get_contents(
            "https://mapi.alipay.com/gateway.do?service=notify_verify&partner={$partner}&notify_id={$notify_id}"
        );

        if ($res === true) {
            return true;
        }

        return $res;
    }
}
