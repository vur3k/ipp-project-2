<?php

namespace IPP\Student\Instruction;

use IPP\Student\DataStack;
use IPP\Student\Factory;

class ReturnOp extends AbstractInstruction {
    public function __construct(\DOMElement $instruction) {
        parent::__construct($instruction, 0);
    }

    public function execute(): void {
        Factory::setInstructionPointer(DataStack::popData()->getValue());
    }
}
