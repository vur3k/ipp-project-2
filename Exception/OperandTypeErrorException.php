<?php

namespace IPP\Student\Exception;

use IPP\Core\Exception\IPPException;
use IPP\Core\ReturnCode;

class OperandTypeErrorException extends IPPException {
    public function __construct(?\Throwable $previous = null, bool $showTrace = true) {
        parent::__construct("Invalid parameter type passed", ReturnCode::OPERAND_TYPE_ERROR, $previous, $showTrace);
    }
}
