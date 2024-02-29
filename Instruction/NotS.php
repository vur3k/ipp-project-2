<?php

namespace IPP\Student\Instruction;

use IPP\Core\ReturnCode;
use IPP\Student\Argument;
use IPP\Student\DataStack;

class NotS extends Instruction {
    public function __construct(\DOMElement $instruction) {
        parent::__construct($instruction, 0);
    }

    public function execute(): void {
        $arg1 = DataStack::popData();
        if ($arg1->isBool()) {
            DataStack::pushData(new Argument(!$arg1->getValue(), 'bool'));
        }
        else {
            exit(ReturnCode::OPERAND_TYPE_ERROR);
        }
    }
}