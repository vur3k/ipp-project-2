<?php

namespace IPP\Student\Instruction;

use IPP\Student\Argument\Argument;
use IPP\Student\DataStack;
use IPP\Student\Exception\OperandTypeErrorException;
use IPP\Student\Factory;

class Call extends Instruction {
    public function __construct(\DOMElement $instruction) {
        parent::__construct($instruction, 1);
    }

    public function execute(): int {
        $val = $this->getArg(1);

        if (!$val->isLabel()) {
            throw new OperandTypeErrorException();
        }
        $label = InstructionList::getLabelLine($val->getValue());
        DataStack::pushData(new Argument($this->getOrder(), 'int'));
        Factory::setInstructionPointer($label);
        return parent::execute();
    }
}
