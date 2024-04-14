<?php
/**
 * IPP Project II.
 * @brief IPPCode24 language interpreter
 * @package IPP\Student\Instruction
 * @file JumpIfEqS.php
 * @author Vaclav Pribyl <xpriby22@stud.fit.vutbr.cz>
 * @date 14-04-2024
 */
namespace IPP\Student\Instruction;

use IPP\Student\DataStack;
use IPP\Student\Exception\OperandTypeErrorException;
use IPP\Student\Factory;

/**
 * Class representing the JUMPIFEQS instruction
 */
class JumpIfEqS extends AbstractInstruction {
    public function __construct(\DOMElement $instruction) {
        parent::__construct($instruction, 1);
    }

    public function execute(): void {
        $label = $this->getArg(1);

        if ($label->isLabel()) {
            $label = InstructionList::getLabelLine($label->getValue());
            $arg2 = DataStack::popData();
            $arg1 = DataStack::popData();
            if (!$arg1->isConst() || !$arg2->isConst()) {
                throw new OperandTypeErrorException();
            }
            if ($arg1->getType() == $arg2->getType() || $arg1->isNil() || $arg2->isNil()) {
                if ($arg1->getValue() === $arg2->getValue()) {
                    Factory::setInstructionPointer($label);
                }
            }
            else {
                throw new OperandTypeErrorException();
            }
        }
        else {
            throw new OperandTypeErrorException();
        }
    }
}
