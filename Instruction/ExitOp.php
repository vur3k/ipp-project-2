<?php

namespace IPP\Student\Instruction;

use IPP\Core\ReturnCode;
use IPP\Student\Argument\Argument;
use IPP\Student\Argument\Variable;
use IPP\Student\Exception\OperandTypeErrorException;
use IPP\Student\Exception\OperandValueErrorException;
use IPP\Student\Exception\ValueErrorException;

class ExitOp extends Instruction {
    public function __construct(\DOMElement $instruction) {
        parent::__construct($instruction, 1);
    }

    public function execute(): int {
        /**
         * @var Variable|Argument $arg
         */
        $arg = $this->getArg(1);

        if ($arg instanceof Variable) {
            $arg = $arg->getVarAsConst();
        }
        if ($arg->isInt()) {
            if ($arg->getValue() >= 0 && $arg->getValue() <= 9) {
                return $arg->getValue();
            }
            throw new OperandValueErrorException();
        }
        throw new OperandTypeErrorException();
    }
}
