<?php
/*
 * This file is part of the wannanbigpig/alipay.
 *
 * (c) wannanbigpig <liuml0211@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace WannanBigPig\Alipay;

use WannanBigPig\Alipay\Kernel\Exceptions\ApplicationException;
use WannanBigPig\Supports\Str;

/**
 * Class Alipay
 *
 * @method static \WannanBigPig\Alipay\Payment\Application payment(array $config)
 *
 * @author   liuml  <liumenglei0211@163.com>
 * @DateTime 2019-07-15  11:46
 *
 * @package  WannanBigPig\Alipay
 */
class Alipay
{
    /**
     * make.
     *
     * @param       $name
     * @param array $config
     *
     * @return mixed
     *
     * @throws \WannanBigPig\Alipay\Kernel\Exceptions\ApplicationException
     */
    public static function make($name, array $config)
    {
        $namespace = Str::studly($name);
        $application = __NAMESPACE__."\\{$namespace}\\Application";

        if (class_exists($application)) {
            // Instantiation application
            return new $application($config);
        }
        throw new ApplicationException("Application [{$name}] does not exist");
    }

    /**
     * Dynamically pass methods to the application.
     *
     * @param $name
     * @param $arguments
     *
     * @return mixed
     *
     * @throws \WannanBigPig\Alipay\Kernel\Exceptions\ApplicationException
     */
    public static function __callStatic($name, $arguments)
    {
        return self::make($name, ...$arguments);
    }
}
