<?php

namespace IPP\Student\Instruction;

use IPP\Core\ReturnCode;
use IPP\Student\Argument\Argument;
use IPP\Student\DataStack;

class LtS extends Instruction {
    public function __construct(\DOMElement $instruction) {
        parent::__construct($instruction, 0);
    }

    public function execute (): void {
        $arg2 = DataStack::popData();
        $arg1 = DataStack::popData();

        if ($arg1->getType() === $arg2->getType() && $arg1->isNonNilConst()) {
            DataStack::pushData(new Argument($arg1->getValue() < $arg2->getValue() ? 'true' : 'false', 'bool'));
        }
        else {
            exit(ReturnCode::OPERAND_TYPE_ERROR);
        }
    }
}