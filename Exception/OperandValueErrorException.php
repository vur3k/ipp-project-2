<?php

namespace IPP\Student\Exception;

use IPP\Core\Exception\IPPException;
use IPP\Core\ReturnCode;

/** 57 */
class OperandValueErrorException extends IPPException
{
    public function __construct(?\Throwable $previous = null, bool $showTrace = true) {
        parent::__construct("Invalid value of argument passed", ReturnCode::OPERAND_VALUE_ERROR, $previous, $showTrace);
    }
}
