<?php

namespace IPP\Student\Instruction;

use IPP\Student\Exception\OperandTypeErrorException;
use IPP\Student\Factory;

class Jump extends Instruction {
    public function __construct(\DOMElement $instruction) {
        parent::__construct($instruction, 1);
    }

    public function execute(): int {
        $label = $this->getArg(1);

        if (!$label->isLabel()){
            throw new OperandTypeErrorException();
        }
        Factory::setInstructionPointer(InstructionList::getLabelLine($label->getValue()));
        return parent::execute();
    }
}
