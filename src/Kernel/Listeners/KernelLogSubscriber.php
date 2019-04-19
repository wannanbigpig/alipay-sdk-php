<?php

namespace WannanBigPig\Alipay\Kernel\Listeners;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use WannanBigPig\Alipay\Kernel\Events;
use WannanBigPig\Supports\Logs\Log;

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
            Events\ApiRequestEnd::NAME   => ['writeApiRequestEndLog', 256],
            Events\SignFailed::NAME      => ['writeSignFailedLog', 256],
        ];
    }

    /**
     * writeApiRequestStartLog
     *
     * @param  Events\ApiRequestStart  $event
     */
    public function writeApiRequestStartLog(Events\ApiRequestStart $event)
    {
        Log::debug(
            "[ Request Start ] Alipay::{$event->getDriver()}()->{$event->getMethod()}() ",
            [
                'URI'            => $event->getUri(),
                'request params' => $event->getRequest(),
            ]
        );
    }

    /**
     * writeApiRequestEndLog
     *
     * @param  Events\ApiRequestEnd  $event
     */
    public function writeApiRequestEndLog(Events\ApiRequestEnd $event)
    {
        Log::debug(
            "[ Request End ] Alipay::{$event->getDriver()}()->{$event->getMethod()}() ",
            [
                'URI'            => $event->getUri(),
                'request params' => $event->getRequest(),
                'result'         => $event->getResult(),
            ]
        );
    }

    /**
     * writeSignFailedLog
     *
     * @param  Events\SignFailed  $event
     */
    public function writeSignFailedLog(Events\SignFailed $event)
    {
        Log::error(
            "[ Sign Failed ] Alipay::{$event->getDriver()}()->{$event->getMethod()}() error:[{$event->error}] ",
            [$event->getResult()]
        );
    }
}
