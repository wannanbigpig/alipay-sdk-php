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
use WannanBigPig\Alipay\Payment\Trade\Fund;
use WannanBigPig\Alipay\Payment\Trade\Query;
use WannanBigPig\Supports\AccessData;
use WannanBigPig\Supports\Exceptions;
use WannanBigPig\Supports\Str;

/**
 * Class Application.
 *
 * @method Response app(array $payload) app支付
 * @method AccessData create(array $payload) 统一收单交易创建接口 小程序支付
 * @method AccessData pay(array $payload) pos支付 (统一收单交易支付接口) 商户主扫
 * @method AccessData precreate(array $payload) 订单预创建
 * @method AccessData faceInit(array $payload) 扫脸支付 扫脸初始化
 * @method Response wap(array $payload) 手机站支付
 * @method Response pagePay(array $payload) pc支付
 * @method AccessData refund($params) 退款
 * @method AccessData cancel($params) 取消订单
 * @method AccessData close($params) 关闭订单
 * @method AccessData download($params) 下载对账单
 * @method AccessData settle($params) 结算
 * @method AccessData orderInfoSync($params) 订单信息同步
 * @method Query query() 查询类
 * @method Fund fund() 资金类
 *
 * @property Fund  fund  资金类
 * @property Query query 查询类
 */
class Application
{

    /**
     * Application constructor.
     */
    public function __construct()
    {
        Support::$config->set('event.driver', 'Payment');
    }

    /**
     * __get
     *
     * @param $name
     *
     * @return mixed
     *
     * @throws \WannanBigPig\Supports\Exceptions\ApplicationException
     *
     * @author   liuml  <liumenglei0211@163.com>
     * @DateTime 2019-04-28  12:10
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
     *
     * @author   liuml  <liumenglei0211@163.com>
     * @DateTime 2019-04-28  12:10
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
     *
     * @author   liuml  <liumenglei0211@163.com>
     * @DateTime 2019-04-28  12:10
     */
    public function getVariable($name)
    {
        $method = Str::studly($name);
        // 组装命名空间
        $gateway = __NAMESPACE__ . '\\Trade\\' . $method;

        if (class_exists($gateway)) {
            Support::$config->set('event.method', $name);
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
     *
     * @author   liuml  <liumenglei0211@163.com>
     * @DateTime 2019-04-28  12:10
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
     *
     * @author   liuml  <liumenglei0211@163.com>
     * @DateTime 2019-04-28  12:09
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
     * @throws \WannanBigPig\Supports\Exceptions\ApplicationException
     *
     * @author   liuml  <liumenglei0211@163.com>
     * @DateTime 2019-04-28  12:09
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
     * @throws \WannanBigPig\Supports\Exceptions\ApplicationException
     *
     * @author   liuml  <liumenglei0211@163.com>
     * @DateTime 2019-04-28  12:09
     */
    public function alipayMethod($method, $params = [])
    {
        $method = Str::studly($method);
        // 组装命名空间
        $gateway = __NAMESPACE__ . '\\Trade\\' . $method;

        if (class_exists($gateway)) {
            Support::$config->set('event.method', $method);
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
     *
     * @author   liuml  <liumenglei0211@163.com>
     * @DateTime 2019-04-28  12:09
     */
    public function make(string $gateway, $params = [])
    {
        $app = new $gateway();

        if ($app instanceof DoctorInterface) {
            return $app->exec($params);
        }

        return $app;
    }

    /**
     * verify
     *
     * @param  array|null  $data
     *
     * @return bool
     *
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     *
     * @author   liuml  <liumenglei0211@163.com>
     * @DateTime 2019-04-28  12:09
     */
    public function verify($data = null)
    {
        return Support::notifyVerify($data);
    }

    /**
     * execute
     *
     * @param $method
     * @param $params
     *
     * @return \WannanBigPig\Supports\AccessData
     *
     * @throws \WannanBigPig\Alipay\Kernel\Exceptions\SignException
     * @throws \WannanBigPig\Supports\Exceptions\BusinessException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     *
     * @author   liuml  <liumenglei0211@163.com>
     * @DateTime 2019-04-28  12:08
     */
    public function execute($method, $params)
    {
        return Support::executeApi($params, $method);
    }

    /**
     * sdkExecute
     *
     * @param $method
     * @param $params
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     *
     * @author   liuml  <liumenglei0211@163.com>
     * @DateTime 2019-04-28  12:08
     */
    public function sdkExecute($method, $params)
    {
        return Support::executeSdk($params, $method);
    }

    /**
     * pegeExecute
     *
     * @param $method
     * @param $params
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     *
     * @author   liuml  <liumenglei0211@163.com>
     * @DateTime 2019-04-28  12:09
     */
    public function pegeExecute($method, $params)
    {
        return Support::executePage($params, $method);
    }
}
