<?php

namespace IPP\Student\Exception;

use IPP\Core\Exception\IPPException;
use IPP\Core\ReturnCode;

class FrameAccessErrorException extends IPPException {
    public function __construct(?\Throwable $previous = null, bool $showTrace = true) {
        parent::__construct("Tried to access nonexistent frame", ReturnCode::FRAME_ACCESS_ERROR, $previous, $showTrace);
    }
}
