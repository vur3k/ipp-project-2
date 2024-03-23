<?php

namespace IPP\Student\Instruction;

use IPP\Student\Argument\Argument;
use IPP\Student\DataStack;
use IPP\Student\Exception\OperandTypeErrorException;
use IPP\Student\Exception\StringOperationErrorException;

class Int2CharS extends Instruction {
    public function __construct(\DOMElement $instruction) {
        parent::__construct($instruction, 0);
    }

    public function execute(): int {
        $arg = DataStack::popData();

        if ($arg->isInt()) {
            $char = mb_chr($arg->getValue(), 'UTF-8');
            if (!$char) {
                throw new StringOperationErrorException();
            }
            DataStack::pushData(new Argument($char, 'string'));
        }
        else {
            throw new OperandTypeErrorException();
        }
        return parent::execute();
    }
}
