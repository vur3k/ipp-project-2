<?php

namespace IPP\Student\Exception;

use IPP\Core\Exception\IPPException;
use IPP\Core\ReturnCode;

class SemanticErrorException extends IPPException {
    public function __construct(?\Throwable $previous = null, bool $showTrace = true) {
        parent::__construct("Expression has invalid syntax", ReturnCode::SEMANTIC_ERROR, $previous, $showTrace);
    }
}
