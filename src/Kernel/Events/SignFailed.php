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
     * Error
     *
     * @var string
     */
    public $error;

    /**
     * SignFailed constructor.
     *
     * @param  string|null  $driver
     * @param  string|null  $method
     * @param  array        $result
     * @param  string       $error
     */
    public function __construct($driver, $method, array $result, string $error = null)
    {
        $this->result = $result;
        $this->error  = $error;

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
