<?php
/**
 * IPP Project II.
 * @brief IPPCode24 language interpreter
 * @package IPP\Student\Exception
 * @file StringOperationErrorException.php
 * @author Vaclav Pribyl <xpriby22@stud.fit.vutbr.cz>
 * @date 14-04-2024
 */
namespace IPP\Student\Exception;

use IPP\Core\Exception\IPPException;
use IPP\Core\ReturnCode;

/**
 * Exception thrown when an invalid string operation is executed
 */
class StringOperationErrorException extends IPPException {
    public function __construct(?\Throwable $previous = null, bool $showTrace = true) {
        parent::__construct("Tried to execute invalid string operation", ReturnCode::STRING_OPERATION_ERROR, $previous, $showTrace);
    }
}
