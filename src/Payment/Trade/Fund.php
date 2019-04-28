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

use Symfony\Component\HttpFoundation\Response;
use WannanBigPig\Alipay\Kernel\Support\Support;
use WannanBigPig\Supports\AccessData;

class Fund
{
    /**
     * @var string
     */
    protected $method = '';

    /**
     * Query constructor.
     */
    public function __construct()
    {
        $this->method = Support::$config->get('event.method');
    }

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
        Support::$config->set('event.method', $this->method.'->transfer');
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
        Support::$config->set('event.method', $this->method.'->fundAuthOrderVoucherCreate');
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
        Support::$config->set('event.method', $this->method.'->fundAuthOperationCancel');
        return Support::executeApi($params, 'alipay.fund.auth.order.voucher.create');
    }

    /**
     * alipay.fund.auth.order.unfreeze (资金授权解冻接口) 在线调试（沙箱环境）
     * 当资金授权发生之后一段时间内，由于买家或者商家等其他原因需要要解冻资金，商家可通过资金授权解冻接口将授权资金进行解冻，支付宝将在收到解冻请求并验证成功后，按解冻规则将冻结资金按原路进行解冻
     *
     * @param $params
     *
     * @return \WannanBigPig\Supports\AccessData
     *
     * @throws \WannanBigPig\Alipay\Kernel\Exceptions\SignException
     * @throws \WannanBigPig\Supports\Exceptions\BusinessException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function fundAuthUnfreeze($params)
    {
        Support::$config->set('event.method', $this->method.'->fundAuthUnfreeze');
        return Support::executeApi($params, 'alipay.fund.auth.order.unfreeze');
    }

    /**
     * alipay.fund.auth.order.freeze (资金授权冻结接口) 在线调试（沙箱环境）
     * 收银员使用扫码设备读取用户支付宝钱包 “付款码” 后，将条码信息和订单信息通过本接口上送至支付宝发起资金冻结。
     *
     * @param $params
     *
     * @return \WannanBigPig\Supports\AccessData
     *
     * @throws \WannanBigPig\Alipay\Kernel\Exceptions\SignException
     * @throws \WannanBigPig\Supports\Exceptions\BusinessException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function fundAuthFreeze($params)
    {
        Support::$config->set('event.method', $this->method.'->fundAuthFreeze');
        return Support::executeApi($params, 'alipay.fund.auth.order.freeze');
    }

    /**
     * alipay.fund.auth.order.app.freeze (线上资金授权冻结接口) 在线调试（沙箱环境）
     * 创建支付宝授权订单并完成资金冻结。适用于线上场景完成资金授权，例如从商户 APP 端拉起支付宝收银台完成冻结。
     *
     * @param $params
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     *
     */
    public function fundAuthAppFreeze($params):Response
    {
        Support::$config->set('event.method', $this->method.'->fundAuthAppFreeze');
        return Support::executeSdk($params, 'alipay.fund.auth.order.app.freeze');
    }
}
