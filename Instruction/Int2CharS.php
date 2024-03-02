<?php

namespace IPP\Student\Instruction;

use IPP\Core\ReturnCode;
use IPP\Student\Argument\Argument;
use IPP\Student\DataStack;

class Int2CharS extends Instruction {
    public function __construct(\DOMElement $instruction) {
        parent::__construct($instruction, 0);
    }

    public function execute(): void {
        $arg = DataStack::popData();
        if ($arg->isInt()) {
            $char = mb_chr($arg->getValue(), 'UTF-8');
            if (!$char) {
                exit(ReturnCode::STRING_OPERATION_ERROR);
            }
            DataStack::pushData(new Argument($char, 'string'));
        }
        else {
            exit(ReturnCode::OPERAND_TYPE_ERROR);
        }
    }
}