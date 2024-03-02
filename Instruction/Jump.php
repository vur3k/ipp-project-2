<?php

namespace IPP\Student\Instruction;

use IPP\Core\ReturnCode;
use IPP\Student\Factory;

class Jump extends Instruction {
    public function __construct(\DOMElement $instruction) {
        parent::__construct($instruction, 1);
    }

    public function execute(): void {
        $label = $this->getArg(1);

        if (!$label->isLabel()){
            exit(ReturnCode::OPERAND_TYPE_ERROR);
        }
        Factory::setInstructionPointer(InstructionList::getLabelLine($label->getValue()));
    }
}
