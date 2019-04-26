<?php
/**
 * Download.php
 *
 * Created by PhpStorm.
 *
 * author: liuml  <liumenglei0211@163.com>
 * DateTime: 2019-04-09  15:57
 */

namespace WannanBigPig\Alipay\Payment\Trade;

use WannanBigPig\Alipay\Kernel\Exceptions\SignException;
use WannanBigPig\Alipay\Kernel\Support\Support;
use WannanBigPig\Alipay\Payment\DoctorInterface;
use WannanBigPig\Supports\AccessData;
use WannanBigPig\Supports\Exceptions;

class Download implements DoctorInterface
{
    /**
     * alipay.data.dataservice.bill.downloadurl.query (查询对账单下载地址)
     * 为方便商户快速查账，支持商户通过本接口获取商户离线账单下载地址
     *
     * @var string
     */
    private $download = 'alipay.data.dataservice.bill.downloadurl.query';

    /**
     * exec
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
     * @DateTime 2019-04-12  11:36
     */
    public function exec(array $params): AccessData
    {
        return Support::executeApi($params, $this->download);
    }
}
