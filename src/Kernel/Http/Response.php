<?php
/*
 * This file is part of the wannanbigpig/alipay.
 *
 * (c) wannanbigpig <liuml0211@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace WannanBigPig\Alipay\Kernel\Http;

/**
 * Class Response
 *
 * @author   liuml  <liumenglei0211@163.com>
 * @DateTime 2019-07-20  15:00
 */
class Response extends \WannanBigPig\Supports\Http\Response
{
    public function toArray()
    {
        if(!empty($this->array)){
            return $this->array;
        }

        $content = $this->getBodyContents();
        $array = \GuzzleHttp\json_decode($content, true, 512, JSON_BIGINT_AS_STRING);

        if (JSON_ERROR_NONE === json_last_error()) {
            return (array) $array;
        }

        return [];
    }
}