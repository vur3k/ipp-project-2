<?php
/**
 * IPP Project II.
 * @brief IPPCode24 language interpreter
 * @package IPP\Student\Instruction
 * @file student/Instruction/EqS.php
 * @author Vaclav Pribyl <xpriby22@stud.fit.vutbr.cz>
 * @date 14-04-2024
 */
namespace IPP\Student\Instruction;

use IPP\Student\Argument\Argument;
use IPP\Student\DataStack;
use IPP\Student\Exception\OperandTypeErrorException;

/**
 * Class representing the EQS instruction
 */
class EqS extends AbstractInstruction {
    public function __construct(\DOMElement $instruction) {
        parent::__construct($instruction, 0);
    }

    public function execute(): void {
        $arg2 = DataStack::popData();
        $arg1 = DataStack::popData();

        if (($arg1->getType() === $arg2->getType() || $arg1->isNil() || $arg2->isNil()) && $arg1->isConst() && $arg2->isConst()) {
            DataStack::pushData(new Argument($arg1->getValue() === $arg2->getValue() ? 'true' : 'false', 'bool'));
        }
        else {
            throw new OperandTypeErrorException();
        }
    }
}
