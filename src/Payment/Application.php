<?php
/**
 * Application.php
 *
 * Created by PhpStorm.
 *
 * author: liuml  <liumenglei0211@163.com>
 * DateTime: 2019-04-04  16:31
 */

namespace WannanBigPig\Alipay\Payment;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use WannanBigPig\Alipay\Kernel\Support\Support;
use WannanBigPig\Alipay\Payment\Trade\QueryTrade;
use WannanBigPig\Supports\AccessData;
use WannanBigPig\Supports\Exceptions;
use WannanBigPig\Supports\Str;

/**
 * Class Application.
 *
 * @method Response app(array $payload) app支付
 * @method AccessData miniApp(array $payload) 统一收单交易创建接口 小程序支付
 * @method AccessData pos(array $payload) pos支付 (统一收单交易支付接口) 商户主扫
 * @method AccessData precreate(array $payload) 订单预创建
 * @method AccessData faceInit(array $payload) 扫脸支付 扫脸初始化
 * @method Response wap(array $payload) 手机站支付
 * @method Response web(array $payload) pc支付
 * @method AccessData refund($params) 退款
 * @method AccessData cancel($params) 取消订单
 * @method AccessData close($params) 关闭订单
 * @method AccessData download($params) 下载对账单
 * @method QueryTrade query($params) 订单查询
 */
class Application
{
    /**
     * __call
     *
     * @param $name
     * @param $arguments
     *
     * @return mixed
     *
     * @throws Exceptions\ApplicationException
     *
     * @author   liuml  <liumenglei0211@163.com>
     * @DateTime 2019-04-12  11:14
     */
    public function __call($name, $arguments)
    {
        return $this->pay($name, ...$arguments);
    }

    /**
     * pay
     *
     * @param       $method
     * @param  array  $params
     *
     * @return mixed
     *
     * @throws Exceptions\ApplicationException
     *
     * @author   liuml  <liumenglei0211@163.com>
     * @DateTime 2019-04-12  11:14
     */
    public function pay($method, $params = [])
    {
        $method = Str::studly($method);
        // 组装命名空间
        $gateway = __NAMESPACE__.'\\Trade\\'.$method.'Trade';

        if (class_exists($gateway)) {
            $this->setMethod($method);

            return $this->make($gateway, $params);
        }

        throw new Exceptions\ApplicationException("The {$method} method doesn't exist");
    }

    /**
     * make
     *
     * @param  string  $gateway
     * @param  array  $params
     *
     * @return mixed
     *
     * @author   liuml  <liumenglei0211@163.com>
     * @DateTime 2019-04-11  17:15
     */
    public function make(string $gateway, $params = [])
    {
        $app = new $gateway();

        if ($app instanceof PayInterface) {
            return $app->pay($params);
        }

        if ($app instanceof DoctorInterface) {
            return $app->exce($params);
        }

        return $app;
    }

    /**
     * setMethod
     *
     * @param $method
     */
    public function setMethod($method)
    {
        Support::$config->set('event', [
            'driver' => 'Payment',
            'method' => $method,
        ]);
    }

    /**
     * verify
     *
     * @param $data
     *
     * @return bool
     *
     * @throws Exceptions\InvalidArgumentException
     */
    public function verify($data)
    {
        if (is_null($data)) {
            $request = Request::createFromGlobals();
            $data    = $request->request->count() > 0 ? $request->request->all()
                : $request->query->all();
        }
        $data['sign_type'] = null;
        return Support::verifySign(
            mb_convert_encoding(Support::getSignContent($data), $data['charset'], 'utf-8'),
            $data['sign']
        );
    }
}
