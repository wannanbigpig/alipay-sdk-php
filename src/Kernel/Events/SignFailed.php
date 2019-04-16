<?php

namespace WannanBigPig\Alipay\Kernel\Events;

class SignFailed extends Event
{
    /**
     * NAME
     *
     * @var string
     */
    const NAME = 'sign_failed';

    /**
     * Received data.
     *
     * @var array
     */
    public $result;

    /**
     * SignFailed constructor.
     *
     * @param  string  $driver
     * @param  string  $method
     * @param  array  $result
     */
    public function __construct(string $driver, string $method, array $result)
    {
        $this->result = $result;

        parent::__construct($driver, $method);
    }

    /**
     * getResult
     *
     * @return array
     */
    public function getResult()
    {
        return $this->result;
    }
}
