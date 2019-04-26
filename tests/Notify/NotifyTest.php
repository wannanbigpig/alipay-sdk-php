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
use WannanBigPig\Alipay\Notify\Application;
use WannanBigPig\Supports\AccessData;

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
        $notify = Alipay::notify([
            // 'payload'        => [
            //     'app_id'         => '2016092600598145',
            //     // 'format'         => 'JSON', // 默认JSON，请勿修改，目前支付宝仅支持JSON
            //     // 'charset'        => 'utf-8', // 默认utf-8
            //     // 'sign_type'      => 'RSA2', // 默认RSA2
            //     // 'version'        => '1.0',  // 默认1.0
            //     'return_url'     => 'http://liuml.com/return.php',
            //     'notify_url'     => 'http://liuml.com/notify.php',
            //     // 'app_auth_token' => '', // 服务商帮助子商户调用必填，自调用商户不填
            // ],
            'ali_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEApN8Lzs5UAIel8MJRFCgxPf0fZIjkT+qAdodHvxSeXba7Dy5DKFScG2Tre2Cvr99H3Jf516X3n1N+BxRgq3lgnG6q79rGZjRWSeOWwkDUmJ4/cVgw6G5Y+JesAbYdGKxQESXUIA0/xEQm8klt2SE7gazm4O1jduKhfy53PCImRVrLW5jXlUykyblOIXQy4gzVo7UhSeBafRBR3DhO979yztcJJc7JWXui/bHm3Axm68Da4C1Fk44OMgD4VEU0kS8aeE3nrWX/JBMhduZZx4JTSs2299uMncEI6NsNKLgovuffspcAqUO6hwU3J7ygSdVpBjbULLkiL6DSOVopZOn6FQIDAQAB',
            // 'private_key'    => 'MIIEpQIBAAKCAQEA5faX0bBSs+UgsMvbfV+Hop1aoduJ0X9Qw9AXhWZ2XX2SsyFvE94V9dWxPnGYi54tnVYrxnAsd4fT9njFfO5NaldUghC5X/3C6QymuixPFbEb5bGugxmjdhy0BO9mI6hjnJvio/oFabvZWD8doxDi1MqpM8eguo+wqwd1GnxuZxrYvNsPyfnPRC6o3YNIBkfAH/rt71MUH8H4uDx4SkRE+aPfOZtartUM7++z464wM+BA/sD03pRMcS3nMWHWYeYdn9CHL128DsOTOKKlJB11xLfOhjfK0M0RpCG7jEBiBEvc+cl+9NqvqhT9BsgMPGWinUlDIrLF1jsxKcdlf+PMQwIDAQABAoIBAQDDgJUpa6Gj1tOn+merep+xG92FZUMRnA9pqWuVubo/WRZyu6XXWiOJUBbTY3ewmtVkwXGNzqe/JvaIv7wFrgKauYva16UBepdN0bec5zaE1oFFEX2vbwiMzXIuD+jhv7KP3eccSN55OX5Zi68ChsSQ64pVvw1iDe7AOCLSVZ72fzvMm4PyJIYuAQ3G3UkP9peNGT59fI7PV4xe078KLQwmuxM26Jzrf2n6/rYjwinW+g8626csSic0/+DBo99Ru2BetClfvZ6p4Qk66UtUwhkuDd6B2K5o0F9uQD1UcNdvuU/VOIRZ6Co8B7BOFggHQxZt8JU7NJT18OcA0mDramFhAoGBAPccLwmcVhOEH1F5YDcVRzgaRH5DI7dh9qkcW0c3OU4mMRuZMVCbwwyCGckTI3xY1BQOx/iKoXMq7Gm5brhaXpc6YPNKAXeMYdyvqYOBWIVCctNYp/6ChoiW90kb+qLfZxIkWvDz6fgmNCENb1dVCUEk1gyt6q9DxQgNBM1cLboFAoGBAO48fdqOtwLrkPy/J1lLIkb7EU2yIDLDrtflZRH8nsG68+dmuTwjXvKKuV6b3c4A7U6j3uDVVIRB53r/sYlyY/O9wzOSjLQSWFy8YsNcY8xIhvov03fUUY/EHHG3+h4yglHxpFL/BsoO/3od0WQtdk49zrTw3iRhqC8Fvk3TRRenAoGBAIifMnpzzztXDyGyo7mQsCGalEfiwvp+1StGnEjRhYNppjkGB7fzhnGB9NOxGyuCyS6VxYXqz7ym/LKvbUHL5QRjqHqabhk0ql6jWGt2tgRnaqjjGW6jp9IY9XucVoR6U7g6FXWmxbMHHEcx8F8uisFTpmy4M0rXgzYiTIdl8XopAoGBAN9lzCJ5d3X+jbvkSDK8eM0Uu9oesYDI7Ji5HHisafaCqBqSwhp5lJxdp4vnHywAxIbctbAhe5p17mnxgXrA0KeMh5JB1z04grGbWgWWCmNSk3fiByuz5jOpE38zpRBSDtBmhs/pI2WwgLLzaRnGY8zkuoQD5ls5VCub+CMkfQK7AoGAa0RhlQarUWymV9CemB2hj219bB9mxvhdiYgnO4FhYpBdgQZRY+EE1t88k2rbnDT0dWEt34+GqDRbI+nvUvgc8dAwlV/swgLc2glk01gK33yCufkRIJwcXb9Gb8pxB2PGLA/EGAVwluyDNWc+C3xdnCLTmFyhY0VBS4aYusOkjIc=',
            'log'            => [
                // optional
                'file'     => './logs/alipay.log',
                'level'    => 'error', // 建议生产环境等级调整为 info，开发环境为 debug
                'type'     => 'daily', // optional, 可选 daily.
                'max_file' => 30, // optional, 当 type 为 daily 时有效，默认 30 天
            ],
            // 'http'           => [
            //     // optional
            //     'timeout'         => 5.0,
            //     'connect_timeout' => 5.0,
            // ],
            'env'            => 'dev', // optional,设置此参数，将进入沙箱模式,默认为正式环境
            /**
             * 业务返回处理
             * 设置true， 返回码 10000 则正常返回成功数据，其他的则抛出业务异常
             * 捕获 BusinessException 异常 获取 raw 元素查看完整数据并做处理
             * 不设置默认 false
             */
            // 'business_exception' => true
        ]);

        $this->assertNotEmpty($notify);

        return $notify;
    }

    /**
     * testNotify
     *
     * @param  \WannanBigPig\Alipay\Notify\Application  $notify
     *
     * @depends testAlipay
     *
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
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
}
