<?php
/**
 * IPP Project II.
 * @brief IPPCode24 language interpreter
 * @package IPP\Student\Exception
 * @file student/Exception/SemanticErrorException.php
 * @author Vaclav Pribyl <xpriby22@stud.fit.vutbr.cz>
 * @date 14-04-2024
 */
namespace IPP\Student\Exception;

use IPP\Core\Exception\IPPException;
use IPP\Core\ReturnCode;

/**
 * Exception thrown when an expression has invalid syntax
 */
class SemanticErrorException extends IPPException {
    public function __construct(?\Throwable $previous = null, bool $showTrace = true) {
        parent::__construct("Expression has invalid syntax", ReturnCode::SEMANTIC_ERROR, $previous, $showTrace);
    }
}
