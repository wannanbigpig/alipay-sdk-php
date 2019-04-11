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
use WannanBigPig\Alipay\Kernel\Exceptions\SignException;
use WannanBigPig\Alipay\Kernel\Support\Support;
use WannanBigPig\Alipay\Payment\Trade\QueryTrade;
use WannanBigPig\Supports\AccessData;
use WannanBigPig\Supports\Exceptions;
use WannanBigPig\Supports\Str;

/**
 * Class Application.
 *
 * @method Response app(array $payload)
 * @method AccessData miniApp(array $payload)
 * @method AccessData pos(array $payload)
 * @method AccessData precreate(array $payload)
 * @method AccessData faceInit(array $payload)
 * @method Response wap(array $payload)
 * @method Response web(array $payload)
 */
class Application implements ApplicationInterface
{
    /**
     * __call
     *
     * @param $name
     * @param $arguments
     *
     * @return mixed|Response|AccessData
     *
     * @throws Exceptions\ApplicationException
     * @throws Exceptions\InvalidArgumentException
     *
     * @author   liuml  <liumenglei0211@163.com>
     * @DateTime 2019-04-10  18:04
     */
    public function __call($name, $arguments)
    {
        return $this->pay($name, ...$arguments);
    }

    /**
     * pay
     *
     * @param       $method
     * @param array $params
     *
     * @return mixed|Response|AccessData
     *
     * @throws Exceptions\InvalidArgumentException
     *
     * @author   liuml  <liumenglei0211@163.com>
     * @DateTime 2019-04-11  17:08
     */
    public function pay($method, $params = [])
    {
        // 组装命名空间
        $gateway = __NAMESPACE__ . '\\Trade\\' . Str::studly($method) . 'Trade';

        if (class_exists($gateway)) {
            return $this->make($gateway, $params);
        }

        throw new Exceptions\InvalidArgumentException("The {$method} method doesn't exist");
    }

    /**
     * make
     *
     * @param string $gateway
     * @param array  $params
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

        return $app;
    }

    /**
     * refund  alipay.trade.refund (统一收单交易退款接口)
     * 当交易发生之后一段时间内，由于买家或者卖家的原因需要退款时，卖家可以通过退款接口将支付款退还给买家，支付宝将在收到退款请求并且验证成功之后，按照退款规则将支付款按原路退到买家帐号上。 交易超过约定时间（签约时设置的可退款时间）的订单无法进行退款 支付宝退款支持单笔交易分多次退款，多次退款需要提交原支付订单的商户订单号和设置不同的退款单号。一笔退款失败后重新提交，要采用原来的退款单号。总退款金额不能超过用户实际支付金额
     *
     * @param array $params
     *
     * @return AccessData
     *
     * @throws Exceptions\BusinessException
     * @throws Exceptions\InvalidArgumentException
     * @throws SignException
     *
     * @author   liuml  <liumenglei0211@163.com>
     * @DateTime 2019-04-11  10:39
     */
    public function refund(array $params)
    {
        $payload = Support::setBizContent($params);
        return Support::execute($payload, 'alipay.trade.refund');
    }


    /**
     * query
     *
     * @param array  $params
     * @param string $method [ pay || refund ]
     *
     * @return AccessData
     *
     * @throws Exceptions\ApplicationException
     * @throws Exceptions\BusinessException
     * @throws Exceptions\InvalidArgumentException
     * @throws SignException
     *
     * @author   liuml  <liumenglei0211@163.com>
     * @DateTime 2019-04-11  10:51
     */
    public function query(array $params, string $method = 'pay')
    {
        $findObj = new QueryTrade();
        if (!property_exists($findObj, $method)) {
            throw new Exceptions\ApplicationException("There is no such query method");
        }

        $payload                = Support::getConfig('payload');
        $payload['method']      = $findObj->{$method};
        $payload['biz_content'] = json_encode($params);
        $payload['sign']        = Support::generateSign($payload);

        return Support::requestApi(Support::getConfig('base_uri'), $payload);
    }

    /**
     * alipay.trade.cancel (统一收单交易撤销接口)
     * 支付交易返回失败或支付系统超时，调用该接口撤销交易。如果此订单用户支付失败，支付宝系统会将此订单关闭；如果用户支付成功，支付宝系统会将此订单资金退还给用户。 注意：只有发生支付系统超时或者支付结果未知时可调用撤销，其他正常支付的单如需实现相同功能请调用申请退款 API。提交支付交易后调用【查询订单 API】，没有明确的支付结果再调用【撤销订单 API】。
     *
     * @param array $params
     *
     * @return AccessData
     *
     * @throws Exceptions\BusinessException
     * @throws Exceptions\InvalidArgumentException
     * @throws SignException
     *
     * @author   liuml  <liumenglei0211@163.com>
     * @DateTime 2019-04-11  10:40
     */
    public function cancel(array $params)
    {
        $payload                = Support::getConfig('payload');
        $payload['method']      = 'alipay.trade.cancel';
        $payload['biz_content'] = json_encode($params);
        $payload['sign']        = Support::generateSign($payload);

        return Support::requestApi(Support::getConfig('base_uri'), $payload);
    }

    /**
     * alipay.trade.close (统一收单交易关闭接口)
     * 用于交易创建后，用户在一定时间内未进行支付，可调用该接口直接将未付款的交易进行关闭。
     *
     * @param array $params
     *
     * @return AccessData
     *
     * @throws Exceptions\BusinessException
     * @throws Exceptions\InvalidArgumentException
     * @throws SignException
     *
     * @author   liuml  <liumenglei0211@163.com>
     * @DateTime 2019-04-11  10:41
     */
    public function close(array $params)
    {
        $payload                = Support::getConfig('payload');
        $payload['method']      = 'alipay.trade.close';
        $payload['biz_content'] = json_encode($params);
        $payload['sign']        = Support::generateSign($payload);

        return Support::requestApi(Support::getConfig('base_uri'), $payload);
    }

    /**
     * alipay.data.dataservice.bill.downloadurl.query (查询对账单下载地址)
     * 为方便商户快速查账，支持商户通过本接口获取商户离线账单下载地址
     *
     * @param array $params
     *
     * @return AccessData
     *
     * @throws Exceptions\BusinessException
     * @throws Exceptions\InvalidArgumentException
     * @throws SignException
     *
     * @author   liuml  <liumenglei0211@163.com>
     * @DateTime 2019-04-11  14:11
     */
    public function download(array $params)
    {
        // 获取公共参数
        $payload = Support::getConfig('payload');
        // 设置方法
        $payload['method'] = 'alipay.data.dataservice.bill.downloadurl.query';
        // 设置业务参数
        $payload['biz_content'] = json_encode($params);
        // 设置签名
        $payload['sign'] = Support::generateSign($payload);
        // 请求支付宝网关
        return Support::requestApi(Support::getConfig('base_uri'), $payload);
    }
}