<?php
/**
 * PosTest.php
 *
 * Created by PhpStorm.
 *
 * author: liuml  <liumenglei0211@163.com>
 * DateTime: 2019-04-09  16:00
 */

namespace WannanBigPig\Alipay\Tests\payment;


use PHPUnit\Framework\TestCase;
use WannanBigPig\Alipay\Alipay;
use WannanBigPig\Supports\Str;

class PosTest extends TestCase
{
    public function testAppclication()
    {
        $result = Alipay::payment([
            'app_id'         => '2016092600598145',
            'app_auth_token' => '',
            'notify_url'     => 'http://wannanbigpig.cn/notify.php',
            'return_url'     => 'http://wannanbigpig.cn/return.php',
            'ali_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEApN8Lzs5UAIel8MJRFCgxPf0fZIjkT+qAdodHvxSeXba7Dy5DKFScG2Tre2Cvr99H3Jf516X3n1N+BxRgq3lgnG6q79rGZjRWSeOWwkDUmJ4/cVgw6G5Y+JesAbYdGKxQESXUIA0/xEQm8klt2SE7gazm4O1jduKhfy53PCImRVrLW5jXlUykyblOIXQy4gzVo7UhSeBafRBR3DhO979yztcJJc7JWXui/bHm3Axm68Da4C1Fk44OMgD4VEU0kS8aeE3nrWX/JBMhduZZx4JTSs2299uMncEI6NsNKLgovuffspcAqUO6hwU3J7ygSdVpBjbULLkiL6DSOVopZOn6FQIDAQAB',
            // 加密方式： **RSA2**
            'private_key'    => 'MIIEpQIBAAKCAQEA5faX0bBSs+UgsMvbfV+Hop1aoduJ0X9Qw9AXhWZ2XX2SsyFvE94V9dWxPnGYi54tnVYrxnAsd4fT9njFfO5NaldUghC5X/3C6QymuixPFbEb5bGugxmjdhy0BO9mI6hjnJvio/oFabvZWD8doxDi1MqpM8eguo+wqwd1GnxuZxrYvNsPyfnPRC6o3YNIBkfAH/rt71MUH8H4uDx4SkRE+aPfOZtartUM7++z464wM+BA/sD03pRMcS3nMWHWYeYdn9CHL128DsOTOKKlJB11xLfOhjfK0M0RpCG7jEBiBEvc+cl+9NqvqhT9BsgMPGWinUlDIrLF1jsxKcdlf+PMQwIDAQABAoIBAQDDgJUpa6Gj1tOn+merep+xG92FZUMRnA9pqWuVubo/WRZyu6XXWiOJUBbTY3ewmtVkwXGNzqe/JvaIv7wFrgKauYva16UBepdN0bec5zaE1oFFEX2vbwiMzXIuD+jhv7KP3eccSN55OX5Zi68ChsSQ64pVvw1iDe7AOCLSVZ72fzvMm4PyJIYuAQ3G3UkP9peNGT59fI7PV4xe078KLQwmuxM26Jzrf2n6/rYjwinW+g8626csSic0/+DBo99Ru2BetClfvZ6p4Qk66UtUwhkuDd6B2K5o0F9uQD1UcNdvuU/VOIRZ6Co8B7BOFggHQxZt8JU7NJT18OcA0mDramFhAoGBAPccLwmcVhOEH1F5YDcVRzgaRH5DI7dh9qkcW0c3OU4mMRuZMVCbwwyCGckTI3xY1BQOx/iKoXMq7Gm5brhaXpc6YPNKAXeMYdyvqYOBWIVCctNYp/6ChoiW90kb+qLfZxIkWvDz6fgmNCENb1dVCUEk1gyt6q9DxQgNBM1cLboFAoGBAO48fdqOtwLrkPy/J1lLIkb7EU2yIDLDrtflZRH8nsG68+dmuTwjXvKKuV6b3c4A7U6j3uDVVIRB53r/sYlyY/O9wzOSjLQSWFy8YsNcY8xIhvov03fUUY/EHHG3+h4yglHxpFL/BsoO/3od0WQtdk49zrTw3iRhqC8Fvk3TRRenAoGBAIifMnpzzztXDyGyo7mQsCGalEfiwvp+1StGnEjRhYNppjkGB7fzhnGB9NOxGyuCyS6VxYXqz7ym/LKvbUHL5QRjqHqabhk0ql6jWGt2tgRnaqjjGW6jp9IY9XucVoR6U7g6FXWmxbMHHEcx8F8uisFTpmy4M0rXgzYiTIdl8XopAoGBAN9lzCJ5d3X+jbvkSDK8eM0Uu9oesYDI7Ji5HHisafaCqBqSwhp5lJxdp4vnHywAxIbctbAhe5p17mnxgXrA0KeMh5JB1z04grGbWgWWCmNSk3fiByuz5jOpE38zpRBSDtBmhs/pI2WwgLLzaRnGY8zkuoQD5ls5VCub+CMkfQK7AoGAa0RhlQarUWymV9CemB2hj219bB9mxvhdiYgnO4FhYpBdgQZRY+EE1t88k2rbnDT0dWEt34+GqDRbI+nvUvgc8dAwlV/swgLc2glk01gK33yCufkRIJwcXb9Gb8pxB2PGLA/EGAVwluyDNWc+C3xdnCLTmFyhY0VBS4aYusOkjIc=',
            'log'            => [
                // optional
                'file'     => './logs/alipay.log',
                'level'    => 'info', // 建议生产环境等级调整为 info，开发环境为 debug
                'type'     => 'single', // optional, 可选 daily.
                'max_file' => 30, // optional, 当 type 为 daily 时有效，默认 30 天
            ],
            'http'           => [
                // optional
                'timeout'         => 5.0,
                'connect_timeout' => 5.0,
            ],
            'env'            => 'dev', // optional,设置此参数，将进入沙箱模式,默认为正式环境
        ])->pos([
            'out_trade_no' => Str::getRandomString(22),
            'total_amount' => 100,
            'scene' => "bar_code",
            'auth_code' => "282616934556261995",
            'product_code' => "FACE_TO_FACE_PAYMENT",
            'subject' => 'mac Xpro'
        ]);
        var_dump($result->toJson());
        $this->assertNotEmpty($result);
    }
}