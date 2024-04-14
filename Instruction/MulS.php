<?php
/**
 * IPP Project II.
 * @brief IPPCode24 language interpreter
 * @package IPP\Student\Instruction
 * @file MulS.php
 * @author Vaclav Pribyl <xpriby22@stud.fit.vutbr.cz>
 * @date 14-04-2024
 */
namespace IPP\Student\Instruction;

use IPP\Student\Argument\Argument;
use IPP\Student\DataStack;
use IPP\Student\Exception\OperandTypeErrorException;

/**
 * Class representing the MULS instruction
 */
class MulS extends AbstractInstruction {
    public function __construct(\DOMElement $instruction) {
        parent::__construct($instruction, 0);
    }

    public function execute(): void {
        $arg2 = DataStack::popData();
        $arg1 = DataStack::popData();

        if ($arg1->isInt() && $arg2->isInt()) {
            DataStack::pushData(new Argument($arg1->getValue() * $arg2->getValue(), 'int'));
        }
        else {
            throw new OperandTypeErrorException();
        }
    }
}
