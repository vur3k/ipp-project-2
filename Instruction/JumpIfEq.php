<?php
/**
 * IPP Project II.
 * @brief IPPCode24 language interpreter
 * @package IPP\Student\Instruction
 * @file JumpIfEq.php
 * @author Vaclav Pribyl <xpriby22@stud.fit.vutbr.cz>
 * @date 14-04-2024
 */
namespace IPP\Student\Instruction;

use IPP\Student\Argument\Variable;
use IPP\Student\Exception\OperandTypeErrorException;
use IPP\Student\Factory;

/**
 * Class representing the JUMPIFEQ instruction
 */
class JumpIfEq extends AbstractInstruction {
    public function __construct(\DOMElement $instruction) {
        parent::__construct($instruction, 3);
    }

    public function execute(): void {
        $arg1 = $this->getArg(1);
        $arg2 = $this->getArg(2);
        $arg3 = $this->getArg(3);

        if ($arg1->isLabel()) {
            $label = InstructionList::getLabelLine($arg1->getValue());
            if ($arg2 instanceof Variable) {
                $arg2 = $arg2->getVarAsConst();
            }
            if ($arg3 instanceof Variable) {
                $arg3 = $arg3->getVarAsConst();
            }
            if (!$arg2->isConst() || !$arg3->isConst()) {
                throw new OperandTypeErrorException();
            }
            if ($arg2->getType() == $arg3->getType() || $arg2->isNil() || $arg3->isNil()) {
                if ($arg2->getValue() === $arg3->getValue()) {
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
