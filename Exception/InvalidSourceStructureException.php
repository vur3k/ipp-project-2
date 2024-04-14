<?php
/**
 * IPP Project II.
 * @brief IPPCode24 language interpreter
 * @package IPP\Student\Exception
 * @file student/Exception/InvalidSourceStructureException.php
 * @author Vaclav Pribyl <xpriby22@stud.fit.vutbr.cz>
 * @date 14-04-2024
 */
namespace IPP\Student\Exception;

use IPP\Core\Exception\IPPException;
use IPP\Core\ReturnCode;

/**
 * Exception thrown when the passed XML file has invalid structure
 */
class InvalidSourceStructureException extends IPPException {
    public function __construct(?\Throwable $previous = null, bool $showTrace = true) {
        parent::__construct("Passed XML file has invalid structure", ReturnCode::INVALID_SOURCE_STRUCTURE, $previous, $showTrace);
    }
}
