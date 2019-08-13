<?php
/*
 * This file is part of the wannanbigpig/alipay-sdk-php.
 *
 * (c) wannanbigpig <liuml0211@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyAlipay\miniProgram\Version;

use EasyAlipay\Kernel\Support\Support;

class Client extends Support
{
    /**
     * alipay.open.mini.version.gray.cancel(小程序结束灰度).
     *
     * @param string $appVersion
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|\WannanBigPig\Supports\Collection|\WannanBigPig\Supports\Http\Response
     *
     * @throws \EasyAlipay\Kernel\Exceptions\InvalidSignException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function grayCancel(string $appVersion)
    {
        $method = 'alipay.open.mini.version.gray.cancel';
        $params = [
            'app_version' => $appVersion,
        ];

        return $this->request($method, [
            'biz_content' => $params,
        ]);
    }

    /**
     * alipay.open.mini.version.delete(小程序删除版本).
     *
     * @param string $appVersion
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|\WannanBigPig\Supports\Collection|\WannanBigPig\Supports\Http\Response
     *
     * @throws \EasyAlipay\Kernel\Exceptions\InvalidSignException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function delete(string $appVersion)
    {
        $method = 'alipay.open.mini.version.delete';
        $params = [
            'app_version' => $appVersion,
        ];

        return $this->request($method, [
            'biz_content' => $params,
        ]);
    }

    /**
     * alipay.open.mini.version.upload(小程序基于模板上传版本).
     *
     * @param string      $templateId
     * @param string      $appVersion
     * @param string|null $templateVersion
     * @param string|null $ext
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|\WannanBigPig\Supports\Collection|\WannanBigPig\Supports\Http\Response
     *
     * @throws \EasyAlipay\Kernel\Exceptions\InvalidSignException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function upload(string $templateId, string $appVersion, string $templateVersion = null, string $ext = null)
    {
        $method = 'alipay.open.agent.create';
        $params = array_filter([
            'template_version' => $templateVersion,
            'ext' => $ext,
            'template_id' => $templateId,
            'app_version' => $appVersion,
        ], function ($value) {
            return !($this->checkEmpty($value));
        });

        return $this->request($method, [
            'biz_content' => $params,
        ]);
    }

    /**
     * alipay.open.mini.version.gray.online(小程序灰度上架).
     *
     * @param string $appVersion
     * @param string $grayStrategy
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|\WannanBigPig\Supports\Collection|\WannanBigPig\Supports\Http\Response
     *
     * @throws \EasyAlipay\Kernel\Exceptions\InvalidSignException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function grayOnline(string $appVersion, string $grayStrategy)
    {
        $method = 'alipay.open.mini.version.delete';
        $params = [
            'app_version' => $appVersion,
            'gray_strategy' => $grayStrategy,
        ];

        return $this->request($method, [
            'biz_content' => $params,
        ]);
    }

    /**
     * alipay.open.mini.version.build.query(小程序查询版本构建状态).
     *
     * @param string $appVersion
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|\WannanBigPig\Supports\Collection|\WannanBigPig\Supports\Http\Response
     *
     * @throws \EasyAlipay\Kernel\Exceptions\InvalidSignException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function buildQuery(string $appVersion)
    {
        $method = 'alipay.open.mini.version.build.query';
        $params = [
            'app_version' => $appVersion,
        ];

        return $this->request($method, [
            'biz_content' => $params,
        ]);
    }

    /**
     * alipay.open.mini.version.audited.cancel(小程序退回开发).
     *
     * @param string $appVersion
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|\WannanBigPig\Supports\Collection|\WannanBigPig\Supports\Http\Response
     *
     * @throws \EasyAlipay\Kernel\Exceptions\InvalidSignException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function cancelAudited(string $appVersion)
    {
        $method = 'alipay.open.mini.version.audited.cancel';
        $params = [
            'app_version' => $appVersion,
        ];

        return $this->request($method, [
            'biz_content' => $params,
        ]);
    }

    /**
     * alipay.open.mini.version.offline(小程序下架).
     *
     * @param string $appVersion
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|\WannanBigPig\Supports\Collection|\WannanBigPig\Supports\Http\Response
     *
     * @throws \EasyAlipay\Kernel\Exceptions\InvalidSignException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function offline(string $appVersion)
    {
        $method = 'alipay.open.mini.version.offline';
        $params = [
            'app_version' => $appVersion,
        ];

        return $this->request($method, [
            'biz_content' => $params,
        ]);
    }

    /**
     * alipay.open.mini.version.list.query(小程序版本列表查询).
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|\WannanBigPig\Supports\Collection|\WannanBigPig\Supports\Http\Response
     *
     * @throws \EasyAlipay\Kernel\Exceptions\InvalidSignException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function getList()
    {
        $method = 'alipay.open.mini.version.list.query';
        $params = [];

        return $this->request($method, [
            'biz_content' => $params,
        ]);
    }

    /**
     * alipay.open.mini.experience.create(小程序生成体验版).
     *
     * @param string $appVersion
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|\WannanBigPig\Supports\Collection|\WannanBigPig\Supports\Http\Response
     *
     * @throws \EasyAlipay\Kernel\Exceptions\InvalidSignException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function createExperience(string $appVersion)
    {
        $method = 'alipay.open.mini.experience.create';
        $params = [
            'app_version' => $appVersion,
        ];

        return $this->request($method, [
            'biz_content' => $params,
        ]);
    }

    /**
     * alipay.open.mini.experience.cancel(小程序取消体验版).
     *
     * @param string $appVersion
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|\WannanBigPig\Supports\Collection|\WannanBigPig\Supports\Http\Response
     *
     * @throws \EasyAlipay\Kernel\Exceptions\InvalidSignException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function cancelExperience(string $appVersion)
    {
        $method = 'alipay.open.mini.experience.cancel';
        $params = [
            'app_version' => $appVersion,
        ];

        return $this->request($method, [
            'biz_content' => $params,
        ]);
    }

    /**
     * alipay.open.mini.experience.query(小程序体验版状态查询接口).
     *
     * @param string $appVersion
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|\WannanBigPig\Supports\Collection|\WannanBigPig\Supports\Http\Response
     *
     * @throws \EasyAlipay\Kernel\Exceptions\InvalidSignException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function queryExperience(string $appVersion)
    {
        $method = 'alipay.open.mini.experience.query';
        $params = [
            'app_version' => $appVersion,
        ];

        return $this->request($method, [
            'biz_content' => $params,
        ]);
    }

    /**
     * alipay.open.mini.version.online(小程序上架).
     *
     * @param string $appVersion
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|\WannanBigPig\Supports\Collection|\WannanBigPig\Supports\Http\Response
     *
     * @throws \EasyAlipay\Kernel\Exceptions\InvalidSignException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function online(string $appVersion)
    {
        $method = 'alipay.open.mini.version.online';
        $params = [
            'app_version' => $appVersion,
        ];

        return $this->request($method, [
            'biz_content' => $params,
        ]);
    }

    /**
     * alipay.open.mini.version.detail.query(小程序版本详情查询).
     *
     * @param string $appVersion
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|\WannanBigPig\Supports\Collection|\WannanBigPig\Supports\Http\Response
     *
     * @throws \EasyAlipay\Kernel\Exceptions\InvalidSignException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function getDetail(string $appVersion)
    {
        $method = 'alipay.open.mini.version.detail.query';
        $params = [
            'app_version' => $appVersion,
        ];

        return $this->request($method, [
            'biz_content' => $params,
        ]);
    }

    /**
     * alipay.open.mini.version.rollback(小程序回滚).
     *
     * @param string $appVersion
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|\WannanBigPig\Supports\Collection|\WannanBigPig\Supports\Http\Response
     *
     * @throws \EasyAlipay\Kernel\Exceptions\InvalidSignException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function rollback(string $appVersion)
    {
        $method = 'alipay.open.mini.version.rollback';
        $params = [
            'app_version' => $appVersion,
        ];

        return $this->request($method, [
            'biz_content' => $params,
        ]);
    }

    /**
     * alipay.open.mini.version.audit.apply(小程序提交审核).
     *
     * @param array $params
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|\WannanBigPig\Supports\Collection|\WannanBigPig\Supports\Http\Response
     *
     * @throws \EasyAlipay\Kernel\Exceptions\InvalidSignException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WannanBigPig\Supports\Exceptions\InvalidArgumentException
     */
    public function submitAudit(array $params)
    {
        $method = 'alipay.open.mini.version.rollback';
        
        return $this->request($method, [
            'biz_content' => $params,
        ]);
    }
}
