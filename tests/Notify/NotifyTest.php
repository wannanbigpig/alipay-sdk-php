<?php
/**
 * NotifyTest.php
 *
 * Created by PhpStorm.
 *
 * author: liuml  <liumenglei0211@163.com>
 * DateTime: 2019-04-18  15:06
 */

namespace WannanBigPig\Alipay\Tests\Notify;

use PHPUnit\Framework\TestCase;
use WannanBigPig\Alipay\Alipay;
use WannanBigPig\Alipay\Kernel\Events\SignFailed;
use WannanBigPig\Alipay\Notify\Application;
use WannanBigPig\Alipay\Tests\Event\Listener;
use WannanBigPig\Supports\AccessData;
use WannanBigPig\Supports\Events;

class NotifyTest extends TestCase
{
    /**
     * testAlipay
     *
     * @return Application
     *
     * @author   liuml  <liumenglei0211@163.com>
     * @DateTime 2019-04-11  10:49
     */
    public function testAlipay(): Application
    {
        Events::addListener(SignFailed::NAME, [new Listener(), 'sendDingding']);
        $notify = Alipay::notify([
            'ali_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEApN8Lzs5UAIel8MJRFCgxPf0fZIjkT+qAdodHvxSeXba7Dy5DKFScG2Tre2Cvr99H3Jf516X3n1N+BxRgq3lgnG6q79rGZjRWSeOWwkDUmJ4/cVgw6G5Y+JesAbYdGKxQESXUIA0/xEQm8klt2SE7gazm4O1jduKhfy53PCImRVrLW5jXlUykyblOIXQy4gzVo7UhSeBafRBR3DhO979yztcJJc7JWXui/bHm3Axm68Da4C1Fk44OMgD4VEU0kS8aeE3nrWX/JBMhduZZx4JTSs2299uMncEI6NsNKLgovuffspcAqUO6hwU3J7ygSdVpBjbULLkiL6DSOVopZOn6FQIDAQAB',
            'log'            => [
                // optional
                'file'     => './logs/alipay.log',
                'level'    => 'error', // 建议生产环境等级调整为 info，开发环境为 debug
                'type'     => 'daily', // optional, 可选 daily.
                'max_file' => 30, // optional, 当 type 为 daily 时有效，默认 30 天
            ],
            'env'            => 'dev', // optional,设置此参数，将进入沙箱模式,默认为正式环境
        ]);

        $this->assertNotEmpty($notify);
        return $notify;
    }

    /**
     * testNotify
     *
     * @param  \WannanBigPig\Alipay\Notify\Application  $notify
     *
     * @depends  testAlipay
     *
     * @author   liuml  <liumenglei0211@163.com>
     * @DateTime 2019-04-28  17:41
     */
    public function testNotify(Application $notify)
    {

        $this->assertTrue(true);
        $response = $notify->handle(function (AccessData $request, Application $notify) {
            // 进入此代码块则表示签名已经验证通过，如果需要验证notify_id则调用如下方法:
            if (!$notify->notifyIdVerify($request->seller_id, $request->notify_id)) {
                return $notify->fail();
            }

            // 在下面直接写业务逻辑，以支付异步通知为例
            // 使用通知里的 "外部交易号" 去自己的数据库找到订单
            // $order = Order::query(['out_tarde_no', $request->out_trade_no]);

            // if (!$order || $order->paid) { // 如果订单不存在 或者 订单已经支付过了
            //     return $notify->success(); // 告诉支付宝，我已经处理完了，或者是本地没有这个订单，不用再次通知我
            // }

            if ($request->trade_status === 'TRADE_SUCCESS') {
                // 标记订单支付成功
                // $order->pay_status = 'TRADE_SUCCESS';
                // ...
                print_r($request->get());
            }
            // 在这可以调用查询订单接口去查询支付状态
            // 然后可以执行其他操作，例如取消支付订单等
            // ...

            // 保存订单
            // $order->save();

            // 返回给支付确认收到通知消息
            return $notify->success();
        }, [
            'gmt_create'     => '2019-04-16 17:57:59',
            'charset'        => 'GBK',
            'seller_email'   => 'jopdvw3241@sandbox.com',
            'notify_time'    => '2019-04-16 17:57:59',
            'subject'        => 'mac Xpro妮可妮可妮啥的解释道ß',
            'sign'           => 'JvV9nTgXpfyCycS3+oLwz6AuIGY47+nunp4LoeSQzJCpjZgqYwo/v01VYZ4Aq2jGB70GnyoLy9EN6mM/AMHN0QrNlIaEgKi6BzEeWtD+bZxi7kNDJ3Fz9+qCZZcb62SrW2vIKfaB8nd3afBs9oEDf53rTP4tuguLWckCGee1XrK8P0bieoKnU//rZJ27z2PqkSL14s3NzBe625gsTh83MRDQ2ZIIEz12zeJQNmqhMrQWTiSj81Tp8334tTsMb2UZeBNU/HY/IzEMe54XG+X54Gse79i0LK4ExkbT37Vm8zTrureZ1j0ZK+LhHkospyRAbzNg0biEfkhn66alxpUSAw==',
            'buyer_id'       => '2088102177891684',
            'version'        => '1.0',
            'notify_id'      => '2019041600222175759091681000112258',
            'notify_type'    => 'trade_status_sync',
            'out_trade_no'   => 'lml20190416095758836999481',
            'total_amount'   => '100.00',
            'trade_status'   => 'WAIT_BUYER_PAY',
            'trade_no'       => '2019041622001491681000019160',
            'auth_app_id'    => '2016092600598145',
            'buyer_logon_id' => 'arl***@sandbox.com',
            'app_id'         => '2016092600598145',
            'sign_type'      => 'RSA2',
            'seller_id'      => '2088102177302492',
        ]);
        $response->send();
    }

    /**
     * testVerify
     *
     * @depends testAlipay
     *
     * @param  \WannanBigPig\Alipay\Notify\Application  $notify
     *
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function testVerify(Application $notify)
    {
        $res = $notify->verify([
            'gmt_create'     => '2019-04-16 17:57:59',
            'charset'        => 'GBK',
            'seller_email'   => 'jopdvw3241@sandbox.com',
            'notify_time'    => '2019-04-16 17:57:59',
            'subject'        => 'mac Xpro妮可妮可妮啥的解释道ß',
            'sign'           => 'JvV9nTgXpfyCycS3+oLwz6AuIGY47+nunp4LoeSQzJCpjZgqYwo/v01VYZ4Aq2jGB70GnyoLy9EN6mM/AMHN0QrNlIaEgKi6BzEeWtD+bZxi7kNDJ3Fz9+qCZZcb62SrW2vIKfaB8nd3afBs9oEDf53rTP4tuguLWckCGee1XrK8P0bieoKnU//rZJ27z2PqkSL14s3NzBe625gsTh83MRDQ2ZIIEz12zeJQNmqhMrQWTiSj81Tp8334tTsMb2UZeBNU/HY/IzEMe54XG+X54Gse79i0LK4ExkbT37Vm8zTrureZ1j0ZK+LhHkospyRAbzNg0biEfkhn66alxpUSAw==',
            'buyer_id'       => '2088102177891684',
            'version'        => '1.0',
            'notify_id'      => '2019041600222175759091681000112258',
            'notify_type'    => 'trade_status_sync',
            'out_trade_no'   => 'lml20190416095758836999481',
            'total_amount'   => '100.00',
            'trade_status'   => 'WAIT_BUYER_PAY',
            'trade_no'       => '2019041622001491681000019160',
            'auth_app_id'    => '2016092600598145',
            'buyer_logon_id' => 'arl***@sandbox.com',
            'app_id'         => '2016092600598145',
            'sign_type'      => 'RSA2',
            'seller_id'      => '2088102177302492',
        ]);
        var_dump($res);
        $this->assertTrue($res);
    }
}
