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

use Symfony\Component\HttpFoundation\Response;
use WannanBigPig\Alipay\Kernel\Support\Support;
use WannanBigPig\Alipay\Payment\Trade\Query;
use WannanBigPig\Supports\AccessData;
use WannanBigPig\Supports\Exceptions;
use WannanBigPig\Supports\Str;

/**
 * Class Application.
 *
 * @method Response app(array $payload) app支付
 * @method AccessData miniApp(array $payload) 统一收单交易创建接口 小程序支付
 * @method AccessData pay(array $payload) pos支付 (统一收单交易支付接口) 商户主扫
 * @method AccessData precreate(array $payload) 订单预创建
 * @method AccessData faceInit(array $payload) 扫脸支付 扫脸初始化
 * @method Response wap(array $payload) 手机站支付
 * @method Response web(array $payload) pc支付
 * @method AccessData refund($params) 退款
 * @method AccessData cancel($params) 取消订单
 * @method AccessData close($params) 关闭订单
 * @method AccessData download($params) 下载对账单
 * @method Query query() 订单查询
 */
class Application
{

    /**
     * @var string
     */
    public $method = '';

    /**
     * __get
     *
     * @param $name
     *
     * @return mixed
     *
     * @throws \WannanBigPig\Supports\Exceptions\ApplicationException
     */
    public function __get($name)
    {
        return $this->getVariable($name);
    }

    /**
     * __set
     *
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        Support::$config->set($name, $value);
    }

    /**
     * getVariable
     *
     * @param $name
     *
     * @return mixed
     *
     * @throws \WannanBigPig\Supports\Exceptions\ApplicationException
     */
    public function getVariable($name)
    {
        $method = Str::studly($name);
        // 组装命名空间
        $gateway = __NAMESPACE__ . '\\Trade\\' . $method;

        if (class_exists($gateway)) {
            $this->setMethod();
            return $this->make($gateway);
        }

        throw new Exceptions\ApplicationException("The {$method}  member variable doesn't exist");
    }

    /**
     * get
     *
     * @param $name
     *
     * @return array|mixed|null
     */
    public function get($name)
    {
        return Support::$config->get($name, '');
    }

    /**
     * set
     *
     * @param $name
     * @param $value
     */
    public function set($name, $value)
    {
        Support::$config->set($name, $value);
    }

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
        return $this->alipayMethod($name, ...$arguments);
    }

    /**
     * alipayMethod
     *
     * @param         $method
     * @param  array  $params
     *
     * @return mixed
     *
     * @throws Exceptions\ApplicationException
     */
    public function alipayMethod($method, $params = [])
    {
        $method = Str::studly($method);
        // 组装命名空间
        $gateway = __NAMESPACE__ . '\\Trade\\' . $method;

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
     * @param  array   $params
     *
     * @return mixed
     */
    public function make(string $gateway, $params = [])
    {
        $app = new $gateway();

        if ($app instanceof PayInterface) {
            return $app->pay($params);
        }

        if ($app instanceof DoctorInterface) {
            return $app->exec($params);
        }

        return $app;
    }

    /**
     * setMethod
     *
     * @param  string  $method
     */
    public function setMethod($method = '')
    {
        Support::$config->set('event', [
            'driver' => 'Payment',
            'method' => $method ? : $this->method,
        ]);
    }

    /**
     * verify
     *
     * @param  null  $data
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
