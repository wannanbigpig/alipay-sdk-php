<?php
/**
 * Notify.php
 *
 * Created by PhpStorm.
 *
 * author: liuml  <liumenglei0211@163.com>
 * DateTime: 2019-04-16  17:20
 */

namespace WannanBigPig\Alipay\Notify;

use Symfony\Component\HttpFoundation\Request;
use Closure;
use WannanBigPig\Alipay\Kernel\Events\SignFailed;
use WannanBigPig\Alipay\Kernel\Support\Support;
use WannanBigPig\Supports\AccessData;
use WannanBigPig\Supports\Events;
use WannanBigPig\Supports\Logs\Log;

trait Notify
{

    /**
     * @var array
     */
    protected $data;

    /**
     * handle
     *
     * @param  \Closure  $closure
     * @param  null      $data
     * @param  bool      $verify_notify_id
     *
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function handle(Closure $closure, $data = null, $verify_notify_id = true)
    {
        $this->setData($data);
        $request = $this->getRequset();
        // 签名验证
        if (Support::notifyVerify($request->get())) {
            if ($verify_notify_id) {
                // 验证notify_id合法性
                $this->notifyIdVerify($request['seller_id'], $request['notify_id']) or $this->fail();
            }
            call_user_func($closure, $request, $this);
        } else {
            Events::dispatch(
                SignFailed::NAME,
                new SignFailed(
                    Support::$config->get('event.driver'),
                    Support::$config->get('event.method'),
                    $this->getData(),
                    'Signature verification error'
                )
            );
            $this->fail();
        }
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
     * getRequset
     *
     * @return \WannanBigPig\Supports\AccessData
     */
    protected function getRequset(): AccessData
    {
        if (is_null($this->data)) {
            $request = Request::createFromGlobals();

            $this->data = $request->request->count() > 0 ? $request->request->all()
                : $request->query->all();
        }

        return new AccessData($this->data);
    }

    /**
     * notifyIdVerify
     *
     * @param $partner
     * @param $notify_id
     *
     * @return bool
     */
    public function notifyIdVerify($partner, $notify_id)
    {
        if (Support::$config->get('env') === 'dev') {
            $res = file_get_contents(
                "https://mapi.alipaydev.com/gateway.do?service=notify_verify&partner={$partner}&notify_id={$notify_id}"
            );
        } else {
            $res = file_get_contents(
                "https://mapi.alipay.com/gateway.do?service=notify_verify&partner={$partner}&notify_id={$notify_id}"
            );
        }

        if ($res == 'true') {
            return true;
        }

        Log::error("[ Sign Failed ] 支付宝通知 notify_id 合法性校验失败 " . $res);

        return false;
    }

    /**
     * success
     *
     * @return string
     */
    public function success()
    {
        echo self::SUCCESS;
        exit;
    }

    /**
     * fail
     *
     * @return string
     */
    public function fail()
    {
        echo self::FAIL;
        exit;
    }
}
