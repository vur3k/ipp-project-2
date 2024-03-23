<?php

namespace IPP\Student\Instruction;

use IPP\Student\Argument\Argument;
use IPP\Student\DataStack;
use IPP\Student\Exception\OperandTypeErrorException;

class NotS extends Instruction {
    public function __construct(\DOMElement $instruction) {
        parent::__construct($instruction, 0);
    }

    public function execute(): int {
        $arg1 = DataStack::popData();
        if ($arg1->isBool()) {
            DataStack::pushData(new Argument(!$arg1->getValue() ? 'true' : 'false', 'bool'));
        }
        else {
            throw new OperandTypeErrorException();
        }
        return parent::execute();
    }
}
