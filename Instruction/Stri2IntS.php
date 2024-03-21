<?php

namespace IPP\Student\Instruction;

use IPP\Core\ReturnCode;
use IPP\Student\Argument\Argument;
use IPP\Student\DataStack;
use IPP\Student\Exception\OperandTypeErrorException;
use IPP\Student\Exception\StringOperationErrorException;
use Spaze\PHPStan\Rules\Disallowed\Exceptions\NotImplementedYetException;

class Stri2IntS extends Instruction {
    public function __construct(\DOMElement $instruction) {
        parent::__construct($instruction, 0);
    }

    public function execute(): int {
        $arg2 = DataStack::popData();
        $arg1 = DataStack::popData();

        if ($arg1->isString() && $arg2->isInt()) {
            $arg2 = $arg2->getValue();
            $arg1 = $arg1->getValue();
            if ($arg2 >= strlen($arg1) || $arg2 < 0) {
                throw new StringOperationErrorException();
            }
            $ord = mb_ord($arg1[$arg2], 'UTF-8');
            if (!$ord) {
                throw new StringOperationErrorException();
            }
            DataStack::pushData(new Argument($ord, 'int'));
        }
        else {
            throw new OperandTypeErrorException();
        }
        return parent::execute();
    }
}
