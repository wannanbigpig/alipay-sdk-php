<?php
/**
 * Fund.php
 *
 * Created by PhpStorm.
 *
 * author: liuml  <liumenglei0211@163.com>
 * DateTime: 2019-04-20  10:28
 */

namespace WannanBigPig\Alipay\Payment\Trade;

use WannanBigPig\Alipay\Kernel\Support\Support;
use WannanBigPig\Supports\AccessData;

class Fund
{

    /**
     * alipay.fund.trans.toaccount.transfer (单笔转账到支付宝账户接口)
     * 单笔转账到支付宝账户接口是基于支付宝的资金处理能力，为了满足支付宝商家向其他支付宝账户转账的需求，针对有部分开发能力的商家，
     * 提供通过 API 接口完成支付宝账户间的转账的功能。 该接口适用行业较广，比如商家间的货款结算，商家给个人用户发放佣金等。
     *
     * @param $params
     *
     * @return \WannanBigPig\Supports\AccessData
     *
     * @throws \WannanBigPig\Alipay\Kernel\Exceptions\SignException
     * @throws \WannanBigPig\Supports\Exceptions\BusinessException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function transfer($params): AccessData
    {
        return Support::executeApi($params, 'alipay.fund.trans.toaccount.transfer');
    }

    /**
     * alipay.fund.auth.order.voucher.create (资金授权发码接口) 在线调试（沙箱环境）
     * 收银员通过收银台或商户后台调用支付宝接口，生成二维码后，展示给用户，由用户扫描二维码完成资金冻结。
     *
     * @param $params
     *
     * @return \WannanBigPig\Supports\AccessData
     *
     * @throws \WannanBigPig\Alipay\Kernel\Exceptions\SignException
     * @throws \WannanBigPig\Supports\Exceptions\BusinessException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function fundAuthOrderVoucherCreate($params): AccessData
    {
        return Support::executeApi($params, 'alipay.fund.auth.order.voucher.create');
    }

    /**
     * alipay.fund.auth.operation.cancel (资金授权撤销接口)
     * 只有商户由于业务系统处理超时需要终止后续业务处理或者授权结果未知时可调用撤销，其他正常授权冻结的操作如需实现相同功能请调用资金授权解冻服务。提交资金授权后调用【资金授权操作查询】，没有明确的授权结果再调用【资金授权撤销】
     *
     * @param $params
     *
     * @return \WannanBigPig\Supports\AccessData
     *
     * @throws \WannanBigPig\Alipay\Kernel\Exceptions\SignException
     * @throws \WannanBigPig\Supports\Exceptions\BusinessException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function fundAuthOperationCancel($params)
    {
        return Support::executeApi($params, 'alipay.fund.auth.order.voucher.create');
    }
}
