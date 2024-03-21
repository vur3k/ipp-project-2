<?php

namespace IPP\Student\Instruction;

use IPP\Student\DataStack;
use IPP\Student\Factory;

class ReturnOp extends Instruction {
    public function __construct(\DOMElement $instruction) {
        parent::__construct($instruction, 0);
    }

    public function execute(): int {
        Factory::setInstructionPointer(DataStack::popData()->getValue());
        return parent::execute();
    }
}
