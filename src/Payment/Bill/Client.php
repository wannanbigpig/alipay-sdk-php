<?php
/*
 * This file is part of the wannanbigpig/alipay.
 *
 * (c) wannanbigpig <liuml0211@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyAlipay\Payment\Bill;

use EasyAlipay\Payment\Kernel\BaseClient;

/**
 * Class Client
 *
 * @author   liuml  <liumenglei0211@163.com>
 * @DateTime 2019-07-22  14:36
 */
class Client extends BaseClient
{
    /**
     * alipay.data.dataservice.bill.downloadurl.query(查询对账单下载地址).
     *
     * @param string $billType
     * @param string $billDate
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|\WannanBigPig\Supports\Collection|\WannanBigPig\Supports\Http\Response
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \EasyAlipay\Kernel\Exceptions\InvalidSignException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function get(string $billType, string $billDate)
    {
        $method = 'alipay.data.dataservice.bill.downloadurl.query';

        return $this->request($method, [
            'biz_content' => [
                'bill_type' => $billType,
                'bill_date' => $billDate,
            ],
        ]);
    }
}
