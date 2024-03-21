<?php

namespace IPP\Student\Exception;

use IPP\Core\Exception\IPPException;
use IPP\Core\ReturnCode;

class VariableAccessErrorException extends IPPException {
    public function __construct(?\Throwable $previous = null, bool $showTrace = true) {
        parent::__construct("Tried to access nonexistent variable", ReturnCode::VARIABLE_ACCESS_ERROR, $previous, $showTrace);
    }
}
