<?php

namespace IPP\Student\Instruction;

use IPP\Student\Argument\Argument;
use IPP\Student\DataStack;
use IPP\Student\Exception\OperandTypeErrorException;

class AddS extends Instruction {
    public function __construct(\DOMElement $instruction) {
        parent::__construct($instruction, 0);
    }

    public function execute(): int {
        $arg2 = DataStack::popData();
        $arg1 = DataStack::popData();

        if ($arg1->isInt() && $arg2->isInt()) {
            DataStack::pushData(new Argument($arg1->getValue() + $arg2->getValue(), 'int'));
        }
        else {
            throw new OperandTypeErrorException();
        }
        return parent::execute();
    }
}
