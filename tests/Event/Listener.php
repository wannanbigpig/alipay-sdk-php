<?php
/**
 * Listener.php
 *
 * Created by PhpStorm.
 *
 * author: liuml  <liumenglei0211@163.com>
 * DateTime: 2019-04-28  16:34
 */

namespace WannanBigPig\Alipay\Tests\Event;

use WannanBigPig\Alipay\Kernel\Events\SignFailed;
use WannanBigPig\Alipay\Kernel\Support\Support;

class Listener
{
    public function sendDingding(SignFailed $event)
    {
        $webhook = "https://oapi.dingtalk.com/robot/send?access_token=xxxxxxxx";

        $data = [
            'msgtype' => 'text',
            'text'    => [
                'content' => $event->error
            ]
        ];

        // 将错误信息通知到我的钉钉
        Support::getInstance()->post($webhook, $data, ['request_type'=>'json']);
    }
}
