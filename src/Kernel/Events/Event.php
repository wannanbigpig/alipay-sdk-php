<?php

namespace WannanBigPig\Alipay\Kernel\Events;

class Event extends \Symfony\Component\EventDispatcher\Event
{

    /**
     * Driver.
     *
     * @var string
     */
    public $driver;

    /**
     * Method.
     *
     * @var string
     */
    public $method;

    /**
     * Event constructor.
     *
     * @param  string|null  $driver
     * @param  string|null  $method
     */
    public function __construct($driver, $method)
    {
        $this->driver = $driver;
        $this->method = $method;
    }

    /**
     * getDriver
     *
     * @return string
     */
    public function getDriver()
    {
        return $this->driver;
    }

    /**
     * getMethod
     *
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }
}
