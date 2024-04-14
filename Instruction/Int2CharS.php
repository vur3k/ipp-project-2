<?php
/**
 * IPP Project II.
 * @brief IPPCode24 language interpreter
 * @package IPP\Student\Instruction
 * @file Int2CharS.php
 * @author Vaclav Pribyl <xpriby22@stud.fit.vutbr.cz>
 * @date 14-04-2024
 */
namespace IPP\Student\Instruction;

use IPP\Student\Argument\Argument;
use IPP\Student\DataStack;
use IPP\Student\Exception\OperandTypeErrorException;
use IPP\Student\Exception\StringOperationErrorException;

/**
 * Class representing the INT2CHARS instruction
 */
class Int2CharS extends AbstractInstruction {
    public function __construct(\DOMElement $instruction) {
        parent::__construct($instruction, 0);
    }

    public function execute(): void {
        $arg = DataStack::popData();

        if ($arg->isInt()) {
            $char = mb_chr($arg->getValue(), 'UTF-8');
            if (!$char) {
                throw new StringOperationErrorException();
            }
            DataStack::pushData(new Argument($char, 'string'));
        }
        else {
            throw new OperandTypeErrorException();
        }
    }
}
