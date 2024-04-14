<?php
/**
 * IPP Project II.
 * @brief IPPCode24 language interpreter
 * @package IPP\Student\Exception
 * @file student/Exception/FrameAccessErrorException.php
 * @author Vaclav Pribyl <xpriby22@stud.fit.vutbr.cz>
 * @date 14-04-2024
 */
namespace IPP\Student\Exception;

use IPP\Core\Exception\IPPException;
use IPP\Core\ReturnCode;

/**
 * Exception thrown when trying to access a nonexistent frame
 */
class FrameAccessErrorException extends IPPException {
    public function __construct(?\Throwable $previous = null, bool $showTrace = true) {
        parent::__construct("Tried to access a nonexistent frame", ReturnCode::FRAME_ACCESS_ERROR, $previous, $showTrace);
    }
}
