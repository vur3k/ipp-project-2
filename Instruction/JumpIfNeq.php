<?php

namespace IPP\Student\Instruction;

use IPP\Core\ReturnCode;
use IPP\Student\Factory;
use IPP\Student\Variable;

class JumpIfNeq extends Instruction {
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
            if ($arg2->getType() == $arg3->getType() || $arg2->isNil() || $arg3->isNil()) {
                if ($arg2->getValue() !== $arg3->getValue()) {
                    Factory::setInstructionPointer($label);
                }
            }
            else {
                exit(ReturnCode::OPERAND_TYPE_ERROR);
            }
        }
        else {
            exit(ReturnCode::OPERAND_TYPE_ERROR);
        }
    }
}