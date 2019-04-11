<?php

namespace WannanBigPig\Alipay\Kernel\Exceptions;

use WannanBigPig\Supports\Exceptions\BusinessException;

class SignException extends BusinessException
{
    /**
     * SignException constructor.
     *
     * @param       $message
     * @param array $raw
     */
    public function __construct($message, $raw = [])
    {
        parent::__construct('-SIGN_ERROR: ' . $message, $raw);
    }
}
