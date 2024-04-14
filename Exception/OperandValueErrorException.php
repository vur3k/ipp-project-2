<?php
/**
 * IPP Project II.
 * @brief IPPCode24 language interpreter
 * @package IPP\Student\Exception
 * @file OperandValueErrorException.php
 * @author Vaclav Pribyl <xpriby22@stud.fit.vutbr.cz>
 * @date 14-04-2024
 */
namespace IPP\Student\Exception;

use IPP\Core\Exception\IPPException;
use IPP\Core\ReturnCode;

/**
 * Exception thrown when an invalid value of an argument is passed
 */
class OperandValueErrorException extends IPPException {
    public function __construct(?\Throwable $previous = null, bool $showTrace = true) {
        parent::__construct("Invalid value of an argument passed", ReturnCode::OPERAND_VALUE_ERROR, $previous, $showTrace);
    }
}
