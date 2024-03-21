<?php

namespace IPP\Student\Exception;

use IPP\Core\Exception\IPPException;
use IPP\Core\ReturnCode;

/** 58 */
class StringOperationErrorException extends IPPException
{
    public function __construct(?\Throwable $previous = null, bool $showTrace = true) {
        parent::__construct("Tried to execute invalid string operation", ReturnCode::STRING_OPERATION_ERROR, $previous, $showTrace);
    }
}
