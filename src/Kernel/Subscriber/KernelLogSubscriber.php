<?php
/*
 * This file is part of the wannanbigpig/alipay.
 *
 * (c) wannanbigpig <liuml0211@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace WannanBigPig\Alipay\Kernel\Subscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class KernelLogSubscriber implements EventSubscriberInterface
{
    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     * The method name to call (priority defaults to 0)
     * An array composed of the method name to call and the priority
     * An array of arrays composed of the method names to call and respective
     * priorities, or 0 if unset
     *
     * For instance:
     *
     * array('eventName' => 'methodName')
     * array('eventName' => array('methodName', $priority))
     * array('eventName' => array(array('methodName1', $priority), array('methodName2')))
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return [
            Events\ApiRequestStart::NAME => ['writeApiRequestStartLog', 256],
            Events\ApiRequestEnd::NAME => ['writeApiRequestEndLog', 256],
            Events\SignFailed::NAME => ['writeSignFailedLog', 256],
        ];
    }
}
