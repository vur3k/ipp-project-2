<?php

namespace IPP\Student\Instruction;

use IPP\Core\ReturnCode;
use IPP\Student\Argument\Argument;
use IPP\Student\DataStack;
use IPP\Student\Factory;

class Call extends Instruction {
    public function __construct(\DOMElement $instruction) {
        parent::__construct($instruction, 1);
    }

    public function execute(): void {
        $val = $this->getArg(1);
        if (!$val->isLabel()) {
            exit(ReturnCode::OPERAND_TYPE_ERROR);
        }
        $jumpAt = InstructionList::getLabelLine($val->getValue());
        DataStack::pushData(new Argument($this->getOrder(), 'int'));
        Factory::setInstructionPointer($jumpAt);
    }
}