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
use WannanBigPig\Supports\Exceptions\InvalidArgumentException;
use WannanBigPig\Supports\Str;

/**
 * Class Application.
 *
 * @method Response app(array $attributes)
 */
class Application implements GatewaysInterface
{
    /**
     * __call
     *
     * @param $name
     * @param $arguments
     *
     * @return mixed|void
     *
     * @throws InvalidArgumentException
     *
     * @author   liuml  <liumenglei0211@163.com>
     * @DateTime 2019-04-08  11:15
     */
    public function __call($name, $arguments)
    {
        return $this->pay($name, ...$arguments);
    }

    /**
     * pay
     *
     * @param       $gateway
     * @param array $params
     *
     * @return mixed|void
     *
     * @throws InvalidArgumentException
     *
     * @author   liuml  <liumenglei0211@163.com>
     * @DateTime 2019-04-08  11:15
     */
    public function pay($gateway, $params = [])
    {
        // 设置业务参数
        Support::$config->set('payload.biz_content', json_encode($params));

        // 组装命名空间
        $gateway = __NAMESPACE__ . '\\Trade\\' . Str::studly($gateway) . 'Trade';

        if (class_exists($gateway)) {
            return $this->makePay($gateway);
        }

        throw new InvalidArgumentException("Pay Gateway [{$gateway}] not exists");
    }

    /**
     * makePay
     *
     * @param $gateway
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     *
     * @author   liuml  <liumenglei0211@163.com>
     * @DateTime 2019-04-08  11:37
     */
    public function makePay($gateway)
    {
        $app = new $gateway();

        if ($app instanceof PayInterface) {
            return $app->pay(Support::getConfig('base_uri'), array_filter(Support::getConfig('payload'), function($value) {
                return $value !== '' && !is_null($value);
            }));
        }

        throw new InvalidArgumentException("Pay Gateway [{$gateway}] Must Be An Instance Of PayInterface");
    }

    public function refund($order)
    {
        // TODO: Implement refund() method.
    }
}