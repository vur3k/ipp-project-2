<?php

namespace IPP\Student\Instruction;

use IPP\Core\ReturnCode;
use IPP\Student\DataStack;
use IPP\Student\Factory;

class JumpIfNeqS extends Instruction {
    public function __construct(\DOMElement $instruction) {
        parent::__construct($instruction, 1);
    }

    public function execute(): void {
        $label =$this->getArg(1);
        if ($label->isLabel()) {
            $label = InstructionList::getLabelLine($label->getValue());
            $arg2 = DataStack::popData();
            $arg1 = DataStack::popData();
            if ($arg1->getType() == $arg2->getType() || $arg1->isNil() || $arg2->isNil()) {
                if ($arg1->getValue() !== $arg2->getValue()) {
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
